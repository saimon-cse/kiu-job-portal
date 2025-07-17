<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'post_date' => 'date',
        'last_date_of_submission' => 'date',
    ];

    /**
     * A circular has many job posts.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * The admin who created the circular.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

        /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'circular_no'; // Use the 'circular_no' column for route model binding.
    }

    /**
     * Get all of the job applications for the circular through its jobs.
     * This defines the indirect relationship.
     */
    public function jobApplications()
    {
        return $this->hasManyThrough(ApplicationHistory::class, Job::class);
    }

    // NEW: Get applications with a specific status through its jobs
    public function applicationsWithStatus($status)
    {
        return $this->hasManyThrough(ApplicationHistory::class, Job::class)
                    ->where('applications_history.status', $status);
    }

}
