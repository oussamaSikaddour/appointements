<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('about_us')->truncate();
        Schema::enableForeignKeyConstraints();
        AboutUs::create([
           'title_ar'=>'ماذا عنا',
           'title_fr'=>'à propos de nous',
            'title_en'=>'About Us',
           'description_fr'=>"Fondée par des ingénieurs expérimentés et certifiés dans le domaine, DarticSolutions est aujourd’hui l’une des sociétés leader dans le domaine d’intégration des solutions informatiques, spécialement ceux basées sur les technologies Open Source.",
           'description_en'=>"Founded by experienced and certified engineers in the field, DarticSolutions is today one of the leading companies in the field of integration of IT solutions, especially those based on Open Source technologies.",
           'description_ar'=>"تأسست DarticSolutions على يد مهندسين ذوي خبرة ومعتمدين في هذا المجال، وهي اليوم واحدة من الشركات الرائدة في مجال تكامل حلول تكنولوجيا المعلومات، وخاصة تلك التي تعتمد على تقنيات مفتوحة المصدر.",
        ]);
    }
}
