<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecruitmentFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitment_firms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('website_link')->nullable();
            $table->longText('description')->nullable();
            $table->string('telephone')->nullable();
            $table->string('contact_name')->nullable();
            $table->text('overview')->nullable();
            $table->string('logo')->nullable();
            $table->integer('view_count')->nullable();
            $table->string('location')->nullable();
            $table->string('practice_area')->nullable();
            $table->string('sector')->nullable();
            $table->string('established_year')->nullable();
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
        Schema::dropIfExists('recruitment_firms');
    }
}
