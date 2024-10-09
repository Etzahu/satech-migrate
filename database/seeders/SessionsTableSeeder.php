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
                'id' => 'cZB73s4nW9tM2Qttw2L3yIhSTR2vzWN8cYpMlAha',
                'user_id' => 53,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:131.0) Gecko/20100101 Firefox/131.0',
                'payload' => 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTnA5ZHNkTVlSNG1HWWV1U3RjWFV0Y2xjUW42UVVwcm9wWXh4bFNkMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2luZ2VuaWVyaWEvZHJhd2luZ3MvY3JlYXRlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTM7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRHV0dwdzR3VVh6Y3JKcld0MXY2YVdPL3AwUnNDNUNaQWJXN0c0d09xTzBpNVNEVHkvcTkubSI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',
                'last_activity' => 1728328871,
            ),
            1 => 
            array (
                'id' => 'l2J9j1cZUOf6onU9T9FjqRIROHx9Lrxxr7BgqRoY',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVlM4WWZhVnJQSjhHVVJHNnJQcGZFQWluREN5d09IMlNVQkt0V2RNNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwczovL3NhdGVjaC1taWdyYXRlLm9yZy90YWJsYXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxOTk7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRTMG1MUkRURWlPQXA0eHlaYXRwOGsuN2JjdG95T0dqcFhLbFgvLkpuRXNENEQ2REhsdXEzVyI7fQ==',
                'last_activity' => 1728333767,
            ),
        ));
        
        
    }
}