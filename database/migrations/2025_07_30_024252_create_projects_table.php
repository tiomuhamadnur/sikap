<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('periode_id')->unsigned()->nullable();
            $table->bigInteger('party_id')->unsigned()->nullable();
            $table->bigInteger('profile_id')->unsigned()->nullable();
            $table->bigInteger('election_type_id')->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('periode_id')->on('periodes')->references('id');
            $table->foreign('party_id')->on('parties')->references('id');
            $table->foreign('profile_id')->on('profiles')->references('id');
            $table->foreign('election_type_id')->on('election_types')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
