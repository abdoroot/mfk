<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCitiesTableForTranslatableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            // Remove the existing 'name' column
            $table->dropColumn('name');

            // Add the translatable 'name' column
            $table->json('name')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            $table->string('name', 255)->nullable()->default(null)->after('id');
        });
    }
}
