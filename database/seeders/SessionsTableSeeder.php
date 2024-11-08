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
                'id' => 'ekiuVXvKYMYij1cZ25OI4dGZSj1mV1S8NQfv29gi',
                'user_id' => 250,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'payload' => 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiRWdIaVBDdG9YUzhUVlBaZDRnZ3E0WkM4OGpEM1E5eGM2MDFnRUtONCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjUwO3M6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6MTI6IkdQVCBTRVJWSUNFUyI7czo3OiJhY3JvbnltIjtzOjE6IkciO31pOjE7YTozOntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjEwOiJURUNIRU5FUkdZIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjEyOiJHUFQgU0VSVklDRVMiO3M6MTU6ImNvbXBhbnlfYWNyb255bSI7czoxOiJHIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2NDoiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcy9yZXF1aXNpY2lvbmVzL3JldmlzYXIvYWxtYWNlbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',
                'last_activity' => 1730902928,
            ),
            1 => 
            array (
                'id' => 'HysXKtdCWvrP1zKgce3vAwWQxLi4np75Bzsz8Tbe',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6ImpXTFh3VXl4UzFvN2EzaXJIRFM1ODR4UndTSUVZZHlubnltWE1OTEUiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE5OTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFMwbUxSRFRFaU9BcDR4eVphdHA4ay43YmN0b3lPR2pwWEtsWC8uSm5Fc0Q0RDZESGx1cTNXIjtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjEyOiJHUFQgU0VSVklDRVMiO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czoxMDoiVEVDSEVORVJHWSI7czo3OiJhY3JvbnltIjtzOjE6IlQiO319czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoxMjoiR1BUIFNFUlZJQ0VTIjtzOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2NvbXByYXMvcm9sZXMvOC9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',
                'last_activity' => 1730903296,
            ),
        ));
        
        
    }
}