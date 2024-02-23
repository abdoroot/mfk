<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->json('items')->nullable();
            $table->double('amount')->nullable();
            $table->double('discount')->nullable();
            $table->bigInteger('coupon_id')->nullable();
            $table->double('total_amount')->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->text('address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('payment_type')->nullable(); 
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_orders');
    }
}
