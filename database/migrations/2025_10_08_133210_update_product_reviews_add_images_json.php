<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('product_reviews', 'images')) {
                $table->json('images')->nullable()->after('comment')->comment('Danh sách ảnh review (JSON)');
            }

            if (Schema::hasColumn('product_reviews', 'image')) {
                $table->dropColumn('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            if (Schema::hasColumn('product_reviews', 'images')) {
                $table->dropColumn('images');
            }
        });
    }
};
