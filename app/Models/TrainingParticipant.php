<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingParticipant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ["user_id", "training_id", "check_in_exam", "check_out_exam","grade_exam"];

    public $timestamps = false;

    /**
     * Get the user associated with the TrainingParticipant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get all of the memberAnswers for the TrainingParticipant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memberAnswers(): HasMany
    {
        return $this->hasMany(MemberAnswer::class, 'user_id', 'user_id');
    }
}
