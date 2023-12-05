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

    const IS_EXAM = 1;

    const IS_MATERIAL = 0;

    protected $fillable = [
        "training_id",
        "title",
        "slug",
        "status",
        "is_exam"
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'topic_id', 'id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class, 'topic_id', 'id');
    }
}
