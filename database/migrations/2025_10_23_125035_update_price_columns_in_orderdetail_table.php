<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orderdetail', function (Blueprint $table) {
            $table->decimal('price_buy', 15, 2)->default(0)->change();
            $table->decimal('amount', 15, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orderdetail', function (Blueprint $table) {
            $table->float('price_buy')->change();
            $table->float('amount')->change();
        });
    }
};
