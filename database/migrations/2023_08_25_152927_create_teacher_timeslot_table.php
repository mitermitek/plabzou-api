<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teacher_timeslot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers', 'user_id');
            $table->foreignId('timeslot_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_timeslot');
    }
};
