<?php

namespace App\Models;

use App\Http\Facades\Region\City;
use App\Http\Facades\Region\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "work_type_id",
        "province_id",
        "city_id",
        "nin",
        "gender",
        "place_birth",
        "date_birth",
        "citizenship",
        "address",
        "postal_code",
        "phone",
        "pas_photo",
        "cv",
    ];

    public function pathPasPhoto()
    {
        return 'assets/images/pas_photo/' . date('dmY');
    }

    public function pathCv()
    {
        return 'assets/images/cv/' . date('dmY');
    }

    public function getProvinceAttribute()
    {
        return Province::show($this->attributes['province_id']);
    }

    public function getCityAttribute()
    {
        return City::show($this->attributes['city_id']);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the workType associated with the Membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workType(): HasOne
    {
        return $this->hasOne(WorkType::class, 'id', 'work_type_id');
    }
}
