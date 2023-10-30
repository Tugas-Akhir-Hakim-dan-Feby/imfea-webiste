<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

    const PENDING = "Belum Dibayar";

    const SUCCESS = "Lunas";

    const CANCEL = "Dibatalkan";

    protected $fillable = [
        "user_id",
        "external_id",
        "payment_method",
        "payment_url",
        "amount",
        "status",
        "description",
        "recreated_at",
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
