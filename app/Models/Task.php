<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use HasUser;

    protected $guarded = ['id'];

    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
