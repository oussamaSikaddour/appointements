<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $withCount = ['appointments'];

    protected $fillable = [
        "last_name_fr",
        "first_name_fr",
        "last_name_ar",
        "first_name_ar",
        'gender',
        "code",
        "birth_place_fr",
        "birth_place_ar",
        "birth_place_en",
        "birth_date",
        "address_fr",
        "address_ar",
        "address_en",
        "tel",
        "opened_by",
        "insurance_number",
    ];

    protected $hidden = [
        "deleted_at",
    ];

    /**
     * User who opened the file.
     */
    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    /**
     * Appointments for this patient.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /**
     * Visits for this patient.
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }

    /**
     * Files attached to this medical file.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Images attached to this medical file.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get localized first name.
     */
    public function getLocalizedFirstNameAttribute(): string
    {
        if (app()->getLocale() === 'ar') {
            return $this->first_name_ar ?? $this->first_name_fr ?? 'unknown';
        }
        return $this->first_name_fr ?? 'unknown';
    }

    /**
     * Get localized last name.
     */
    public function getLocalizedLastNameAttribute(): string
    {
        if (app()->getLocale() === 'ar') {
            return $this->last_name_ar ?? $this->last_name_fr ?? 'unknown';
        }
        return $this->last_name_fr ?? 'unknown';
    }

    /**
     * Get localized full name.
     */
    public function getLocalizedFullNameAttribute(): string
    {
        return $this->localizedFirstName . ' ' . $this->localizedLastName;
    }
}
