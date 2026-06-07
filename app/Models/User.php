<?php

namespace App\Models;

use App\Enum\Web\RoutesNames;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read Model|null $administrator_of
 * @property-read string $localized_name
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name_ar',
        'name_fr',
        'email',
        'password',
        'is_active',
        'establishment_id',
        'appointments_location_id',
        'service_id',
    ];

    /**
     * Attributes hidden during serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * Cast fields to native types.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User belongs to an Establishment.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
    public function appointmentsLocation(): BelongsTo
    {
        return $this->belongsTo(Establishment::class,'appointments_location_id');
    }

    /**
     * User belongs to a Service.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * User can belong to many roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * User can have many occupations.
     */
    public function occupations(): HasMany
    {
        return $this->hasMany(Occupation::class);
    }

    /**
     * User has one personnel info.
     */
    public function personnelInfo(): HasOne
    {
        return $this->hasOne(PersonnelInfo::class);
    }

    /**
     * User can have many uploaded files (polymorphic).
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * User can have many banking information records (polymorphic).
     */
    public function bankingInformation(): MorphMany
    {
        return $this->morphMany(BankingInformation::class, 'bankable');
    }

    /**
     * User can have many images (polymorphic).
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * User can open many medical files.
     */
    public function medicalFiles(): HasMany
    {
        return $this->hasMany(MedicalFile::class, 'opened_by');
    }
    public function doctorAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }



    /**
     * User as doctor can have many schedule days.
     */
    public function scheduleDays(): HasMany
    {
        return $this->hasMany(ScheduleDay::class, 'doctor_id');
    }


    /**
     * Accessor: return user's localized name (Arabic if locale=ar, else French).
     */
    public function getLocalizedNameAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->name_ar ?? $this->name_fr ?? 'unknown')
            : ($this->name_fr ?? 'unknown');
    }

    /**
     * Decide which route to redirect this user to, based on roles.
     */
public function resolveRedirectRouteForUser(): string
{
    if (!$this->relationLoaded('roles')) {
        $this->load('roles');
    }

    $roles = $this->roles->pluck('slug')->toArray();

    // ✅ Always set all possible session values first
    if (in_array('establishment_admin', $roles)) {
        session(['establishment_id' => $this->establishment_id]);
    }

    if (in_array('appointments_location_admin', $roles)) {
        session(['appointments_location_id' => $this->appointments_location_id]);
    }

    if (in_array('service_admin', $roles) || in_array('doctor', $roles)) {
        session(['service_id' => $this->service_id]);
    }

    // ✅ Then decide redirect route by priority
    $rolePriority = [
        'super_admin'                => RoutesNames::SUPER_ADMIN_ROUTE->value,
        'admin'                      => RoutesNames::ADMIN_ROUTE->value,
        'establishment_admin'        => RoutesNames::ESTABLISHMENT_ADMIN_ROUTE->value,
        'appointments_location_admin'=> RoutesNames::APPOINTMENTS_LOCATION_ADMIN_ROUTE->value,
        'service_admin'              => RoutesNames::SERVICE_ADMIN_ROUTE->value,
        'doctor'                     => RoutesNames::DOCTOR_ROUTE->value,
    ];

    foreach ($rolePriority as $role => $route) {
        if (in_array($role, $roles)) {
            return $route; // first match wins
        }
    }

    return RoutesNames::USER_ROUTE->value;
}


}
