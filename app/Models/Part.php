<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Part extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'specifications',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'specifications' => 'array',
    ];

    /**
     * Get the category that owns the part.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(PartCategory::class, 'category_id');
    }

    /**
     * Get all order items that include this part.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the full URL for the part image.
     * - Returns default image if no image set
     * - Handles both local storage and external URLs
     * - Automatically corrects path formatting
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        // Return default image if no image path exists
        if (!$this->image) {
            return asset('images/default-part.png');
        }

        // For external URLs (http/https), return as-is
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // For local storage, ensure proper path formatting
        $cleanPath = ltrim($this->image, '/');

        // Generate full URL for locally stored images
        return asset('storage/'.$cleanPath);
    }

    /**
     * Check if the part has a valid image.
     * - Returns false if no image set
     * - Always returns true for external URLs
     * - Checks file existence for local storage
     *
     * @return bool
     */
    public function hasImage()
    {
        if (!$this->image) {
            return false;
        }

        // Consider external URLs as always valid
        if (str_starts_with($this->image, 'http')) {
            return true;
        }

        // Check file existence in local storage
        return Storage::disk('public')->exists($this->image);
    }
}
