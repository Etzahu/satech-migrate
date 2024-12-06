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
                'id' => 'A25wl2MIFVOYqml0BZnUQzkmT9CFscoiIDlKB2iC',
                'user_id' => 274,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiVmNJa0MyYlFlSkFjOHhicmtTSUdsSEZTSUlJcDFyQ0FLc1RlV0h3cCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjc0O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjYxOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL3JlcXVpc2ljaW9uZXMvYXNpZ25hY2lvbi8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJjb21wYW5pZXMiO2E6Mjp7aTowO2E6Mzp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo0MzoiR1BUIEluZ2VuaWVyw61hIFkgTWFudWZhY3R1cmEsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IkciO31pOjE7YTozOntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjMyOiJURUNIRU5FUkdZIENPTlRST0wsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IlQiO319czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoyODoiR1BUIElOR0VOSUVSSUEgWSBNQU5VRkFDVFVSQSI7czo0OiJsb2dvIjtzOjE3MjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL29NcEFzbFA1bENaOHVmdkM0c0lHZnNhSVIyQnJadTZlZS1la2hTbU9FdFlQU2dYR3FGWXBSQkJOOTlWY0ZONHpBWFZLRDZUdjRXUWk0a2dXSGVlMzhUdG03dXdtOGozMXpOWnFnSFZIcHg0UGVacGdJaG10X2Z5U0ZTNVM2MHJaei1hWW5yOE9pQSI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',
                'last_activity' => 1733248457,
            ),
            1 => 
            array (
                'id' => 'dGyVGzmuifP6aTHXQ4b7wr4K37loBoF8vTtEAy4v',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IkpEMVBlUEk5UFVyTzFOQjZsNGtkOU4zUVUxR0Nvekk4dGQ0amx5bGsiO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ4OiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL3JvbGVzLzEwL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxOTk7czo5OiJjb21wYW5pZXMiO2E6Mjp7aTowO2E6NDp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo0MzoiR1BUIEluZ2VuaWVyw61hIFkgTWFudWZhY3R1cmEsIFMuQS4gZGUgQy5WLiI7czoxMDoic2hvcnRfbmFtZSI7czoxMjoiR1BUIFNlcnZpY2VzIjtzOjc6ImFjcm9ueW0iO3M6MToiRyI7fWk6MTthOjQ6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MzI6IlRFQ0hFTkVSR1kgQ09OVFJPTCwgUy5BLiBkZSBDLlYuIjtzOjEwOiJzaG9ydF9uYW1lIjtzOjEwOiJURUNIRU5FUkdZIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjEyOiJHUFQgU2VydmljZXMiO3M6MTU6ImNvbXBhbnlfYWNyb255bSI7czoxOiJHIjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFMwbUxSRFRFaU9BcDR4eVphdHA4ay43YmN0b3lPR2pwWEtsWC8uSm5Fc0Q0RDZESGx1cTNXIjtzOjg6ImZpbGFtZW50IjthOjA6e319',
                'last_activity' => 1733243722,
            ),
            2 => 
            array (
                'id' => 'kfzPKeZ6ikR68YT1muFD9muzgJeYR7t2XsTpBvvR',
                'user_id' => 52,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMTp7czo2OiJfdG9rZW4iO3M6NDA6Ik5IZjFJMWhDMU53YjFSSjhCbmNlRlpabTl5ZGR5NVVFNUdwTFdVd1QiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjUyO3M6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6MTU6ImNvbXBhbnlfYWNyb255bSI7czoxOiJHIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2NToiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcy9yZXF1aXNpY2lvbmVzL2FkbWluL2FzaWduYWNpb24iO31zOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFMwbUxSRFRFaU9BcDR4eVphdHA4ay43YmN0b3lPR2pwWEtsWC8uSm5Fc0Q0RDZESGx1cTNXIjtzOjg6ImZpbGFtZW50IjthOjA6e31zOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjI4OiJHUFQgSU5HRU5JRVJJQSBZIE1BTlVGQUNUVVJBIjtzOjQ6ImxvZ28iO3M6MTcyOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vb01wQXNsUDVsQ1o4dWZ2QzRzSUdmc2FJUjJCclp1NmVlLWVraFNtT0V0WVBTZ1hHcUZZcFJCQk45OVZjRk40ekFYVktENlR2NFdRaTRrZ1dIZWUzOFR0bTd1d204ajMxek5acWdIVkhweDRQZVpwZ0lobXRfZnlTRlM1UzYwclp6LWFZbnI4T2lBIjt9',
                'last_activity' => 1733247341,
            ),
            3 => 
            array (
                'id' => 'RijyBxBUG0etVNlsUuFmE6WGuJDP8sZMwrkBWjkQ',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0RncHFuVHhWMTFLN3lXdFhyRTduOUJDd2ttWWJ1enZHT2JleFhIdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvdGFibGFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1733246030,
            ),
            4 => 
            array (
                'id' => 'vipe47xiB00orKPNUESY4pmvKGpUdFhiQil8BTIH',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQlFmVFl1dGRDeFNTa2dOdUtnVlpNd2QzNHlZcG9POTZjSkt6QU4wNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk5O30=',
                'last_activity' => 1733241419,
            ),
        ));
        
        
    }
}