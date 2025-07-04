<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEducation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Laravel's convention handles this, but it can be specified for clarity.
     */
    protected $table = 'user_educations';

    /**
     * The attributes that are not mass assignable.
     * An empty array means all attributes are mass assignable.
     * Ensure you have strong validation in your Form Request classes.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     * No special casting needed for this model based on the migration.
     */
    protected $casts = [];

    // --- RELATIONSHIPS ---

    /**
     * The user this education record belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The application this education record is a snapshot for (can be null).
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
