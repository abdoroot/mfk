<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServicePackagesTableForTranslatableNameDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          // Remove the existing 'name' column
          $table->dropColumn('name');
          $table->dropColumn('description');

          // Add the translatable 'name' column
          $table->json('name')->nullable();
          $table->json('description')->nullable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            $table->string('name', 100)->nullable()->after('id');
            $table->string('description', 100)->nullable()->after('id');
        });
    }
}
