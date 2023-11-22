<?php

use App\Models\Course;
use App\Models\Topic;
use App\Models\Training;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Training::class)->references('id')->on('trainings')->cascadeOnDelete();
            $table->foreignIdFor(Topic::class)->references('id')->on('topics')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('link_video');
            $table->text('content');
            $table->tinyInteger('status')->default(Course::PUBLISH);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
