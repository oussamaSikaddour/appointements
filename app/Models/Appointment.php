<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory ,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "patient_id",
        "schedule_day_id",
        'appointments_location_id',
        "type",//new OR Follow-up,
        "initiator",
        "day_at",
        "specialty_id",
        "doctor_id",

    ];
    public function referralLetter(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(MedicalFile::class, "patient_id");
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, "doctor_id");
    }
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(FieldSpecialty::class,"specialty_id" );
    }
    public function appointmentsLocation(): BelongsTo
    {
        return $this->belongsTo(Establishment::class,'appointments_location_id');
    }
    public function scheduleDay(): BelongsTo
    {
        return $this->belongsTo(ScheduleDay::class);
    }

}
