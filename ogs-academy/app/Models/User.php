<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER  = 'superadmin';
    public const ROLE_ADMIN  = 'admin';
    public const ROLE_EDITOR = 'editor';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'password',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'last_login_at'     => 'datetime',
        ];
    }

    public function isSuperAdmin(): bool { return $this->role === self::ROLE_SUPER; }
    public function isAdmin(): bool      { return in_array($this->role, [self::ROLE_SUPER, self::ROLE_ADMIN]); }
    public function isEditor(): bool     { return in_array($this->role, [self::ROLE_SUPER, self::ROLE_ADMIN, self::ROLE_EDITOR]); }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) return asset('storage/' . $this->avatar);
        $hash = md5(strtolower(trim((string) $this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=120";
    }
}
