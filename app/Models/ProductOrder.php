<?php

namespace App\Models;

use Database\Factories\ProductOrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProductOrder extends Model
{
    /** @use HasFactory<ProductOrderFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_SERVED = 'served';

    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Statuses of an order that is still "open": while a client has an open
     * order for a product, they cannot order that same product again.
     */
    public const OPEN_STATUSES = [self::STATUS_PENDING, self::STATUS_CONFIRMED];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reference',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
        'total_price',
        'client_name',
        'client_email',
        'client_phone',
        'notes',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    /**
     * Give every new order a short, hard-to-guess reference (e.g. CMD-7KQ2M9XA),
     * used as its public number and in the confirmation link.
     */
    protected static function booted(): void
    {
        static::creating(function (self $order) {
            if (! $order->reference) {
                do {
                    $reference = 'CMD-'.Str::upper(Str::random(8));
                } while (self::where('reference', $reference)->exists());

                $order->reference = $reference;
            }
        });
    }

    /**
     * Normalise the email so "Marie@Mail.com" and "marie@mail.com " are the same client.
     */
    public function setClientEmailAttribute(?string $value): void
    {
        $this->attributes['client_email'] = mb_strtolower(trim((string) $value));
    }

    /**
     * The ordered product (null if it was deleted since).
     *
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Orders that have not been served nor cancelled yet.
     *
     * @param  Builder<ProductOrder>  $query
     */
    public function scopeOpen(Builder $query): void
    {
        $query->whereIn('status', self::OPEN_STATUSES);
    }

    /**
     * Whether this order is still waiting to be served.
     */
    public function isOpen(): bool
    {
        return in_array($this->status, self::OPEN_STATUSES, true);
    }

    /**
     * Only keep the digits of a phone number (+33 6 12.., 06-12.. → comparable).
     */
    public static function normalizePhone(?string $phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        // French numbers: "33612345678" and "0612345678" are the same line.
        if (str_starts_with($digits, '33') && strlen($digits) === 11) {
            $digits = '0'.substr($digits, 2);
        }

        return $digits;
    }

    /**
     * The open order the same client (same email, or same phone number)
     * already has for this product, if any.
     */
    public static function findOpenFor(int $productId, string $email, string $phone): ?self
    {
        $email = mb_strtolower(trim($email));
        $phone = self::normalizePhone($phone);

        return self::query()
            ->open()
            ->where('product_id', $productId)
            ->get()
            ->first(fn (self $order) => $order->client_email === $email
                || ($phone !== '' && self::normalizePhone($order->client_phone) === $phone));
    }

    /**
     * All available statuses, for display.
     *
     * @return array<string, string>
     */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'En attente',
            self::STATUS_CONFIRMED => 'Confirmée',
            self::STATUS_SERVED => 'Servie',
            self::STATUS_CANCELLED => 'Annulée',
        ];
    }

    /**
     * Human readable status.
     */
    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }
}
