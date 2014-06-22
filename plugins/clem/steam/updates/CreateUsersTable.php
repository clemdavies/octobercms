<?php namespace Clem\Steam\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('clem_steam_users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('steam_id_input');
            $table->integer('steam_id_sixtyfour');
            $table->string('persona_name');
            $table->tinyInteger('persona_state');
            $table->string('profile_url');
            $table->string('profile_image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clem_steam_users');
    }
}