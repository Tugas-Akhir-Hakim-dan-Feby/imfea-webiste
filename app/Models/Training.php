<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\File;

class Training extends Model
{
    use HasFactory;

    const DRAFT = 0;

    const PUBLISH = 1;

    protected $fillable = [
        "user_id",
        "title",
        "slug",
        "thumbnail",
        "content",
        "exam_active",
        "status",
        "url",
        "start_date",
        "end_date",
    ];

    public static function pathImageThumbnail()
    {
        return 'assets/images/training/thumbnail/' . date('dmY');
    }

    public function getThumbnailAttribute($image)
    {
        if ($image && File::exists(public_path($image))) {
            return asset($image);
        }

        return asset('assets/images/image-not-found.png');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'training_id', 'id');
    }

    public function topicMaterials(): HasMany
    {
        return $this->hasMany(Topic::class, 'training_id', 'id')->where('is_exam', Topic::IS_MATERIAL);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class, 'training_id', 'id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'training_id', 'id');
    }

    public function participant(): HasOne
    {
        return $this->hasOne(TrainingParticipant::class, 'training_id', 'id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(TrainingParticipant::class, 'training_id', 'id');
    }

    public function trainingParticipant(): HasOne
    {
        return $this->hasOne(TrainingParticipant::class, 'training_id', 'id')
            ->where('user_id', auth()->user()->id);
    }
}
