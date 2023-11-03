<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teacher_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers', 'user_id');
            $table->foreignId('training_id')->constrained();
            $table->date('latest_upgrade_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_training');
    }
};
