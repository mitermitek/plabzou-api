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
        Schema::table('requests', function (Blueprint $table) {
            $table->boolean('is_approved_by_teacher')->nullable();
            $table->boolean('is_approved_by_admin')->nullable();
            $table->dropColumn('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false);
            $table->dropColumn('is_approved_by_admin');
            $table->dropColumn('is_approved_by_teacher');
        });
    }
};
