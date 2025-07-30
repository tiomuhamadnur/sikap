<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('tps_id')->unsigned()->nullable();
            $table->bigInteger('vote')->nullable();
            $table->bigInteger('vote_party')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('tps_id')->on('tps')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elections');
    }
};
