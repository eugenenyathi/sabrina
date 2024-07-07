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
        Schema::create('student_council', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('src_post_id');
            $table->string('profile_url');
            $table->string('contact');

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('src_post_id')->references('src_post_id')->on('src_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_council');
    }
};
