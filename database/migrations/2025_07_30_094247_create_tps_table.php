<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tps', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->bigInteger('dapil_id')->unsigned()->nullable();
            $table->bigInteger('desa_id')->unsigned()->nullable();
            $table->text('address')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dapil_id')->on('dapil')->references('id');
            $table->foreign('desa_id')->on('desa')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tps');
    }
};
