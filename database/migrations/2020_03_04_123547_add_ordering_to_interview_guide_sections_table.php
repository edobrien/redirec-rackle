<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderingToInterviewGuideSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interview_guide_sections', function (Blueprint $table) {
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
        Schema::table('interview_guide_sections', function (Blueprint $table) {
            $table->integer('ordering')->nullable()->default(0)->after('is_active');

        });
    }
}
