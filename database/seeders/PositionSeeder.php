<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('position')->delete();

        $positions = [
            [
                'name' => 'Software Engineer',
                'created_by' => 1,
            ],
            [
                'name' => 'Software Developer',
                'created_by' => 1,
            ],
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate(
                ['name' => $position['name']],
                ['created_by' => $position['created_by']]
            );
        }
    }
}
