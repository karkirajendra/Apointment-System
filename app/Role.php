<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'role_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'role_id');
    }

    public function businessOwners()
    {
        return $this->hasMany(BusinessOwner::class, 'role_id');
    }
}

