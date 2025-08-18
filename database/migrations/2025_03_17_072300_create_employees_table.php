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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('role')->default(0);
            $table->string('name');
            $table->string('username')->unique();
            $table->string('image')->nullable();
            $table->string('phone');
            $table->string('password');
            $table->string('city');
            $table->integer('age');
            $table->integer('off_days')->default(0);
            $table->decimal('salary', 10, 2);
            $table->double('device_price')->nullable();
            $table->double('meter_price')->nullable();
            $table->double('overtime_hour_price')->nullable();
            $table->double('sold_device_price')->nullable();
            $table->double('bought_device_price')->nullable();
            $table->double('commercial_device_price')->nullable();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('manager_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('shift_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
