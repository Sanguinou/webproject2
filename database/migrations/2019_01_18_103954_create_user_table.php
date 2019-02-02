<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->char('first_name', 32);
            $table->char('last_name', 32);
            $table->char('email', 64)->unique();
            $table->char('password',64);
            $table->char('profile_pic', 32);
            $table->char('token', 10)->unique();
            $table->unsignedInteger('id_status_user');
            $table->unsignedInteger('id_school');
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
        Schema::dropIfExists('user');
    }
}
