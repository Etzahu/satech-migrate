<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SessionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sessions')->delete();
        
        \DB::table('sessions')->insert(array (
            0 => 
            array (
                'id' => 'kMdYJmS6C3BAkxjAbFbcFfhtMxxPIpEsSc1ldTWu',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IkxSdG5mMVhMdEwzY01LNjNwa1I2MUkwSHVCQ1FxcHFzRWNRVzFaVTkiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE5OTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFMwbUxSRFRFaU9BcDR4eVphdHA4ay43YmN0b3lPR2pwWEtsWC8uSm5Fc0Q0RDZESGx1cTNXIjtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjEyOiJHUFQgU0VSVklDRVMiO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czoxMDoiVEVDSEVORVRHWSI7czo3OiJhY3JvbnltIjtzOjE6IlQiO319czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoxMjoiR1BUIFNFUlZJQ0VTIjtzOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL3RhYmxhcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=',
                'last_activity' => 1729800704,
            ),
        ));
        
        
    }
}