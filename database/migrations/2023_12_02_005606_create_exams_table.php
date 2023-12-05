<?php

use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\Topic;
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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Topic::class)->references('id')->on('topics')->cascadeOnDelete();
            $table->foreignIdFor(ExamAnswer::class)->nullable();
            $table->tinyInteger('type')->default(Exam::TYPE_MULTIPLE_CHOICE);
            $table->text('question');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
