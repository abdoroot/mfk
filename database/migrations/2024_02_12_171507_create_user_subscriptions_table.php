<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('my_home_id')->nullable();
            $table->json('title');
            $table->tinyInteger('status')->nullable()->default('0');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('plan_type')->nullable();
            $table->json('description');
            $table->timestamps();
            
            // Foreign key constraints if applicable
            // $table->foreign('main_category')->references('id')->on('categories');
            // $table->foreign('sub_category')->references('id')->on('sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}
