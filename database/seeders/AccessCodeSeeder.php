<?php

namespace Database\Seeders;

use App\Models\AccessCode;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course_id = Course::first()->id;

        $items = [
            [
                'course_id'     => $course_id,
                'title'         => 'Contoh Valid',
                'code'          => 'CONTOH1',
                'quota_used'    => 5,
                'quota_total'   => 10,
                'expiry_date'   => '2025-02-28',
            ],
            [
                'course_id'     => $course_id,
                'title'         => 'Contoh Kuota Full',
                'code'          => 'CONTOH2',
                'quota_used'    => 10,
                'quota_total'   => 10,
                'expiry_date'   => '2025-02-28',
            ],
            [
                'course_id'     => $course_id,
                'title'         => 'Contoh Expire',
                'code'          => 'CONTOH3',
                'quota_used'    => 2,
                'quota_total'   => 10,
                'expiry_date'   => '2024-01-01',
            ],
        ];

        foreach ($items as $item) {
            AccessCode::create($item);
        }
    }
}
