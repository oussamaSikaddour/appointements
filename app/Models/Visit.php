<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $appointment_id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string|null $notes_fr
 * @property string|null $notes_ar
 * @property string|null $notes_en
 * @property string|null $diagnostic_fr
 * @property string|null $diagnostic_ar
 * @property string|null $diagnostic_en
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Appointment $appointment
 * @property-read MedicalFile $patient
 * @property-read User $doctor
 * @property-read string $localized_notes
 * @property-read string $localized_diagnostic
 */
class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'visits';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'report_fr',
        'report_ar',
        'report_en',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at',
    ];


        public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

        public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    /**
     * Patient (medical file) associated with the visit.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(MedicalFile::class, 'patient_id');
    }

    /**
     * Doctor who performed the visit.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }



    /**
     * Get diagnostic based on current app locale.
     */
    public function getLocalizedReportAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"report_$locale"} ?? $this->report_fr ?? '';
    }
}
