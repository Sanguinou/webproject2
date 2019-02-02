<?php

use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event')->insert([
            [
                'event_name' => 'Repas ExiaMian',
                'event_body' => 'repas proposé par exiaMiam dans le but de fêter Noël avant les vacances.',
                'event_date' => '2018-12-21',
                'event_location' => 'cafet',
                'picture_presentation_event' => str_random(5).'.png',
                'id_user_create' => '2',
                'id_status_event' => '3',
                'id_user_validate' => '1',                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], 

            [
                'event_name' => 'Tournois Smash Bros Duo',
                'event_body' => 'tournois smash en duo pour la prochaine LAN, d\'autre jeux seront à disposition',
                'event_date' => '2019-02-05',
                'event_location' => 'Exia',
                'picture_presentation_event' => str_random(5).'.png',
                'id_user_create' => '2',
                'id_status_event' => '2',
                'id_user_validate' => '1',      
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'event_name' => 'Aprem piscine',
                'event_body' => 'Une après-midi piscine tous ensemble ça peut être cool.',
                'event_date' => '2019-02-18',
                'event_location' => 'piscine municipal Arras',
                'picture_presentation_event' => str_random(5).'.png',
                'id_user_create' => '2',
                'id_status_event' => '1',
                'id_user_validate' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
