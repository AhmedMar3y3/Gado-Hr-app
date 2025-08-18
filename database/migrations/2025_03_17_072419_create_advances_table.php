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
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->tinyInteger('status')->default(0);
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('type')->default(\App\Enums\AdvanceType::NORMAL);
            $table->integer('number_of_months')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advances');
    }
};
