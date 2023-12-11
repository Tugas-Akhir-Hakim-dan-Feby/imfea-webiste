<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\ExamAnswer;
use App\Models\Exam;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->tinyInteger("type")->default(0);
            $table->foreignIdFor(User::class)->references("id")->on("users")->cascadeOnDelete();
            $table->foreignIdFor(Exam::class)->references("id")->on("exams")->cascadeOnDelete();
            $table->text("answer");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_answers');
    }
};
