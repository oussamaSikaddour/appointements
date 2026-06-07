<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            FieldSeeder::class,
            FieldSpecialtySeeder::class,
            FieldGradeSeeder::class,
            GeneralSettingSeeder::class,
            WilayaSeeder::class,
            DairaSeeder::class,
            HeroSeeder::class,
            AboutUsSeeder::class,
            SocialSeeder::class,
            BankSeeder::class,

        ]);
    }
}
