<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnnouncementsTable extends Migration {

    public function up() {
        Schema::create('announcements', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->text('description');
            $table->enum('delivery_mode', array('email', 'sms'));
            $table->integer('role_id')->unsigned();
        });
    }

    public function down() {
        Schema::drop('announcements');
    }

}
