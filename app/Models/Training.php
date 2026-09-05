<?php

namespace App\Models;

use Database\Factories\TrainingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    /** @use HasFactory<TrainingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'level',
        'duration_minutes',
        'price_from',
        'image_path',
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
            'price_from' => 'decimal:2',
            'duration_minutes' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the registrations made for this training.
     *
     * @return HasMany<TrainingRegistration, $this>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(TrainingRegistration::class);
    }

    /**
     * Human readable duration, e.g. "2 jours".
     */
    public function durationLabel(): string
    {
        $hours = intdiv($this->duration_minutes, 60);

        if ($hours <= 7) {
            return $hours.'h';
        }

        $days = (int) round($hours / 7);

        return $days > 1 ? $days.' jours' : '1 jour';
    }
}
