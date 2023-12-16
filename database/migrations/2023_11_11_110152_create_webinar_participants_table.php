<?php

use App\Models\User;
use App\Models\Webinar;
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
        Schema::create('webinar_participants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Webinar::class)->references('id')->on('webinars')->cascadeOnDelete();
            $table->foreignIdFor(User::class)->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinar_participants');
    }
};
