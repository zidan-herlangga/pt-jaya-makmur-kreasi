<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertising_points', function (Blueprint $table) {
            $table->string('area', 50)->nullable()->after('slug');
        });

        $jabodetabekCities = ['Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Timur', 'Bogor', 'Depok', 'Tangerang', 'Tangerang Selatan', 'Bekasi'];

        DB::table('advertising_points')
            ->where(function ($query) use ($jabodetabekCities) {
                $query->whereIn('city', $jabodetabekCities)
                    ->orWhere('city', 'Jabodetabek');
            })
            ->update(['area' => 'jabodetabek']);

        DB::table('advertising_points')
            ->whereNotNull('city')
            ->whereNull('area')
            ->update(['area' => 'luar_jabodetabek']);

        Schema::table('advertising_points', function (Blueprint $table) {
            $table->dropIndex(['city']);
            $table->dropIndex(['status', 'city']);
            $table->dropFullText(['title', 'location_name', 'description']);
        });

        Schema::table('advertising_points', function (Blueprint $table) {
            $table->dropColumn(['location_name', 'city']);
        });

        Schema::table('advertising_points', function (Blueprint $table) {
            $table->index('area');
            $table->index(['status', 'area']);
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::table('advertising_points', function (Blueprint $table) {
            $table->dropIndex(['area']);
            $table->dropIndex(['status', 'area']);
            $table->dropFullText(['title', 'description']);
        });

        Schema::table('advertising_points', function (Blueprint $table) {
            $table->dropColumn('area');
        });

        Schema::table('advertising_points', function (Blueprint $table) {
            $table->string('location_name', 200)->nullable()->after('slug');
            $table->string('city', 100)->nullable()->after('location_name');
            $table->index('city');
            $table->index(['status', 'city']);
            $table->fullText(['title', 'location_name', 'description']);
        });
    }
};
