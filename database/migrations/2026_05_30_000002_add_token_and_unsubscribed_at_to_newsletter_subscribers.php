<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->string('token', 64)->unique()->nullable()->after('email');
            $table->timestamp('unsubscribed_at')->nullable()->after('subscribed_at');
        });

        DB::table('newsletter_subscribers')
            ->whereNull('token')
            ->get()
            ->each(function ($subscriber) {
                DB::table('newsletter_subscribers')
                    ->where('id', $subscriber->id)
                    ->update(['token' => Str::random(64)]);
            });
    }

    public function down(): void
    {
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropColumn(['token', 'unsubscribed_at']);
        });
    }
};
