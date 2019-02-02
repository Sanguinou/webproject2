<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->increments('id_school');
            $table->char('school_name', 16);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('school')->insert([
            ['school_name' => 'Lille'],
            ['school_name' => 'Arras'],
            ['school_name' => 'Rouen'],
            ['school_name' => 'Caen'],
            ['school_name' => 'Reims'],
            ['school_name' => 'Brest'],
            ['school_name' => 'Paris'],
            ['school_name' => 'Nanterre'],
            ['school_name' => 'Nancy'],
            ['school_name' => 'Strasbourg'],
            ['school_name' => 'Orléans'],
            ['school_name' => 'Le Mans'],
            ['school_name' => 'Saint-Nazaire'],
            ['school_name' => 'Nantes'],
            ['school_name' => 'Châteauroux'],
            ['school_name' => 'Dijon'],
            ['school_name' => 'La Rochelle'],
            ['school_name' => 'Angoulême'],
            ['school_name' => 'Bordeaux'],
            ['school_name' => 'Lyon'],
            ['school_name' => 'Grenoble'],
            ['school_name' => 'Pau'],
            ['school_name' => 'Toulouse'],
            ['school_name' => 'Montpellier'],
            ['school_name' => 'Aix-en-Provence'],
            ['school_name' => 'Nice'],
            ['school_name' => 'Alger']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school');
    }
}
