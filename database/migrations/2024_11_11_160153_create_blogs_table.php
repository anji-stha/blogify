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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->longText('body');
            $table->enum('status', ['draft', 'published', 'trash'])->default('draft');
            $table->foreignId('user_id')
                ->constrained('users', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create the pivot table for blog_category
        Schema::create('blog_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')
                ->constrained('blogs', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('category_id')
                ->constrained('categories', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });

        // Create the pivot table for blog_tag
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')
                ->constrained('blogs', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('tag_id')
                ->constrained('tags', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_tag');
        Schema::dropIfExists('blog_category');
        Schema::dropIfExists('blogs');
    }
};
