<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('name')->nullable();
            $table->bigInteger('visit_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->text('remark')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('visit_id')->on('visits')->references('id');
            $table->foreign('category_id')->on('categories')->references('id');
            $table->foreign('status_id')->on('statuses')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
