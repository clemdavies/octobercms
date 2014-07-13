<?php namespace Clem\Feed\Components\Steam\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('clem_steam_games');
        Schema::create('clem_steam_games', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('clem_steam_users');
            $table->string('name');
            $table->integer('app_id')->unsigned();
            $table->string('app_url');
            $table->string('app_image_url');
            $table->integer('rank')->unsigned();
            $table->integer('playtime_forever')->unsigned();
            $table->integer('playtime_recent')->unsigned();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clem_steam_games');
    }
}