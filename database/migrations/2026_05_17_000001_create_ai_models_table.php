<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->string('provider', 50);
            $table->string('label', 200);
            $table->string('model', 200);
            $table->text('api_key')->nullable();
            $table->string('base_url', 500)->nullable();
            $table->integer('max_tokens')->nullable()->unsigned();
            $table->decimal('temperature', 3, 2)->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_models');
    }
};
