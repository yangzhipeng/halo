<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUmiP2pJobTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umi_p2p_job_temps', function (Blueprint $table) {
            $table->increments('category_id');
            $table->integer('publish_num');
            $table->tinyInteger('is_published');
            $table->integer('issuer_id');
            $table->tinyInteger('type');
            $table->string('title', 100)->default('');
            $table->string('description', 1000)->default('');
            $table->string('privacy', 1000)->default('');
            $table->decimal('decimal',10, 2);
            $table->integer('expire');
            $table->tinyInteger('image_num');
            $table->string('image_url', 400)->default('');
            $table->integer('school_id');
            $table->string('school_name', 200)->default('');
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
        Schema::drop('umi_p2p_job_temps');
    }
}
