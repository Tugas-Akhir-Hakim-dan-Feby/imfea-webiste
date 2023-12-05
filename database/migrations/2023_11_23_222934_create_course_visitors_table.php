<?php

use App\Models\Course;
use App\Models\User;
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
        Schema::create('course_visitors', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignIdFor(Course::class)->references('id')->on('courses')->cascadeOnDelete();
            $table->foreignIdFor(User::class)->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_visitors');
    }
};
