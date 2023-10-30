<?php

use App\Models\User;
use App\Models\WorkType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->foreignIdFor(WorkType::class)->references('id')->on('work_types');
            $table->foreignId('province_id');
            $table->foreignId('city_id');
            $table->string('nin');
            $table->string('gender');
            $table->string('place_birth');
            $table->string('date_birth');
            $table->string('citizenship');
            $table->text('address');
            $table->string('phone');
            $table->string('pas_photo');
            $table->string('cv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
