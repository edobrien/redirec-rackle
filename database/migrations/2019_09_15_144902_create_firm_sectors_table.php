<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firm_sectors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('firm_id')->unsigned()->nullable();
            $table->foreign('firm_id')->references('id')->on('recruitment_firms');
            $table->bigInteger('sector_id')->unsigned()->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors');
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
        Schema::dropIfExists('firm_sectors');
    }
}
