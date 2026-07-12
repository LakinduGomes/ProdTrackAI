<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserLevelSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DistributionChannelSeeder::class);
        $this->call(UnitOfMeasureSeeder::class);
        $this->call(MaterialTypeSeeder::class);
        $this->call(MaterialGroupSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(MaterialSubGroupSeeder::class);
        $this->call(BudgetTypeSeeder::class);
        $this->call(NumberOfUnitsSeeder::class);
        $this->call(BaseUnitOfMeasureSeeder::class);
        $this->call(ProfitCenterSeeder::class);
        $this->call(SalesOrganizationSeeder::class);
        $this->call(StorageLocationSeeder::class);
        $this->call(ValuationClassSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(UserDepartmentSeeder::class);
        $this->call(UserPermissionSeeder::class);
    }
}
