<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->double('salary')->nullable();
            $table->string('nationality')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('identity_number')->nullable();
            $table->date('id_expiration_date')->nullable();
            $table->string('id_image', 500)->nullable();
            $table->string('licence_number')->nullable();
            $table->string('licence_image')->nullable();
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
            $table->dropColumn('gender');
            $table->dropColumn('salary');
            $table->dropColumn('nationality');
            $table->dropColumn('bank_account_number');
            $table->dropColumn('identity_number');
            $table->dropColumn('id_expiration_date');
            $table->dropColumn('id_image', 500);
            $table->dropColumn('licence_number');
            $table->dropColumn('licence_image');
        });
    }
}
