<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These fields store URLs to various social media accounts.
     */
    protected $fillable = [
        "youtube",    // YouTube profile URL
        "facebook",   // Facebook profile URL
        "linkedin",   // LinkedIn profile URL
        "github",     // GitHub profile URL
        "instagram",  // Instagram profile URL
        "tiktok"      // TikTok profile URL
    ];
}
