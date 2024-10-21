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
                'id' => '2dZOs24uCDvHDQvgujcOEaHeK0sZCmucKkKVAK9J',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWhraEJkYmh1cVJObDYzQWI3TGhWWE9BZE5ZVlVYNWs4aDZ4NXdoUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9zYXRlY2gtbWlncmF0ZS5vcmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',
                'last_activity' => 1729478115,
            ),
            1 => 
            array (
                'id' => '4ssEbRG3FNgkDfVbjn5GSllFMlxNxm6s46dolqkW',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiU215dlFxNUJ4QnU4ZjQwckY0eFBZeXVUY01PYXNQTzBJbVFMZ3RDZyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk5O3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkUzBtTFJEVEVpT0FwNHh5WmF0cDhrLjdiY3RveU9HanBYS2xYLy5KbkVzRDRENkRIbHVxM1ciO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy90YWJsYXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjg6ImZpbGFtZW50IjthOjA6e31zOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjI4OiJHUFQgSU5HRU5JRVJJQSBZIE1BTlVGQUNUVVJBIjtzOjQ6ImxvZ28iO3M6MTcyOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vb01wQXNsUDVsQ1o4dWZ2QzRzSUdmc2FJUjJCclp1NmVlLWVraFNtT0V0WVBTZ1hHcUZZcFJCQk45OVZjRk40ekFYVktENlR2NFdRaTRrZ1dIZWUzOFR0bTd1d204ajMxek5acWdIVkhweDRQZVpwZ0lobXRfZnlTRlM1UzYwclp6LWFZbnI4T2lBIjt9',
                'last_activity' => 1729478973,
            ),
            2 => 
            array (
                'id' => '6DxakgyzRyOgxT2654bqjPpgwSFN26kavzYMDMS2',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVhPdFlpY1NoTVZIUFNla1pEMXEzZnFnU0hIN3RHeTF3Nlc3WDBzNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9zYXRlY2gtbWlncmF0ZS5vcmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',
                'last_activity' => 1729478104,
            ),
            3 => 
            array (
                'id' => 'CuJNZ8SMqfD6I4L3PfLGl9J8TNnHZ1jcjIjQlGnV',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRUJIWmQ0RnlhOHBOTkJIMDRaQ2pDQVBxMThHYmtPWllGb1FsekVBQSI7czo1OiJzdGF0ZSI7czo0MDoiRE5qN2RGQlF6UTU3c09mOHJTS0NxQ0FyQzY2Y1Juc1MycUJHYnhVWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvbG9naW4vZ29vZ2xlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1729478107,
            ),
            4 => 
            array (
                'id' => 'DQdlhA9zY2RbB4fy4n3dEzYxftAumqXtfOFSFtpC',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkxTSTNMVnlFRVBCYkt0SmZ2a1NvS0E0dzh2M1FEY1FVZWNiRTBuSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvdGFibGFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1729478557,
            ),
            5 => 
            array (
                'id' => 'qWP6TAhxQbiJ0nYfky5r3kXptqOMJPIIfJahJGPM',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZjIzV0FxQjJyWjdDa3Y4Szc2Y3p1amdtWlJHRmZIeEt5UnpVdG1NYyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',
                'last_activity' => 1729478103,
            ),
        ));
        
        
    }
}