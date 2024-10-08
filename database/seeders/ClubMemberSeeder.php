<?php

namespace Database\Seeders;

use App\Models\ClubMember;
use Illuminate\Database\Seeder;

class ClubMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([17789, 11993, 1422, 9318, 17425, 15071, 17011, 14448, 14233, 15477, 16957, 15087, 15713, 17028, 15095, 17918, 18028, 17558, 18098, 15484, 18271, 16382, 18208, 17697, 18106, 18456, 18516, 15072, 4519, 18385])
            ->each(fn ($id) => ClubMember::create(['pitskill_id' => $id]));
    }
}
