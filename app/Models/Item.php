<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'rarity',
        'required_level',
        'power',
        'speed',
        'durability',
        'magic',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function tradeOfferedItems()
    {
        return $this->hasMany(TradeOfferedItem::class);
    }

    public function tradeRequestedItems()
    {
        return $this->hasMany(TradeRequestedItem::class);
    }
}
