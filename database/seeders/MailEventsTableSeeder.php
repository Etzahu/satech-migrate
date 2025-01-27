<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailEventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mail_events')->delete();
        
        
        
    }
}