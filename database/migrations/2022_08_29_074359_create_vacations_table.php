<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('date')->nullable();
            $table->integer('type')->nullable();
            $table->double('no_of_days')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->string('status');
            $table->text('vacation_reason')->nullable();
            $table->text('manager_notes')->nullable();
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
        Schema::dropIfExists('vacations');
    }
}
