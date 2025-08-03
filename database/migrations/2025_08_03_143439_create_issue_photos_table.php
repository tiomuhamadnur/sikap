<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issue_photos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('issue_id')->unsigned()->nullable();
            $table->text('photo')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('issue_id')->on('issues')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issue_photos');
    }
};
