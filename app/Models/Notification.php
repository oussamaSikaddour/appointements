<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;

    // The attributes that are mass assignable
    protected $fillable = [
        "message",           // The notification message content
        "active",            // Boolean to indicate if the notification is active
        "for_type",          // Type of recipient (e.g., user, admin)
        "targetable_id",     // ID of the associated target model (polymorphic)
        "targetable_type"    // Class name of the associated model (polymorphic)
    ];
}
