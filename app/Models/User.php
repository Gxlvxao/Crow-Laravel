<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'developer_id',
        'can_view_all_properties', // NOVO
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'can_view_all_properties' => 'boolean', // NOVO
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canManageProperties(): bool
    {
        return in_array($this->role, ['admin', 'developer']);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(User::class, 'developer_id');
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function accessibleProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_access', 'user_id', 'property_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }
}