<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::where(function ($query) {
            $query->where('name', 'not like', '%Admin%')
                  ->where('name', 'not like', '%Teacher%');
        })->pluck('id');
        // $occupations = ['Frontend Engineer', 'Software Engineer'];
        // $genders = ['Male', 'Female'];
        // $addresses = ['823 Oak St', '754 Pine St'];
        $faker = Faker::create();

        foreach ($userIds as $userId) {
            DB::table('students')->insert([
                'user_id'     => $userId,
                'phonenumber' => $faker->phoneNumber(),
                'occupation'  => $faker->jobTitle(),
                'gender'      => $faker->randomElement(['male', 'female']),
                'address'     => $faker->address(),
            ]);
        }
    }
}
