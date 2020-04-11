<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingHireLocationIdFirmRecruitmentRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firm_recruitment_regions', function (Blueprint $table) {            
            $table->bigInteger('hire_location_id')->unsigned()->nullable()->after('location_id');
            $table->foreign('hire_location_id')->references('id')->on('hire_locations');
            $table->dropForeign(['location_id']);
            $table->dropColumn("location_id");          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('firm_recruitment_regions', function (Blueprint $table) {
            $table->dropForeign(['hire_location_id']);
            $table->dropColumn("hire_location_id");
            $table->bigInteger('location_id')->unsigned()->nullable()->after('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }
}
