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
            $table->dropColumn(['time', 'is_attendance']);
            
            $table->string('type')->default('late_clock_in');
            $table->datetime('requested_time');
            $table->integer('duration_minutes')->default(45);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['type', 'requested_time', 'duration_minutes']);
            
            $table->time('time');
            $table->boolean('is_attendance')->default(true);
        });
    }
};
