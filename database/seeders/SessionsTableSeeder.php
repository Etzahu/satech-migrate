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
                'id' => 'BWYr2Sq9EoASRXm1jOpYuJmL6WfQrykji0d7AmtF',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTTlja2dyd0N5UHA5UHYzdVd4ajZMTzh6dWRyQVc4enI4aGU2V2lMTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1737042200,
            ),
            1 => 
            array (
                'id' => 'kIKd3bISsKQg84vSGYmzvcOzf419PM0wXwqrHbq4',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiaU1lRTRTZ2lOb001dGU1b0x6RFdZTmpYcDNTTHdGRkhNZzdPR0M5eSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk5O3M6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6MTI6IkdQVCBTZXJ2aWNlcyI7czoxNToiY29tcGFueV9hY3JvbnltIjtzOjE6IkciO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU0OiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL2FkbWluL29yZGVuZXMvMi92ZXIiO319',
                'last_activity' => 1737059426,
            ),
            2 => 
            array (
                'id' => 'KjJGDHv92efMhllUIQGiFVweNqYzwOnO9QEo7PLb',
                'user_id' => NULL,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWGZwTWcxa0dYbU85MmRRcXNBbTlybm45QjRMZE0xOWZQZzlrSUw0YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1737122056,
            ),
        ));
        
        
    }
}