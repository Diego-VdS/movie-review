<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('tmdb_id');

            $table->string('type');
            // movie of tv

            $table->integer('rating');
            // 1 tot 5 sterren

            $table->text('comment');

            $table->unique([
                'user_id',
                'tmdb_id',
                'type'
            ]);

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }

};