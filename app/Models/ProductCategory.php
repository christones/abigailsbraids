<?php

namespace App\Models;

use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    /** @use HasFactory<ProductCategoryFactory> */
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
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the products that belong to this category.
     *
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Categories shown on the public site: active, and containing at least
     * one active product (an empty category would lead to an empty page).
     *
     * @param  Builder<ProductCategory>  $query
     */
    public function scopeVisible(Builder $query): void
    {
        $query->where('is_active', true)
            ->whereHas('products', fn (Builder $products) => $products->where('is_active', true))
            ->withCount(['products' => fn (Builder $products) => $products->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * The picture representing this category: its own photo, or else the
     * photo of its first visible product, or null if neither exists.
     */
    public function coverImagePath(): ?string
    {
        if ($this->image_path) {
            return $this->image_path;
        }

        return $this->products()
            ->where('is_active', true)
            ->whereNotNull('image_path')
            ->orderBy('sort_order')
            ->value('image_path');
    }
}
