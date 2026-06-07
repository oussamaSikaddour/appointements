<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    // Enables soft deletes with deleted_at column
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "name",                 // Name of the slider
        "state",                // State (active/inactive)
        "user_id",              // Creator's user ID
        "sliderable_type",      // Polymorphic type for relation
        "sliderable_id",        // Polymorphic ID for relation
    ];

    /**
     * The user who created this slider.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * Polymorphic relation to the parent model (e.g. Service, Page, etc.)
     */
    public function sliderable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * A slider can have many slides.
     */
    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }
}
