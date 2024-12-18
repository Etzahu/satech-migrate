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
                'id' => '9JD32OK6THYPtPLShM7EqJBtCmgSVxHrGyRN8u6X',
                'user_id' => 331,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0',
                'payload' => 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiZGF6Z3FQMlVINDZ0dGUwNE1rVTZLeU9Ga25hUE9kbjBTSTVUTWRaQSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzMxO3M6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6MTI6IkdQVCBTZXJ2aWNlcyI7czoxNToiY29tcGFueV9hY3JvbnltIjtzOjE6IkciO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUwOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL29yZGVuZXMvcmV2aXNhciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',
                'last_activity' => 1734550794,
            ),
            1 => 
            array (
                'id' => 'OaoSVJwyTQ3VCBbrzQ5kxXenWrbBd1FoxCyRyH8z',
                'user_id' => 274,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiSlFxMExVM05KNk4wNWJPWFZZZjB1aFFrZENxUENZdm1Fc2RZaVBlQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjc0O3M6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6Mjg6IkdQVCBJTkdFTklFUklBIFkgTUFOVUZBQ1RVUkEiO3M6NDoibG9nbyI7czoxNzI6Imh0dHBzOi8vbGgzLmdvb2dsZXVzZXJjb250ZW50LmNvbS9vTXBBc2xQNWxDWjh1ZnZDNHNJR2ZzYUlSMkJyWnU2ZWUtZWtoU21PRXRZUFNnWEdxRllwUkJCTjk5VmNGTjR6QVhWS0Q2VHY0V1FpNGtnV0hlZTM4VHRtN3V3bThqMzF6TlpxZ0hWSHB4NFBlWnBnSWhtdF9meVNGUzVTNjByWnotYVlucjhPaUEiO3M6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjYxOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL3JlcXVpc2ljaW9uZXMvYXNpZ25hY2lvbi8xIjt9czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',
                'last_activity' => 1734551161,
            ),
            2 => 
            array (
                'id' => 'tBmmCVLu1RdCyDHAGCYftit9xkOXPZa8kxWFGL7R',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6ImVqV3BSeU5uTlYzRTRmN25BYU1GVjdQVDhzM0FpbFNhNmtHYTVYNWEiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE5OTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFMwbUxSRFRFaU9BcDR4eVphdHA4ay43YmN0b3lPR2pwWEtsWC8uSm5Fc0Q0RDZESGx1cTNXIjtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQzOiJHUFQgSW5nZW5pZXLDrWEgWSBNYW51ZmFjdHVyYSwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiRyI7fWk6MTthOjM6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MzI6IlRFQ0hFTkVSR1kgQ09OVFJPTCwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjEyOiJHUFQgU2VydmljZXMiO3M6MTU6ImNvbXBhbnlfYWNyb255bSI7czoxOiJHIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1NDoiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcy9taXMtcmVxdWlzaWNpb25lcy8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',
                'last_activity' => 1734551275,
            ),
        ));
        
        
    }
}