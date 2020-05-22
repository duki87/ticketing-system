<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('tck_no');
            //$table->foreign('user_id')->references('id')->on('users');
            $table->integer('user_id')->unsigned();
            $table->boolean('status')->default(1);
            $table->text('description');
            $table->timestamps();
            $table->timestamp('closed_at')->nullable();
        });
        Schema::table('tickets', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
