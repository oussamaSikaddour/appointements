<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('heros')->truncate();
        Schema::enableForeignKeyConstraints();
        Hero::create([
           'title_ar'=>'الشراكة المعلوماتية',
           'title_fr'=>'PARTENAIRE INFORMATIQUE',
           'title_en'=>'PARTENAIRE INFORMATIQUE',
           'sub_title_ar'=>'أكثر من مستشار',
           'sub_title_fr'=>"Plus qu'un consultant",
           'sub_title_en'=>"Plus qu'un consultant",
        ]);
    }
}
