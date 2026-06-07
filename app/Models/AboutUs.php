<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Cache;

class AboutUs extends Model
{
    use HasFactory;

    // Defines the database table name explicitly
    protected $table = "about_us";

    // Specifies the fillable fields for mass assignment
    protected $fillable = [
        "title_fr",
        "title_ar",
        "title_en",
        "description_fr",
        "description_ar",
        "description_en",
    ];

    /**
     * Defines a polymorphic one-to-one relationship with the Image model.
     * This allows the AboutUs model to be associated with a single image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
