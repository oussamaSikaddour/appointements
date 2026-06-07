<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralSetting extends Model
{
    use HasFactory, SoftDeletes;

    // Define 'deleted_at' as a date field for soft deletion
    protected $dates = ['deleted_at'];

    // Hide the 'deleted_at' attribute from array and JSON output
    protected $hidden = ["deleted_at"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "maintenance", // Boolean or flag indicating if the site is in maintenance mode
        "phone",       // Primary phone number
        "landline",    // Landline number
        "fax",         // Fax number
        "email",       // Contact email address
        "map"          // Embedded map code or URL (e.g., Google Maps iframe)
    ];

    /**
     * Define a polymorphic one-to-one relationship to the Image model.
     * Used for associating a logo image with the general settings.
     */
    public function logo(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
