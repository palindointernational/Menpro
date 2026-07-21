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
        Schema::create('kpi_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')
                ->constrained('kpi_periods')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->double('total_score')->default(0);
            $table->string('grade')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('completed_task')->default(0);
            $table->integer('late_task')->default(0);
            $table->integer('approved_task')->default(0);
            $table->integer('revision_task')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_summaries');
    }
};
