<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('address')->nullable()->after('photo');
            $table->text('description')->nullable()->after('photo');
            $table->string('phone')->nullable()->after('photo');
            $table->string('email')->nullable()->after('photo');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('description');
            $table->dropColumn('address');
        });
    }
};
