<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand', 50)->nullable()->after('name');
            }
            if (!Schema::hasColumn('products', 'specifications')) {
                $table->text('specifications')->nullable()->after('brand');
            }
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('specifications');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['brand', 'specifications', 'image']);
        });
    }
};