<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exam extends Model
{
    use HasFactory;

    const TYPE_MULTIPLE_CHOICE = 0;
    const TYPE_ESSAY = 1;

    const EXAM_ACTIVE = 1;
    const EXAM_NONACTIVE = 0;

    protected $fillable = [
        "training_id",
        "exam_answer_id",
        "type",
        "question",
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class, 'exam_id', 'id');
    }

    public function correctAnswer(): HasOne
    {
        return $this->hasOne(ExamAnswer::class, 'id', 'exam_answer_id');
    }

    public function memberAnswerByAuth() : HasOne
    {
        return $this->hasOne(MemberAnswer::class, 'exam_id', 'id')
        ->where('user_id', auth()->user()->id);
    }
}
