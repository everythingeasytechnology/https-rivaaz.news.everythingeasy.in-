<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_vote_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_vote_id')->constrained()->cascadeOnDelete();
            $table->foreignId('poll_option_id')->constrained()->cascadeOnDelete();
            $table->unique(['poll_vote_id', 'poll_option_id']);
            $table->index('poll_option_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_vote_choices');
    }
};
