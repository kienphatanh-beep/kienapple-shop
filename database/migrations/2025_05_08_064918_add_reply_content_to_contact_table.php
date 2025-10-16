<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->text('reply_content')->nullable()->after('content');
        });
    }
    
    public function down()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn('reply_content');
        });
    }
    
};
