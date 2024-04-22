<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyhomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myhome', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->notnull();
            $table->json('name');
            $table->tinyInteger('status');
            $table->string('email');
            $table->string('phone');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('address');
            $table->string('building_no');
            $table->string('flat_no');
            $table->enum('maintenance_borne', ['owner', 'tenant']);
            $table->enum('borne_type', ['amount', 'percentage']);
            $table->string('borne_amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('myhome');
    }
}
