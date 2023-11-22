<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'topic_id', 'id');
    }
}
