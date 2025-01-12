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
                'id' => 'OcbQUIOFOq0uU5YPIhBBZTEb3Va4Wv7alC8snsYb',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMTp7czo2OiJfdG9rZW4iO3M6NDA6IlVmQktmSTFuZXhRNWpJZ0wyOVE0cHpFTVFwZEtQSThJNmtqZEdZNVQiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE5OTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29uY2VudHJhZG8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjk6ImNvbXBhbmllcyI7YToyOntpOjA7YTozOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjQzOiJHUFQgSW5nZW5pZXLDrWEgWSBNYW51ZmFjdHVyYSwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiRyI7fWk6MTthOjM6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MzI6IlRFQ0hFTkVSR1kgQ09OVFJPTCwgUy5BLiBkZSBDLlYuIjtzOjc6ImFjcm9ueW0iO3M6MToiVCI7fX1zOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoyODoiR1BUIElOR0VOSUVSSUEgWSBNQU5VRkFDVFVSQSI7czo0OiJsb2dvIjtzOjE3MjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL29NcEFzbFA1bENaOHVmdkM0c0lHZnNhSVIyQnJadTZlZS1la2hTbU9FdFlQU2dYR3FGWXBSQkJOOTlWY0ZONHpBWFZLRDZUdjRXUWk0a2dXSGVlMzhUdG03dXdtOGozMXpOWnFnSFZIcHg0UGVacGdJaG10X2Z5U0ZTNVM2MHJaei1hWW5yOE9pQSI7czo4OiJmaWxhbWVudCI7YTowOnt9czo2OiJ0YWJsZXMiO2E6MTp7czozMjoiRmFtaWxpZXNSZWxhdGlvbk1hbmFnZXJfcGVyX3BhZ2UiO3M6MjoiNTAiO319',
                'last_activity' => 1736651205,
            ),
        ));
        
        
    }
}