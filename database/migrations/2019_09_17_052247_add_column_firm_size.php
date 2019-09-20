<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFirmSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruitment_firms', function (Blueprint $table) {
            $table->string('firm_size')->nullable()->after('description');
            $table->renameColumn('overview', 'testimonials');
            $table->integer('view_count')->default(0)->change();
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
            $table->dropColumn('firm_size');
            $table->renameColumn('testimonials', 'overview');
        });
    }
}
