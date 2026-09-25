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
        Schema::table('settings', function (Blueprint $table) {
            // 1. Top Banner Ad
            $table->boolean('ad_top_banner_enabled')->default(false)->after('adsense_enabled');
            $table->string('ad_top_banner_image')->nullable()->after('ad_top_banner_enabled');
            $table->string('ad_top_banner_link')->nullable()->after('ad_top_banner_image');
            $table->text('ad_top_banner_code')->nullable()->after('ad_top_banner_link');

            // 2. Right Sidebar Ad 1
            $table->boolean('ad_sidebar_1_enabled')->default(false)->after('ad_top_banner_code');
            $table->string('ad_sidebar_1_image')->nullable()->after('ad_sidebar_1_enabled');
            $table->string('ad_sidebar_1_link')->nullable()->after('ad_sidebar_1_image');
            $table->text('ad_sidebar_1_code')->nullable()->after('ad_sidebar_1_link');

            // 3. Right Sidebar Ad 2
            $table->boolean('ad_sidebar_2_enabled')->default(false)->after('ad_sidebar_1_code');
            $table->string('ad_sidebar_2_image')->nullable()->after('ad_sidebar_2_enabled');
            $table->string('ad_sidebar_2_link')->nullable()->after('ad_sidebar_2_image');
            $table->text('ad_sidebar_2_code')->nullable()->after('ad_sidebar_2_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'ad_top_banner_enabled',
                'ad_top_banner_image',
                'ad_top_banner_link',
                'ad_top_banner_code',
                'ad_sidebar_1_enabled',
                'ad_sidebar_1_image',
                'ad_sidebar_1_link',
                'ad_sidebar_1_code',
                'ad_sidebar_2_enabled',
                'ad_sidebar_2_image',
                'ad_sidebar_2_link',
                'ad_sidebar_2_code',
            ]);
        });
    }
};
