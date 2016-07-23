<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRememberTokenToAdminAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('admin_accounts', function (Blueprint $table) {
            $table->string('remember_token', 100)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('admin_accounts', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
}
