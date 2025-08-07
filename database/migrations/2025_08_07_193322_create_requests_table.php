<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('ticket')->unique()->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('request_type_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('request_type_id')->on('request_types')->references('id');
            $table->foreign('status_id')->on('statuses')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
