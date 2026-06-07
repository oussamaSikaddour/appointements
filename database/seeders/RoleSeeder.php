<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        $roles = [
            ['name' => 'SUPER ADMIN', 'slug' => 'super_admin'],
            ['name' => 'ADMIN', 'slug' => 'admin'],
            ['name' => 'AUTHOR', 'slug' => 'author'],
            ['name' => 'USER', 'slug' => 'user'],
            ['name' => 'APPROVER', 'slug' => 'approver'],
            ['name' => 'DOCTOR', 'slug' => 'doctor'],
            ['name' => 'ESTABLISHMENT ADMIN', 'slug' => 'establishment_admin'],
            ['name' => 'APPOINTMENTS LOCATION ADMIN', 'slug' => 'appointments_location_admin'],
            ['name' => 'SERVICE ADMIN', 'slug' => 'service_admin'],
        ];

        collect($roles)->each(function ($role) {
            Role::create($role);
        });
    }
}
