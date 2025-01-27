<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailAttachmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mail_attachments')->delete();
        
        
        
    }
}