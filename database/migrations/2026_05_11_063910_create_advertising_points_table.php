<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertising_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->string('location_name', 200)->nullable();
            $table->string('city', 100)->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('long', 11, 8)->nullable();
            $table->string('orientation', 20)->nullable(); // horizontal / vertical / rooftop
            $table->string('size_dimension', 50)->nullable(); // e.g. "10m x 5m"
            $table->string('light_type', 30)->nullable(); // LED / Neon / Frontlit / Backlit / None
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->string('thumbnail', 255)->nullable();
            $table->json('gallery')->nullable();
            $table->text('description')->nullable();

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

            // Indexes for performance
            $table->index('slug');
            $table->index('status');
            $table->index('city');
            $table->index('category_id');
            $table->index(['status', 'city']);
            $table->index(['status', 'category_id']);
            $table->fullText(['title', 'location_name', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertising_points');
    }
};
