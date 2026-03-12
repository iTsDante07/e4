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

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sentTrades()
    {
        return $this->hasMany(Trade::class, 'sender_id');
    }

    public function receivedTrades()
    {
        return $this->hasMany(Trade::class, 'receiver_id');
    }
    
}
