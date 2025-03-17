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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('attendance');
            $table->time('departure')->nullable();
            $table->double('lat');
            $table->double('lng');
            $table->tinyInteger('status')->default(0);
            $table->double('total_delay')->default(0);
            $table->double('overtime')->default(0);
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
