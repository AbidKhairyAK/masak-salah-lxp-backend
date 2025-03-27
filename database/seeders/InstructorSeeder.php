<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Instructor::create([
            'user_id'     => User::where('name', 'like', '%Teacher%')->value('id'),
            'phonenumber' => $faker->phoneNumber(),
            'occupation'  => $faker->jobTitle(),
            'gender'      => $faker->randomElement(['male', 'female']),
            'address'     => $faker->address(),
        ]);
    }
}
