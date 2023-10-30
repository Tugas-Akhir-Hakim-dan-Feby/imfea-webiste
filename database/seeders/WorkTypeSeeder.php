<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ["Dosen", "Guru", "Instruktur", "Widyaiswara"];

        $this->truncate("work_types");

        foreach ($types as $type) {
            WorkType::create([
                "name" => $type
            ]);
        }
    }
}
