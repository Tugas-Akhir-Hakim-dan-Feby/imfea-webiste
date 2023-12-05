<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;

    const DRAFT = 0;

    const PUBLISH = 1;

    protected $fillable = [
        "training_id",
        "topic_id",
        "title",
        "slug",
        "link_video",
        "content",
        "status",
    ];

    public function topic(): HasOne
    {
        return $this->hasOne(Topic::class, 'id', 'topic_id');
    }

    public function visitor(): HasOne
    {
        return $this->hasOne(CourseVisitor::class, 'course_id', 'id');
    }

    public function courseVisitor(): HasOne
    {
        return $this->hasOne(CourseVisitor::class, 'course_id', 'id')
            ->where('user_id', auth()->user()->id);
    }
}
