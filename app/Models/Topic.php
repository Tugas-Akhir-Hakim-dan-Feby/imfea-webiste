<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    const DRAFT = 0;

    const PUBLISH = 1;

    protected $fillable = [
        "training_id",
        "title",
        "slug",
        "status",
    ];
}
