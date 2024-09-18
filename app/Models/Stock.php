<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'quantity'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'part_number', 'part_number');
    }

}
