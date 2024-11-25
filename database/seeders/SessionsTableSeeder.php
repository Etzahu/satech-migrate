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
                'id' => '8LVxuuUrakNclsqSPIubktZiaECBaJ9PLumWwKBt',
                'user_id' => 274,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoidE1OcWptZVNwN1hpWEFBdUVvaG82alpISVl3VGQ2YUFvcTVvTFN3ayI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjc0O3M6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6Mjg6IkdQVCBJTkdFTklFUklBIFkgTUFOVUZBQ1RVUkEiO3M6NDoibG9nbyI7czoxNzI6Imh0dHBzOi8vbGgzLmdvb2dsZXVzZXJjb250ZW50LmNvbS9vTXBBc2xQNWxDWjh1ZnZDNHNJR2ZzYUlSMkJyWnU2ZWUtZWtoU21PRXRZUFNnWEdxRllwUkJCTjk5VmNGTjR6QVhWS0Q2VHY0V1FpNGtnV0hlZTM4VHRtN3V3bThqMzF6TlpxZ0hWSHB4NFBlWnBnSWhtdF9meVNGUzVTNjByWnotYVlucjhPaUEiO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU5OiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL3JlcXVpc2ljaW9uZXMvYXNpZ25hY2lvbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6MTI6IkdQVCBTRVJWSUNFUyI7czo3OiJhY3JvbnltIjtzOjE6IkciO31pOjE7YTozOntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjEwOiJURUNIRU5FUkdZIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX19',
                'last_activity' => 1732210489,
            ),
            1 => 
            array (
                'id' => 'IYBONOhK493r16i63Zk7Qmwzhj4vx2f7Qv9XY6p4',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6InhkZHk4RmNHZ2dOM01CV050WnIxekV2SVVPWXVnaVNBRWlENjMwakciO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE5OTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFMwbUxSRFRFaU9BcDR4eVphdHA4ay43YmN0b3lPR2pwWEtsWC8uSm5Fc0Q0RDZESGx1cTNXIjtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjEyOiJHUFQgU0VSVklDRVMiO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czoxMDoiVEVDSEVORVJHWSI7czo3OiJhY3JvbnltIjtzOjE6IlQiO319czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoxMjoiR1BUIFNFUlZJQ0VTIjtzOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2NvbXByYXMvcmVxdWlzaWNpb25lcy9hc2lnbmFjaW9uIjt9czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',
                'last_activity' => 1732210670,
            ),
        ));
        
        
    }
}