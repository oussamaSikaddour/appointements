<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "year",
        "month",
        "name_fr",
        "name_ar",
        "name_en",
        "description_fr",
        "description_ar",
        "description_en",
        "state",//published or not_published
        "service_id",
        "opened_by"
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function ScheduleDays(): HasMany
    {
        return $this->hasMany(ScheduleDay::class);
    }


        public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"name_{$locale}"} ?? $this->name_fr ?? '';
    }
}
