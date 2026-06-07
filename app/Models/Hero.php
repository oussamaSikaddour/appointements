<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    // Specify the table name explicitly (optional if following Laravel naming conventions)
    protected $table = "heros";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "title_ar",      // Arabic version of the hero title
        "title_fr",      // French version of the hero title
        "title_en",      // English version of the hero title
        "sub_title_ar",  // Arabic version of the sub-title
        "sub_title_fr",  // French version of the sub-title
        "sub_title_en",  // English version of the sub-title
    ];
}
