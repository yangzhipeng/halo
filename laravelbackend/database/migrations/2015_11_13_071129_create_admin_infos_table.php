<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id');
            $table->string('admin_name', 50)->default('');
            $table->enum('gender',array('male', 'female'))->default('female');
            $table->string('city')->default('');
            $table->string('header_icon_url',100)->default('');
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
        Schema::drop('admin_infos');
    }
}
