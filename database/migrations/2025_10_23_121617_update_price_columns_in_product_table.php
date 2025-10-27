<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            // ⚙️ Đổi kiểu float sang decimal(15,2)
            $table->decimal('price_root', 15, 2)->change();
            $table->decimal('price_sale', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            // Nếu rollback thì quay lại float
            $table->float('price_root')->change();
            $table->float('price_sale')->change();
        });
    }
};
