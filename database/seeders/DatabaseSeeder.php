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
        $this->call(CacheTableSeeder::class);
        $this->call(CacheLocksTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryFamiliesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(DrawingCategoriesTableSeeder::class);
        $this->call(DrawingsTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(JobBatchesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ManagementTableSeeder::class);
        $this->call(MeasureUnitsTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(PasswordResetTokensTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProjectsDnNpCpTableSeeder::class);
        $this->call(PurchaseRequisitionApprovalChainsTableSeeder::class);
        $this->call(ProjectPurchaseUsageTableSeeder::class);
        $this->call(ProjectPurchasesTableSeeder::class);
        $this->call(ProjectUsagesTableSeeder::class);
        $this->call(StateHistoriesTableSeeder::class);
        // $this->call(PurchaseRequisitionsTableSeeder::class);
        // $this->call(RequisitionItemsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(SubDrawingCategoriesTableSeeder::class);
        $this->call(TaxesTableSeeder::class);
        $this->call(UserManageSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(PendingTransitionsTableSeeder::class);
    }
}
