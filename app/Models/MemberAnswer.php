<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "type",
        "user_id",
        "exam_id",
        "answer",
    ];
}
