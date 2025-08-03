<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('visit_type_id')->unsigned()->nullable();
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->bigInteger('desa_id')->unsigned()->nullable();
            $table->text('address')->nullable();
            $table->text('remark')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('visit_type_id')->on('visit_types')->references('id');
            $table->foreign('project_id')->on('projects')->references('id');
            $table->foreign('desa_id')->on('desa')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
