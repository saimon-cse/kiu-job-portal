<?php

namespace App\Models;

use App\Enums\JobStatus; // <-- Assumes you have this Enum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'circular_no',
        'post_name',
        'department_office',
        'description',
        'date',
        'application_fee',
        'last_date_of_submission',
        'status',
        'rank',
        'created_by',
    ];

    protected $casts = [
        'status' => JobStatus::class, // <-- Casts string to Enum object
        'date' => 'date',
        'last_date_of_submission' => 'date',
        'application_fee' => 'decimal:2',
    ];

    /**
     * The user (admin) who created this job.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The job can have many applications.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
