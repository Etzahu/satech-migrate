<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mailables')->delete();
        
        
        
    }
}