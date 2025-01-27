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
                'id' => '2AJKOXLGqWs8CZQz2ICsQUsd4T9aieEyqP4OVUvh',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUnVUSDl6U2ZiRHduMWc3b2taU1JzYzZyTzU5YTRyWUpCZjhjQkJmQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1737914713,
            ),
            1 => 
            array (
                'id' => '6DCsA9nzX7XDM6Y3mCWyQUf8LpSYRnYEG6ZcQCrn',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRkY2Mkt0SWlUTGlWcEloM0dUMW03S2hHa2s1UWJnbW5WYnVQSktLTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',
                'last_activity' => 1737934450,
            ),
            2 => 
            array (
                'id' => 'kwlVI3yjxMZG1qoKAnYCliMQ29gV7ZL5dOmZaO22',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiNjU3ZXZYdDNPRWVHTlljZ0NYMUV4V1BOU3pNODdhTVhIc1hVcmRhUCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk5O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU2OiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL2FsdGFzL2NhdGFsb2dvL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6ODoiZmlsYW1lbnQiO2E6MDp7fXM6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6Mjg6IkdQVCBJTkdFTklFUklBIFkgTUFOVUZBQ1RVUkEiO3M6NDoibG9nbyI7czoxNzI6Imh0dHBzOi8vbGgzLmdvb2dsZXVzZXJjb250ZW50LmNvbS9vTXBBc2xQNWxDWjh1ZnZDNHNJR2ZzYUlSMkJyWnU2ZWUtZWtoU21PRXRZUFNnWEdxRllwUkJCTjk5VmNGTjR6QVhWS0Q2VHY0V1FpNGtnV0hlZTM4VHRtN3V3bThqMzF6TlpxZ0hWSHB4NFBlWnBnSWhtdF9meVNGUzVTNjByWnotYVlucjhPaUEiO30=',
                'last_activity' => 1737868076,
            ),
            3 => 
            array (
                'id' => 'UcKu4Df0E8keA6zDzIoMvRgEVKc31WXMJVWqs4uO',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoidWVQaUtSeVBLUzZUTUhsN05udlFqMDl1eVpha3Yxb01DUWcxalFxYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2NvbXByYXMvdXN1YXJpb3MvMTUyL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxOTk7czo5OiJjb21wYW5pZXMiO2E6Mjp7aTowO2E6Mzp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo0MzoiR1BUIEluZ2VuaWVyw61hIFkgTWFudWZhY3R1cmEsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IkciO31pOjE7YTozOntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjMyOiJURUNIRU5FUkdZIENPTlRST0wsIFMuQS4gZGUgQy5WLiI7czo3OiJhY3JvbnltIjtzOjE6IlQiO319czoxMDoiY29tcGFueV9pZCI7aToxO3M6MTI6ImNvbXBhbnlfbmFtZSI7czoxMjoiR1BUIFNlcnZpY2VzIjtzOjE1OiJjb21wYW55X2Fjcm9ueW0iO3M6MToiRyI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',
                'last_activity' => 1737998817,
            ),
            4 => 
            array (
                'id' => 'xrpWl0773rI8npJpZsI6B0bzCMIYxlS8l8A6qGFj',
                'user_id' => 106,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoia2hENDloYlNCUm5DTWhsSGR4YzB2Mjc1NTBvQkhLZ3dxOG5Ed3lZUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA2O3M6OToiY29tcGFuaWVzIjthOjI6e2k6MDthOjM6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6NDM6IkdQVCBJbmdlbmllcsOtYSBZIE1hbnVmYWN0dXJhLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJHIjt9aToxO2E6Mzp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czozMjoiVEVDSEVORVJHWSBDT05UUk9MLCBTLkEuIGRlIEMuVi4iO3M6NzoiYWNyb255bSI7czoxOiJUIjt9fXM6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6MTI6IkdQVCBTZXJ2aWNlcyI7czoxNToiY29tcGFueV9hY3JvbnltIjtzOjE6IkciO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjgzOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy9jb21wcmFzL3JlcXVpc2ljaW9uZXMtaGlzdG9yaWFsP2FjdGl2ZVRhYj1hdXRob3JpemF0aW9ucyI7fX0=',
                'last_activity' => 1737864778,
            ),
            5 => 
            array (
                'id' => 'YilVHIitwalyQ4n8H1CkwqF5aARiHjRNtKFLvKjd',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                'payload' => 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUVQcTZ2WVdSZDVWVklvNHBEV3NJNjJza2I2eGVGQTRybzNoa1VWVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL21pZ3Jhci1jYXRhbG9nbyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',
                'last_activity' => 1737946007,
            ),
        ));
        
        
    }
}