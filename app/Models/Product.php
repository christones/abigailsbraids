<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'stock_quantity',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the category this product belongs to (null = non classé).
     *
     * @return BelongsTo<ProductCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Orders placed for this product from the shop.
     *
     * @return HasMany<ProductOrder, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }

    /**
     * Whether the product is currently in stock.
     */
    public function inStock(): bool
    {
        return $this->stock_quantity > 0;
    }
}
