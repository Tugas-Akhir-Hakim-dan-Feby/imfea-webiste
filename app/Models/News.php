<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    const ACTIVE = 1;

    const NON_ACTIVE = 0;

    protected $fillable = [
        "user_id",
        "title",
        "slug",
        "content",
        "status",
        "thumbnail",
    ];

    protected $hidden = [
        "user_id"
    ];

    public static function pathImageContent()
    {
        return 'assets/images/image-content/' . date('dmY');
    }

    public static function pathImageThumbnail()
    {
        return 'assets/images/thumbnail/' . date('dmY');
    }

    public function getThumbnailAttribute($image)
    {
        if ($image && File::exists(public_path($image))) {
            return asset($image);
        }

        return asset('assets/images/image-not-found.png');
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
