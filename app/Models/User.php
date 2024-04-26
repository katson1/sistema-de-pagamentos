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
        'cpf_cnpj',
        'user_type',
        'balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->attributes['balance'];
    }

    /**
     * @return string
     */
    public function getType(): bool
    {
        return $this->attributes['user_type'];
    }
}
