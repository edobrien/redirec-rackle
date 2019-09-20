<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmPracticeAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firm_practice_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('firm_id')->unsigned()->nullable();
            $table->foreign('firm_id')->references('id')->on('recruitment_firms');
            $table->bigInteger('practice_area_id')->unsigned()->nullable();
            $table->foreign('practice_area_id')->references('id')->on('practice_areas');
            $table->string('is_active')->nullable()->default('YES');
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
        Schema::dropIfExists('firm_practice_areas');
    }
}
