<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // reset laravel-permission cache before seeding to avoid conflict
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            StudentSeeder::class,
            InstructorSeeder::class,
            CourseSeeder::class,
            FullCourseContentSeeder::class,
            PracticeSingleChoiceSeeder::class,
            AccessCodeSeeder::class,
        ]);
    }
}
