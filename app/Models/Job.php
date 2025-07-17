<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'application_fee' => 'decimal:2',
    ];

    /**
     * A job post belongs to one circular.
     */
    public function circular()
    {
        return $this->belongsTo(Circular::class);
    }

        public function jobApplications()
    {
        return $this->hasMany(ApplicationHistory::class);
    }

    // Relationship to its direct applications
    public function applications()
    {
        return $this->hasMany(ApplicationHistory::class, 'job_id');
    }
}
