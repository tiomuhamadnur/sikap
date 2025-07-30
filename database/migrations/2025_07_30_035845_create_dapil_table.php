<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dapil', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('project_id')->on('projects')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dapil');
    }
};
