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
                'id' => 'ABS0asQQlyTlbUBcFEQVlptVzUvLM6ejc3wCstZD',
                'user_id' => 199,
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'payload' => 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IjRHakhHd1Z2VDduWDZ3YUw4SWJqdDY2cnRVVjVZcmNJY1dITnZEWEgiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzQ6Imh0dHBzOi8vc2F0ZWNoLW1pZ3JhdGUub3JnL2NvbXByYXMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0ODoiaHR0cHM6Ly9zYXRlY2gtbWlncmF0ZS5vcmcvY29tcHJhcy9yZXF1aXNpY2lvbmVzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTk5O3M6MTA6ImNvbXBhbnlfaWQiO2k6MTtzOjEyOiJjb21wYW55X25hbWUiO3M6Mjg6IkdQVCBJTkdFTklFUklBIFkgTUFOVUZBQ1RVUkEiO3M6NDoibG9nbyI7czoxNzI6Imh0dHBzOi8vbGgzLmdvb2dsZXVzZXJjb250ZW50LmNvbS9vTXBBc2xQNWxDWjh1ZnZDNHNJR2ZzYUlSMkJyWnU2ZWUtZWtoU21PRXRZUFNnWEdxRllwUkJCTjk5VmNGTjR6QVhWS0Q2VHY0V1FpNGtnV0hlZTM4VHRtN3V3bThqMzF6TlpxZ0hWSHB4NFBlWnBnSWhtdF9meVNGUzVTNjByWnotYVlucjhPaUEiO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkUzBtTFJEVEVpT0FwNHh5WmF0cDhrLjdiY3RveU9HanBYS2xYLy5KbkVzRDRENkRIbHVxM1ciO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=',
                'last_activity' => 1729103507,
            ),
        ));
        
        
    }
}