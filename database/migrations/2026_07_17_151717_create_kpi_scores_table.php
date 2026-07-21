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
        Schema::create('kpi_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')
                ->constrained('kpi_periods')
                ->cascadeOnDelete();
            $table->foreignId('indicator_id')
                ->constrained('kpi_indicators')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->double('raw_value')->default(0);
            $table->double('score')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_scores');
    }
};
