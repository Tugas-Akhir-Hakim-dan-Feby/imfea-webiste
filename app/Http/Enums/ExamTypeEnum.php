<?php

namespace App\Http\Enums;

use App\Models\Exam;

class ExamTypeEnum
{
    public static function get(): array
    {
        return [
            [
                "id" => Exam::TYPE_MULTIPLE_CHOICE,
                "type" => "Pilihan Ganda"
            ],
            [
                "id" => Exam::TYPE_ESSAY,
                "type" => "Essay"
            ],
        ];
    }
}
