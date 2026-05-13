<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('advertising_points')->onDelete('set null');
            $table->string('sender_name', 150);
            $table->string('sender_email', 150);
            $table->string('sender_phone', 20)->nullable();
            $table->string('company_name', 150)->nullable();
            $table->text('message');
            $table->string('honeypot_field', 50)->nullable(); // Anti-spam honeypot
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->enum('status', ['pending', 'processed', 'spam', 'archived'])->default('pending');
            $table->foreignId('handled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('handled_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('sender_email');
            $table->index('product_id');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
