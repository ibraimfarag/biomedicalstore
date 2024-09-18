<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['part_number', 'definition', 'active'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
