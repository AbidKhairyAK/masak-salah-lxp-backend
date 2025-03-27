<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker::create();
        /**
         * Default user
         */

        // Admin user
        $admin = User::create([
            'name' => 'Admin Prodemy',
            'email' => 'dummy.admin@prosigmaka.com',
            'password' => 'dummypsm',
        ]);
        $admin->assignRole(RoleEnum::ADMIN);
        $admin->markEmailAsVerified();

        $student = User::create([
            'name' => 'Student Prodemy',
            'email' => 'dummy.student@prosigmaka.com',
            'password' => 'dummypsm',
        ]);
        $student->assignRole(RoleEnum::STUDENT);
        $student->markEmailAsVerified();

        $instructor = User::create([
            'name' => 'Teacher Prodemy',
            'email' => 'dummy.teacher@prosigmaka.com',
            'password' => 'dummypsm',
        ]);
        $instructor->assignRole(RoleEnum::INSTRUCTOR);
        $instructor->markEmailAsVerified();

        /**
         * Generate 5 random user
         */
        // for ($i = 0; $i < 3; $i++) {
        //     $user = User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->email,
        //         'password' => 'dummypsm',
        //     ]);
        //     $user->assignRole(RoleEnum::STUDENT);
        // }
    }
}
