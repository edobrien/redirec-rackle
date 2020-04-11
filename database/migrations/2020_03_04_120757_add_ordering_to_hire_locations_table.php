<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderingToHireLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hire_locations', function (Blueprint $table) {
            $table->integer('ordering')->nullable()->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hire_locations', function (Blueprint $table) {
            $table->dropColumn('ordering');

        });
    }
}
