<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYouliDeliverySmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('youli_delivery_sms', function(Blueprint $table)
		{
			$table->increments('mid');
			$table->integer('schoolid');
			$table->string('contents')->comment('优里物流短信添加内容');
			$table->string('regex')->comment('正则表达式');
			$table->enum('isValid',array('0','1'))->default('1')->comment('短信禁用判断');
			$table->timestamps('createtime');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('youli_delivery_sms');
	}

}
