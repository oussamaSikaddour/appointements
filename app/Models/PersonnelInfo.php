<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonnelInfo extends Model
{
    use HasFactory, SoftDeletes;

    // Enables soft deletes and manages the deleted_at column
    protected $dates = ['deleted_at'];

    /**
     * Attributes that are mass assignable.
     */
    protected $fillable = [
        "last_name_ar",
        "first_name_ar",
        "last_name_fr",
        "first_name_fr",
        "card_number",
        "birth_place_ar",
        "birth_place_en",
        "birth_place_fr",
        "birth_date",
        "address_ar",
        "address_en",
        "address_fr",
        "phone",
        "user_id",
        'is_paid',           // Payment status
        'employee_number',   // Optional internal employee ID
        'social_number'
    ];

    /**
     * Attributes that should be hidden during serialization.
     */
    protected $hidden = [
        "deleted_at"
    ];

    /**
     * Defines the inverse relationship to the User model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
