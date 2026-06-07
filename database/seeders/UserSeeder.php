<?php

namespace Database\Seeders;

use App\Models\BankingInformation;
use App\Models\Occupation;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();
        $user = User::create([
            'email' => 'superAdmin@gmail.com',
            'password' => Hash::make('Vide=1342'),
            'name_fr' => 'super Admin',
            'name_ar' => 'المشرف الرئيسي',
        ]);
        $user->roles()->attach(Role::where('slug', 'super_admin')->first());
        PersonnelInfo::create(["user_id"=>$user->id]);

    }
}
