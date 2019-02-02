<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePictureEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_event', function (Blueprint $table) {
            $table->increments('id_picture_event');
            $table->char('picture_event_name', 32);
            $table->char('picture_event_body', 255);
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_event');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('picture_event');
    }
}
