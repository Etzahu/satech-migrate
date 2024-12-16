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
                'id' => 'wKRtNBbrTm9VMCQ6fAoZHmuTOcnDgRcwjl0jYm3o',
                'user_id' => 52,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToxMTp7czo2OiJfdG9rZW4iO3M6NDA6IjU1YUZZRnp3Mk1VbDJlcmZGbUlQTVdQNW10M242aEE1SkhmNU9TUkoiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjUyO3M6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6MTU6ImNvbXBhbnlfYWNyb255bSI7czoxOiJHIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1NDoiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcy9hZG1pbi9vcmRlbmVzLzEvdmVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo4OiJmaWxhbWVudCI7YTowOnt9czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRTMG1MUkRURWlPQXA0eHlaYXRwOGsuN2JjdG95T0dqcFhLbFgvLkpuRXNENEQ2REhsdXEzVyI7czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoyODoiR1BUIElOR0VOSUVSSUEgWSBNQU5VRkFDVFVSQSI7czo0OiJsb2dvIjtzOjE3MjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL29NcEFzbFA1bENaOHVmdkM0c0lHZnNhSVIyQnJadTZlZS1la2hTbU9FdFlQU2dYR3FGWXBSQkJOOTlWY0ZONHpBWFZLRDZUdjRXUWk0a2dXSGVlMzhUdG03dXdtOGozMXpOWnFnSFZIcHg0UGVacGdJaG10X2Z5U0ZTNVM2MHJaei1hWW5yOE9pQSI7fQ==',
                'last_activity' => 1734376854,
            ),
        ));
        
        
    }
}