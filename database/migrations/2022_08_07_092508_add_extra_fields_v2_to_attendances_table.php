<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsV2ToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('delay_time')->nullable();
            $table->time('early_leaving')->nullable();
            $table->time('permissions_hours')->nullable();
            $table->time('overtime_hours')->nullable();
            $table->time('holiday_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('delay_time');
            $table->dropColumn('early_leaving');
            $table->dropColumn('permissions_hours');
            $table->dropColumn('overtime_hours');
            $table->dropColumn('holiday_hours');
        });
    }
}
