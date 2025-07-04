<?php

namespace App\Models;

use App\Enums\ApplicationStatus; // <-- Make sure you have this Enum
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Represents a user's application for a specific job.
 *
 * This model is central to the data snapshot system. When an application
 * is submitted, related user data (profile, education, etc.) is copied
 * and linked to this application via the `application_id` foreign key.
 */
class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'job_id',
        'application_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Casts the 'status' string from the DB into a full ApplicationStatus Enum object.
        'status' => ApplicationStatus::class,
        // Casts the 'application_date' string/date from the DB into a Carbon object.
        'application_date' => 'date',
    ];

    // --- CORE RELATIONSHIPS ---

    /**
     * Get the user who submitted this application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job that this application is for.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }


    // --- DATA SNAPSHOT RELATIONSHIPS ---
    // These relationships retrieve the user data that was "frozen"
    // at the time this specific application was created.

    /**
     * Get the profile data snapshot for this application.
     */
    public function profileSnapshot(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the education records snapshot for this application.
     */
    public function educationSnapshots(): HasMany
    {
        return $this->hasMany(UserEducation::class);
    }

    /**
     * Get the work experience records snapshot for this application.
     */
    public function experienceSnapshots(): HasMany
    {
        return $this->hasMany(UserExperience::class);
    }

    /**
     * Get the publication records snapshot for this application.
     */
    public function publicationSnapshots(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    /**
     * Get the language proficiency records snapshot for this application.
     */
    public function languageProficiencySnapshots(): HasMany
    {
        return $this->hasMany(LanguageProficiency::class);
    }

    /**
     * Get the referee records snapshot for this application.
     */
    public function refereeSnapshots(): HasMany
    {
        return $this->hasMany(Referee::class);
    }

    /**
     * Get the training records snapshot for this application.
     */
    public function trainingSnapshots(): HasMany
    {
        return $this->hasMany(UserTraining::class);
    }

    /**
     * Get the document records snapshot for this application.
     */
    public function documentSnapshots(): HasMany
    {
        return $this->hasMany(UserDocument::class);
    }


    // --- QUERY SCOPES ---
    // These allow for clean, reusable query constraints in your controllers.

    /**
     * Scope a query to only include applications with 'submitted' status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubmitted(Builder $query): Builder
    {
        return $query->where('status', ApplicationStatus::SUBMITTED);
    }

    /**
     * Scope a query to only include applications with 'shortlisted' status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShortlisted(Builder $query): Builder
    {
        return $query->where('status', ApplicationStatus::SHORTLISTED);
    }

    /**
     * Scope a query to only include applications with 'paid' status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', ApplicationStatus::PAID);
    }

    /**
     * Scope a query to only include applications in a 'draft' state.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', ApplicationStatus::DRAFT);
    }
}
