<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAward extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Laravel would correctly guess 'user_awards', but this is for clarity.
     */
    protected $table = 'user_awards';

    /**
     * The attributes that are not mass assignable.
     * Using an empty array allows all attributes to be mass assigned.
     * Ensure strong validation in your Form Request or Controller.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     * No special casting needed for this model.
     */
    protected $casts = [];

    /**
     * Get the user that owns the award.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
