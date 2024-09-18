<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_number',
        'definition',
        'qty',
        'date',
        'biomed_id',
        'department',
        'reason',
        'work_order_number',
        'left_in_stock',
        'status',
        'qty_id'
    ];
    public function biomed()
    {
        return $this->belongsTo(User::class, 'biomed_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'part_number', 'part_number');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'qty_id');
    }
}
