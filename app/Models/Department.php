<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'role_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'department_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'department_role');
    }
}
