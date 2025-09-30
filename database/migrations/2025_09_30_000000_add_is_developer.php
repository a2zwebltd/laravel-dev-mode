<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_developer')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropColumns('users', 'is_developer');
    }
};
