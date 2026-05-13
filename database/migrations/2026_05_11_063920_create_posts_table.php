<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->longText('content_body');
            $table->string('featured_image', 255)->nullable();
            $table->string('excerpt', 500)->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            // SEO Fields
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_image', 255)->nullable();
            $table->longText('json_ld_schema')->nullable();

            $table->unsignedInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('category_id');
            $table->index(['status', 'published_at']);
            $table->fullText(['title', 'content_body', 'excerpt']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
