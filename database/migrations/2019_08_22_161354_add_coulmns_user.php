<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoulmnsUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firm_name')->nullable()->after('name');
            $table->string('position')->nullable()->after('firm_name');
            $table->string('contact_number')->nullable()->after('position');
            $table->string('is_admin')->default('NO')->after('contact_number');
            $table->string('is_active')->after('is_admin')->default('NO');
            $table->timestamp('approved_at')->after('is_active')->nullable();
            $table->string('accepted_terms')->after('approved_at')->default('NO');
            $table->string('privacy_policy')->after('accepted_terms')->default('NO');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firm_name');
            $table->dropColumn('position');
            $table->dropColumn('contact_number');
            $table->dropColumn('is_admin');
            $table->dropColumn('is_active');
            $table->dropColumn('approved_at');
            $table->dropColumn('accepted_terms');
            $table->dropColumn('privacy_policy');
            $table->dropSoftDeletes();
        });
    }
}
