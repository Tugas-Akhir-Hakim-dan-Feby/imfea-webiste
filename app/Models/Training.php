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
}
