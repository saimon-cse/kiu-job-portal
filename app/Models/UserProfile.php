<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    /**
     * We use $guarded = [] for convenience on tables with many fields,
     * but ensure validation is tight in Form Requests.
     * Alternatively, list all fields in $fillable.
     */
    protected $guarded = [];

    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * The user this profile belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The application this profile is a snapshot for (can be null).
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
