<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_authorizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('authorization_id')->default(0);
            $table->integer('authorization_value');
            $table->string('authorization_name', 50)->default('');
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
        Schema::drop('admin_authorizations');
    }
}
