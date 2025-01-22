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
                'id' => '7k2CDeN3nqYtL8lB9ol4E05YLDmZoMMhyXihCiNn',
                'user_id' => 315,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6Ik1sZWFMQmNiUXk0OWwxR2RnZlZFQXBnZTdCMGpZWWhtajF3UUlFZVAiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMxNTtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQzOiJHUFQgSW5nZW5pZXLDrWEgWSBNYW51ZmFjdHVyYSwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiRyI7fWk6MTthOjM6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MzI6IlRFQ0hFTkVSR1kgQ09OVFJPTCwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2NvbXByYXMvb3JkZW5lcy9hdXRvcml6YXIiO31zOjg6ImZpbGFtZW50IjthOjA6e31zOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjI4OiJHUFQgSU5HRU5JRVJJQSBZIE1BTlVGQUNUVVJBIjtzOjQ6ImxvZ28iO3M6MTcyOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vb01wQXNsUDVsQ1o4dWZ2QzRzSUdmc2FJUjJCclp1NmVlLWVraFNtT0V0WVBTZ1hHcUZZcFJCQk45OVZjRk40ekFYVktENlR2NFdRaTRrZ1dIZWUzOFR0bTd1d204ajMxek5acWdIVkhweDRQZVpwZ0lobXRfZnlTRlM1UzYwclp6LWFZbnI4T2lBIjt9',
                'last_activity' => 1737570079,
            ),
            1 => 
            array (
                'id' => 'CMZ92nigkxD07XKw3cFZkCPYvtlPoJn4MX37jOzY',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiRmY4U25uSlRrU0JOcmt3ZzhMcmd6Y0dwTjVMQW9aQllYS3RIbWxjOSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk5O3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUyOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL21pcy1yZXF1aXNpY2lvbmVzIjt9czo5OiJjb21wYW5pZXMiO2E6Mjp7aTowO2E6Mzp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo0MzoiR1BUIEluZ2VuaWVyw61hIFkgTWFudWZhY3R1cmEsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IkciO31pOjE7YTozOntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjMyOiJURUNIRU5FUkdZIENPTlRST0wsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IlQiO319czo4OiJmaWxhbWVudCI7YTowOnt9czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoyODoiR1BUIElOR0VOSUVSSUEgWSBNQU5VRkFDVFVSQSI7czo0OiJsb2dvIjtzOjE3MjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL29NcEFzbFA1bENaOHVmdkM0c0lHZnNhSVIyQnJadTZlZS1la2hTbU9FdFlQU2dYR3FGWXBSQkJOOTlWY0ZONHpBWFZLRDZUdjRXUWk0a2dXSGVlMzhUdG03dXdtOGozMXpOWnFnSFZIcHg0UGVacGdJaG10X2Z5U0ZTNVM2MHJaei1hWW5yOE9pQSI7fQ==',
                'last_activity' => 1737570754,
            ),
            2 => 
            array (
                'id' => 'wkndMS8Ki4PEvA22LlJsZIl3f45b4FNrPsORmb9X',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IlRKYlNwSHJZR1ZSOUg5SDM4ZnZnUWtqYnIzUEZOb2hsM1QyTkd6SW4iO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE5OTtzOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQzOiJHUFQgSW5nZW5pZXLDrWEgWSBNYW51ZmFjdHVyYSwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiRyI7fWk6MTthOjM6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MzI6IlRFQ0hFTkVSR1kgQ09OVFJPTCwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2NvbXByYXMvbWlzLXJlcXVpc2ljaW9uZXMiO31zOjg6ImZpbGFtZW50IjthOjA6e31zOjEwOiJjb21wYW55X2lkIjtpOjE7czoxMjoiY29tcGFueV9uYW1lIjtzOjI4OiJHUFQgSU5HRU5JRVJJQSBZIE1BTlVGQUNUVVJBIjtzOjQ6ImxvZ28iO3M6MTcyOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vb01wQXNsUDVsQ1o4dWZ2QzRzSUdmc2FJUjJCclp1NmVlLWVraFNtT0V0WVBTZ1hHcUZZcFJCQk45OVZjRk40ekFYVktENlR2NFdRaTRrZ1dIZWUzOFR0bTd1d204ajMxek5acWdIVkhweDRQZVpwZ0lobXRfZnlTRlM1UzYwclp6LWFZbnI4T2lBIjt9',
                'last_activity' => 1737570725,
            ),
        ));
        
        
    }
}