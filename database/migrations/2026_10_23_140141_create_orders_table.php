<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->integer('quantity')->default(1);
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_channel'); // 'midtrans' atau 'dummy_qris' / 'dummy_va'
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};