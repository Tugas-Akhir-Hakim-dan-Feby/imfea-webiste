<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    const ADMIN_APP = "Admin Aplikasi";
    const OPERATOR = "Operator";
    const KORWIL = "Koordinator Wilayah";
    const MEMBER_APP = "Member Aplikasi";
    const MEMBER = "Pengguna Aplikasi";
}
