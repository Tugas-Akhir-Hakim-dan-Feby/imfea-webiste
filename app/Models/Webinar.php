<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Webinar extends Model
{
    use HasFactory;

    const DRAFT = 0;

    const PUBLISH = 1;

    protected $fillable = [
        "user_id",
        "title",
        "slug",
        "description",
        "url",
        "status",
        "activity_date",
        "activity_time",
    ];

    protected $hidden = [
        "user_id"
    ];

    public function getImageAttribute()
    {
        return route('web.webinar.background', $this->id);
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function participant(): HasOne
    {
        return $this->hasOne(WebinarParticipant::class, 'webinar_id', 'id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(WebinarParticipant::class, 'webinar_id', 'id');
    }

    public function webinarParticipant(): HasOne
    {
        return $this->hasOne(WebinarParticipant::class, 'webinar_id', 'id')
            ->where('user_id', auth()->user()->id);
    }
}
