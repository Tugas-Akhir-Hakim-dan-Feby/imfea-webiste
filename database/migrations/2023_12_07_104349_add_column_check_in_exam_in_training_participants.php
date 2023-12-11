<?php

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
        Schema::table('training_participants', function (Blueprint $table) {
            $table->primary('id');
            $table->dateTime('check_in_exam')->nullable();
            $table->integer('grade_exam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_participants', function (Blueprint $table) {
            $table->dropIndex('training_participants_user_id_foreign');
            $table->dropColumn([
                'check_in_exam',
                'grade_exam'
            ]);
        });
    }
};
