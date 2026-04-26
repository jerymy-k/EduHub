<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete();
            $table->float('score');
            $table->date('date');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'activity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
