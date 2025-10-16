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
        // 🔍 Nếu bảng đã tồn tại thì không tạo lại (tránh lỗi migrate nhiều lần)
        if (Schema::hasTable('product_reviews')) {
            // ✅ Nếu bảng đã có, chỉ thêm cột image nếu chưa có
            Schema::table('product_reviews', function (Blueprint $table) {
                if (!Schema::hasColumn('product_reviews', 'image')) {
                    $table->string('image')->nullable()->after('comment')->comment('Ảnh minh họa đánh giá');
                }
            });
            return;
        }

        // 🧱 Tạo bảng mới
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            // 🔗 Khóa ngoại
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');

            // ⭐ Nội dung đánh giá
            $table->tinyInteger('rating')->default(5)->comment('Số sao đánh giá (1–5)');
            $table->text('comment')->nullable()->comment('Nội dung bình luận');
            $table->string('image')->nullable()->comment('Ảnh minh họa đánh giá');

            $table->timestamps();

            // 🔒 Ràng buộc khóa ngoại
            $table->foreign('product_id')
                ->references('id')->on('product')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
