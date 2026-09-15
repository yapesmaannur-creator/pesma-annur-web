<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'avatar',
        'bio',
        'social_fb',
        'social_ig',
        'social_x',
        'social_linkedin',
        'social_scholar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->role, ['admin', 'editor']);
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'editor']);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Super Admin',
            'editor' => 'Dewan Redaksi',
            'pengasuh' => 'Pengasuh',
            'ustadz' => 'Asatidz',
            'pengurus' => 'Pengurus Pesantren',
            'santri' => 'Santri',
            'alumni' => 'Alumni',
            'kontributor' => 'Kontributor',
            default => ucfirst($this->role),
        };
    }
}
