<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id_event');
            $table->char('event_name', 64);
            $table->char('event_body', 255);
            $table->char('event_date', 10);
            $table->char('event_location', 64);
            $table->char('picture_presentation_event', 32);
            $table->unsignedInteger('id_user_create');
            $table->unsignedInteger('id_status_event');
            $table->unsignedInteger('id_user_validate')->nullable();
            $table->timestamps();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
        Schema::dropIfExists('event');
    }
}
