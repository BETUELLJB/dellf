<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_identifier',
        'ip_address',
        'mac_address',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
