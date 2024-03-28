<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pipelines', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('previous_pipeline_id')->nullable();
            $table->unsignedBigInteger('next_pipeline_id')->nullable();
            $table->timestamps();
            
            $table->foreign('previous_pipeline_id')->references('id')->on('pipelines')->onDelete('set null');
            $table->foreign('next_pipeline_id')->references('id')->on('pipelines')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipelines');
    }
};
