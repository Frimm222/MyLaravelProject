<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commentgables', function (Blueprint $table) {
        $table->foreignId('comment_id')
            ->constrained('comments')
            ->references('id');

            $table->unsignedInteger('commentgable_id');
            $table->string('commentgable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentgables');
    }
};
