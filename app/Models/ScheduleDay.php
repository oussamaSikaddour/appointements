<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $doctor_id
 * @property int $schedule_id
 * @property \Illuminate\Support\Carbon $day_at
 * @property int $available_number
 * @property int $confirmed_number
 * @property int $cancelled_number
 * @property string $state
 * @property int|null $appointment_location_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class ScheduleDay extends Model
{
    use HasFactory, SoftDeletes;

    /** State constants */
    public const STATE_PUBLISHED = 'published';
    public const STATE_NOT_PUBLISHED = 'not_published';

    protected $casts = [
        'deleted_at' => 'datetime',
        'day_at' => 'date',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $fillable = [
        'doctor_id',
        'schedule_id',
        'day_at',
        'available_number',
        'confirmed_number',

        'specialty_id',
        'appointments_location_id',
    ];

    protected $attributes = [
        'available_number' => 1,
        'confirmed_number' => 0,
    ];



    /**
     * The schedule this day belongs to.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Location where appointments happen.
     */
    public function appointmentsLocation(): BelongsTo
    {
        return $this->belongsTo(Establishment::class,'appointments_location_id');
    }

    /**
     * Doctor assigned for this day.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(FieldSpecialty::class, 'specialty_id');
    }

    /**
     * Appointments on this schedule day.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }




}
