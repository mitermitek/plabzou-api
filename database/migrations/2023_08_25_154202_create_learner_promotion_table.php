<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('learner_promotion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained('learners', 'user_id');
            $table->foreignId('promotion_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learner_promotion');
    }
};
