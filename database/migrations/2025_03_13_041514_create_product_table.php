<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('brand_id');
            $table->string('name', 1000);
            $table->string('slug', 1000)->unique();

            // 💰 Giá chính xác, không bị giới hạn
            $table->decimal('price_root', 15, 2);
            $table->decimal('price_sale', 15, 2);

            $table->string('thumbnail', 1000)->nullable();
            $table->unsignedInteger('qty')->default(0);
            $table->unsignedInteger('stock')->default(0)->comment('Số lượng còn trong kho');
            $table->unsignedInteger('sold')->default(0)->comment('Số lượng đã bán');

            $table->longText('detail')->nullable();
            $table->text('description')->nullable();

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->boolean('status')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
