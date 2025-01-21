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
                'id' => '1I003NT9jIYUoiZncttHdDmqOgaZEd45a4Ni0tYM',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVNGSHVPQW5ZM0FEODVQdHFoR25GMHhkelp6T01aaER0bHU2cVk0aCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvdGFibGFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1737478921,
            ),
            1 => 
            array (
                'id' => 'aTKCElHKQUUWFaa7wDmLXNebMZHERE9aOuOfQl2K',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnZMdnpmUXB6V1dKUWhlWjhraE9MeEg2NmxidjdFZUJCVXF2MXlVUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1737482103,
            ),
            2 => 
            array (
                'id' => 'dbC1Z0FHtKUn2en9b2hVBCR19bWCRfnBKZVzfbek',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0',
                'payload' => 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXVsaE9EOUxQRnZZUnYxaG80VURzTEpoeWs1Q0pmUUFwRXpiTFcxSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1737482103,
            ),
            3 => 
            array (
                'id' => 'IZabNgfvjCWrMeqs6n9rX9pmCjx4ooagBdRt7UzV',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IllDVkJuRWNhTVQ3bnZYNGJtV2c0cnpGTzAwNUxhMFRGbjZUR2E4a3oiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE5OTtzOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjI4OiJHUFQgSU5HRU5JRVJJQSBZIE1BTlVGQUNUVVJBIjtzOjQ6ImxvZ28iO3M6MTcyOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vb01wQXNsUDVsQ1o4dWZ2QzRzSUdmc2FJUjJCclp1NmVlLWVraFNtT0V0WVBTZ1hHcUZZcFJCQk45OVZjRk40ekFYVktENlR2NFdRaTRrZ1dIZWUzOFR0bTd1d204ajMxek5acWdIVkhweDRQZVpwZ0lobXRfZnlTRlM1UzYwclp6LWFZbnI4T2lBIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MjoiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcy91c3Vhcmlvcy8yMjcvZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6ODoiZmlsYW1lbnQiO2E6MDp7fXM6NjoidGFibGVzIjthOjE6e3M6MTg6Ikxpc3RSb2xlc19wZXJfcGFnZSI7czozOiJhbGwiO319',
                'last_activity' => 1737483289,
            ),
            4 => 
            array (
                'id' => 'j26lJVeauKw5S2TaeeWqP0DsbgAFVD9v63gxGCHd',
                'user_id' => 106,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6InE3NmF2WGU2WVZFd0JGYWYxMkRWY21lNFlhZW5DMm1UVEpSTUVRamUiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwNjtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQzOiJHUFQgSW5nZW5pZXLDrWEgWSBNYW51ZmFjdHVyYSwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiRyI7fWk6MTthOjM6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MzI6IlRFQ0hFTkVSR1kgQ09OVFJPTCwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL3RhYmxhcyI7fXM6ODoiZmlsYW1lbnQiO2E6MDp7fXM6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6Mjg6IkdQVCBJTkdFTklFUklBIFkgTUFOVUZBQ1RVUkEiO3M6NDoibG9nbyI7czoxNzI6Imh0dHBzOi8vbGgzLmdvb2dsZXVzZXJjb250ZW50LmNvbS9vTXBBc2xQNWxDWjh1ZnZDNHNJR2ZzYUlSMkJyWnU2ZWUtZWtoU21PRXRZUFNnWEdxRllwUkJCTjk5VmNGTjR6QVhWS0Q2VHY0V1FpNGtnV0hlZTM4VHRtN3V3bThqMzF6TlpxZ0hWSHB4NFBlWnBnSWhtdF9meVNGUzVTNjByWnotYVlucjhPaUEiO30=',
                'last_activity' => 1737483366,
            ),
            5 => 
            array (
                'id' => 'RaYd8BzAtjYKmR5PPfTpofxqIumIsy0T8RoKEosh',
                'user_id' => 315,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiYjhrWXdUVUhsNmFKNm5UMzlWN0h3NGthWHdqdmkxdjNUdkQ5TmJjSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzE1O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUyOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL29yZGVuZXMvYXV0b3JpemFyIjt9czo5OiJjb21wYW5pZXMiO2E6Mjp7aTowO2E6Mzp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo0MzoiR1BUIEluZ2VuaWVyw61hIFkgTWFudWZhY3R1cmEsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IkciO31pOjE7YTozOntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjMyOiJURUNIRU5FUkdZIENPTlRST0wsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IlQiO319czo4OiJmaWxhbWVudCI7YTowOnt9czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoyODoiR1BUIElOR0VOSUVSSUEgWSBNQU5VRkFDVFVSQSI7czo0OiJsb2dvIjtzOjE3MjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL29NcEFzbFA1bENaOHVmdkM0c0lHZnNhSVIyQnJadTZlZS1la2hTbU9FdFlQU2dYR3FGWXBSQkJOOTlWY0ZONHpBWFZLRDZUdjRXUWk0a2dXSGVlMzhUdG03dXdtOGozMXpOWnFnSFZIcHg0UGVacGdJaG10X2Z5U0ZTNVM2MHJaei1hWW5yOE9pQSI7fQ==',
                'last_activity' => 1737483272,
            ),
            6 => 
            array (
                'id' => 'v1EvVRlUCoSy6EVta0MHTYcTuEeDA5m3r3astFwZ',
                'user_id' => 331,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6ImhMOFdvbWl5a0l3QUFTQmgzU0NZUnRqd2JoMHZPMTVvZWJNZHM0SzgiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMzMTtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQzOiJHUFQgSW5nZW5pZXLDrWEgWSBNYW51ZmFjdHVyYSwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiRyI7fWk6MTthOjM6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MzI6IlRFQ0hFTkVSR1kgQ09OVFJPTCwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2NvbXByYXMvb3JkZW5lcy8xL3ZlciI7fXM6ODoiZmlsYW1lbnQiO2E6MDp7fXM6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6Mjg6IkdQVCBJTkdFTklFUklBIFkgTUFOVUZBQ1RVUkEiO3M6NDoibG9nbyI7czoxNzI6Imh0dHBzOi8vbGgzLmdvb2dsZXVzZXJjb250ZW50LmNvbS9vTXBBc2xQNWxDWjh1ZnZDNHNJR2ZzYUlSMkJyWnU2ZWUtZWtoU21PRXRZUFNnWEdxRllwUkJCTjk5VmNGTjR6QVhWS0Q2VHY0V1FpNGtnV0hlZTM4VHRtN3V3bThqMzF6TlpxZ0hWSHB4NFBlWnBnSWhtdF9meVNGUzVTNjByWnotYVlucjhPaUEiO30=',
                'last_activity' => 1737481885,
            ),
        ));
        
        
    }
}