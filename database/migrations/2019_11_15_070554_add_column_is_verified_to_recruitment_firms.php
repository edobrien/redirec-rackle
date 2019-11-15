<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsVerifiedToRecruitmentFirms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruitment_firms', function (Blueprint $table) {
            $table->string('is_verified')->default('NO')->after('is_active');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruitment_firms', function (Blueprint $table) {
            $table->dropColumn('is_verified');

        });
    }
}
