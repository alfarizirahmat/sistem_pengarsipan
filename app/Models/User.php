<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'jabatan', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    public function isKetuaRt(): bool
    {
        return $this->role === 'ketua_rt';
    }

    public function isSekretaris(): bool
    {
        return in_array($this->role, ['sekretaris', 'ketua_rt']);
    }

    public function isBendahara(): bool
    {
        return in_array($this->role, ['bendahara', 'ketua_rt']);
    }

    public function isHumas(): bool
    {
        return in_array($this->role, ['humas', 'ketua_rt']);
    }

    public function isKeamanan(): bool
    {
        return in_array($this->role, ['keamanan', 'ketua_rt']);
    }
}
