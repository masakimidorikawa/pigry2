<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'date',
        'weight',
        'calories',
        'exercise_time',
        'exercise_detail',
    ];
}

