<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetQrCode extends Model
{
    protected $fillable = ['uid', 'user_id', 'is_active'];
    protected $casts = [
        'uid' => 'string',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
