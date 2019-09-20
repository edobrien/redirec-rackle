<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactLocationFirm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firm_locations', function (Blueprint $table) {
            $table->string('telephone')->nullable()->after('location_id');
            $table->string('contact_name')->nullable()->after('telephone');
            $table->string('email')->nullable()->after('contact_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('firm_locations', function (Blueprint $table) {
            $table->dropColumn('telephone');
            $table->dropColumn('contact_name');
            $table->dropColumn('email');
        });
    }
}
