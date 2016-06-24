<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
      {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->default(0);
            //If i delete user, their posts will be deleted.
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title')->uniqure();
            $table->text('body');
            //slug allows accepting title to pass through url
            $table->string('slug')->unique();
            $table->boolean('active');

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
        Schema::drop('jobs');
    }
}
