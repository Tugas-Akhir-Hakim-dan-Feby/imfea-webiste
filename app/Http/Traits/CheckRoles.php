<?php

namespace App\Http\Traits;

use App\Models\User;

trait CheckRoles
{
    public function isAdminApp()
    {
        if ($this->roles[0]->id == User::ADMIN_APP) {
            return true;
        }

        return false;
    }

    public function isOperator()
    {
        if ($this->roles[0]->id == User::OPERATOR) {
            return true;
        }

        return false;
    }

    public function isKorwil()
    {
        if ($this->roles[0]->id == User::KORWIL) {
            return true;
        }

        return false;
    }

    public function isMemberApp()
    {
        if ($this->roles[0]->id == User::MEMBER_APP) {
            return true;
        }

        return false;
    }

    public function isMember()
    {
        if ($this->roles[0]->id == User::MEMBER) {
            return true;
        }

        return false;
    }

    public function onlyRoles($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($role == $this->roles[0]->id) {
                    return true;
                }
            }

            return false;
        }
    }
}
