<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            RolePermissionSeeder::class,
            UserSeeder::class,
            CreateAdminSeeder::class,

            TeachingCategorySeeder::class,

            AcademicDomainSeeder::class,
            FormationSeeder::class,
            FiliereSeeder::class,

            ProgramSeeder::class,

            SpecialiteSeeder::class,
            LevelSeeder::class,


            SubjectSeeder::class,

            DocumentTypeSeeder::class,

            TagSeeder::class,

            TeachingCategorySeeder::class,

        ]);
    }
}
