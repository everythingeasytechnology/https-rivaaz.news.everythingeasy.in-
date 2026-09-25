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
            $table->longText('adsense_script')->nullable()->after('live_tv_cover');
            $table->text('adsense_header_code')->nullable()->after('adsense_script');
            $table->text('adsense_sidebar_code')->nullable()->after('adsense_header_code');
            $table->text('adsense_article_code')->nullable()->after('adsense_sidebar_code');
            $table->boolean('adsense_enabled')->default(true)->after('adsense_article_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'adsense_script',
                'adsense_header_code',
                'adsense_sidebar_code',
                'adsense_article_code',
                'adsense_enabled'
            ]);
        });
    }
};
