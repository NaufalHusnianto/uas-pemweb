<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressSelected extends Model
{
    protected $fillable = ['user_id', 'address_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
