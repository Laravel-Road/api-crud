<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use App\Models\Traits\RequestQueryBuildable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use HasUser;
    use RequestQueryBuildable;

    protected $guarded = ['id'];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public static function searchable(): array
    {
        return [
            'name' => 'like',
            'expired_at' => '<',
            'user_id' => '=',
        ];
    }
}
