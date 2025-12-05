<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    // Role constants
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    const ROLE_STAFF = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'password',
        'phone_number',
        'avatar',
        'status',
        'is_admin',
        'role',
        'verification_token',
        'token_expires_at',
        'is_verified', 
        'salary',
        'hire_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getRoleNameAttribute()
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_STAFF => 'Staff',
            self::ROLE_USER => 'User',
            default => 'User'
        };
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Dynamic RBAC relations (Phase 2)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }
}
