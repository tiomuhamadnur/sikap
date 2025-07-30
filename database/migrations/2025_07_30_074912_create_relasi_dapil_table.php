<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relasi_dapil', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('dapil_id')->unsigned()->nullable();
            $table->bigInteger('provinsi_id')->unsigned()->nullable();
            $table->bigInteger('kabupaten_id')->unsigned()->nullable();
            $table->bigInteger('kecamatan_id')->unsigned()->nullable();
            $table->bigInteger('desa_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dapil_id')->on('dapil')->references('id');
            $table->foreign('provinsi_id')->on('provinsi')->references('id');
            $table->foreign('kabupaten_id')->on('kabupaten')->references('id');
            $table->foreign('kecamatan_id')->on('kecamatan')->references('id');
            $table->foreign('desa_id')->on('desa')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relasi_dapil');
    }
};
