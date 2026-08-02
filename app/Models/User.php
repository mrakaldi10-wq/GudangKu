<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Lawan bicara yang boleh diajak chat.
     * Admin hanya bisa chat dengan Atasan, dan sebaliknya.
     */
    public function chatPartners()
    {
        // admin chat dengan pemilik & petugas gudang, selain admin chat dengan admin
        if ($this->role === 'admin') {
            return static::where('role', '!=', 'admin')->orderBy('name')->get();
        }

        return static::where('role', 'admin')->orderBy('name')->get();
    }
    
    
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugasGudang(): bool
    {
        return $this->role === 'petugas_gudang';
    }

    public function isPemilik(): bool
    {
        return $this->role === 'pemilik';
    }
}
