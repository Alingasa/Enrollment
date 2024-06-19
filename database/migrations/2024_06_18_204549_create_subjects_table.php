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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('section_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->string('subject_code')->unique();
            $table->string('subject_title')->nullable();
            $table->foreignId('strand_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->string('subject_type')->nullable();
            $table->integer('units')->nullable();
            $table->string('grade_level')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('enrollment_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
