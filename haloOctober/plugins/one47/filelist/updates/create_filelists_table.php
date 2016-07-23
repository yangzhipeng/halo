<?php namespace One47\FileList\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateFileListsTable extends Migration
{

    public function up()
    {
        Schema::create('one47_filelist_filelists', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('one47_filelist_filelists');
    }

}
