<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UsersTableSeeder::class);
        // $this->call(DrawingCategoriesTableSeeder::class);
        // $this->call(SubDrawingCategoriesTableSeeder::class);
        // $this->call(CacheTableSeeder::class);
        // $this->call(CacheLocksTableSeeder::class);
        // $this->call(DrawingsTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        // $this->call(JobBatchesTableSeeder::class);
        // $this->call(JobsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(PasswordResetTokensTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(ProyectosDnNpCpTableSeeder::class);
        $this->call(ManagementTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
    }
}
