<?php

namespace Database\Seeders;

use App\Models\UserLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert default material type
        $data = [
            [
                'id'=>999,
                'code' => 'Admin'
            ],
            [
                'id'=>1,
                'code' => 'Level I'
            ],
            [
                'id'=>2,
                'code' => 'Level II'
            ],
            [
                'id'=>3,
                'code' => 'Level III'
            ],
            [
                'id'=>4,
                'code' => 'Level IV'
            ],
            [
                'id'=>5,
                'code' => 'Level V'
            ],
            [
                'id'=>6,
                'code' => 'Level VI'
            ]
        ];

        foreach ($data as $item) {
            UserLevel::updateOrInsert(
                ['code' => $item['code']],
                ['id' => $item['id']]
            );
        }
    }
}
