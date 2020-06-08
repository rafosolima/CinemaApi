<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('maturity_rating_id')->unsigned();
            $table->string('name')->unique();
            $table->text('sinopse');
            $table->integer('duration');
            $table->float('imdb', 3, 1);
            $table->timestamps();
            $table->foreign('maturity_rating_id')->references('id')->on('maturity_ratings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
