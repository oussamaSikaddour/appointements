<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establishment extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "acronym",
        "name_fr",
        "name_en",
        "name_ar",
        "email",
        "address_fr",
        "address_ar",
        "address_en",
         "description_fr",
         "description_en",
         "description_ar",
        "tel",
        "fax",
         'daira_id',
        'longitude',
        'latitude',
         'types',//array of types , possible , class_a, appointment_locations,
    ];

    protected $casts = [
    'types' => 'array',
];
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
    public function daira(): BelongsTo
    {
        return $this->belongsTo(Daira::class);
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class,'appointments_location_id');
    }



   public function administrators():BelongsTo
    {
          return $this->hasOne(User::class, 'attached_to')
                ->whereHas('roles', function ($q) {
                    $q->whereIn('slug', ['establishment_admin', 'establishment_coord']
                );
                });
    }

            public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale(); // e.g., 'ar', 'fr', or 'en'
        return $this->{"name_$locale"} ?? $this->name_fr ?? '';
    }

}
