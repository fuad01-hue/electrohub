<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Menambahkan kolom invoice_number setelah user_id
            $table->string('invoice_number')->unique()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
        });
    }
};
