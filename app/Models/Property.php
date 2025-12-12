<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Database\Eloquent\SoftDeletes; <--- REMOVIDO

class Property extends Model
{
    use HasFactory; // SoftDeletes REMOVIDO

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'cover_image',
        'type',
        'transaction_type',
        'condition',
        'price',
        'city',
        'district',
        'address',
        'postal_code',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'area',
        'land_area',
        'year_built',
        'energy_rating',
        'video_url',
        'whatsapp',
        'features',
        'images',
        'status',
        'is_exclusive',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_exclusive' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function allowedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'property_access', 'property_id', 'user_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }

    public function scopeVisibleForUser($query, User $user)
    {
        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->role === 'developer') {
            return $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('status', 'active');
            });
        }

        return $query->where(function ($q) use ($user) {
            $q->whereHas('allowedUsers', function ($access) use ($user) {
                $access->where('user_id', $user->id);
            });

            if ($user->can_view_all_properties) {
                $q->orWhere('status', 'active');
            }
        });
    }

    public function scopePublic($query)
    {
        return $query->where('is_exclusive', false)
                    ->where('status', 'active');
    }

    public function scopeExclusive($query)
    {
        return $query->where('is_exclusive', true)
                    ->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where('status', 'active');
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByTransactionType($query, $transactionType)
    {
        return $query->where('transaction_type', $transactionType);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeByBedrooms($query, $bedrooms)
    {
        return $query->where('bedrooms', '>=', $bedrooms);
    }

    public function isPublished(): bool
    {
        return $this->status === 'active';
    }

    public function isExclusive(): bool
    {
        return $this->is_exclusive;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '€ ' . number_format($this->price, 0, ',', '.');
    }

    public function getFirstImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }
    
    public function getVideoEmbedAttribute(): ?string
    {
        if (!$this->video_url) return null;

        if (str_contains($this->video_url, 'youtube.com') || str_contains($this->video_url, 'youtu.be')) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
            return isset($matches[1]) ? "https://www.youtube.com/embed/{$matches[1]}" : null;
        }

        if (str_contains($this->video_url, 'vimeo.com')) {
            $videoId = (int) substr(parse_url($this->video_url, PHP_URL_PATH), 1);
            return "https://player.vimeo.com/video/{$videoId}";
        }

        return null;
    }

    public function getWhatsappLinkAttribute(): ?string
    {
        if (!$this->whatsapp) return null;
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/{$number}?text=" . urlencode("Olá, vi o imóvel '{$this->title}' no portal Crow Global e gostaria de mais informações.");
    }
}