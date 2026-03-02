<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('music', function (Blueprint $table) {
            $table->id();
            $table->string('genre_id', 36);
            $table->json('artists')->nullable();
            $table->string('file_path');
            $table->string('cover_path')->nullable();
            $table->string('title');
            $table->integer('duration')->nullable()->default(0);
            $table->dateTime('release_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('plays');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music');
    }
};
