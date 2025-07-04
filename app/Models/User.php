<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// 2. IMPLEMENT THE CONTRACT IN THE CLASS DEFINITION
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'isActive',
        'suspended_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // This 'email_verified_at' cast is essential for the verification system
        'email_verified_at' => 'datetime',
        'suspended_at' => 'datetime',
        'isActive' => 'boolean',
        // 'password' => 'hashed',
    ];

    // --- RELATIONSHIPS (No changes needed here) ---

    /**
     * A user's main profile is the one not tied to a specific application.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class)->whereNull('application_id');
    }

    /**
     * A user can submit many applications.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * A user has a set of education records not tied to an application.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(UserEducation::class)->whereNull('application_id');
    }

    /**
     * A user has a set of experience records not tied to an application.
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(UserExperience::class)->whereNull('application_id');
    }

    /**
     * A user has a set of publications not tied to an application.
     */
    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class)->whereNull('application_id');
    }

    /**
     * A user has a set of documents not tied to an application.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(UserDocument::class)->whereNull('application_id');
    }

    /**
     * A user has a set of trainings not tied to an application.
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(UserTraining::class)->whereNull('application_id');
    }

    /**
     * A user has a set of language proficiencies not tied to an application.
     */
    public function languageProficiencies(): HasMany
    {
        return $this->hasMany(LanguageProficiency::class)->whereNull('application_id');
    }

    /**
     * A user has a set of referees not tied to an application.
     */
    public function referees(): HasMany
    {
        return $this->hasMany(Referee::class)->whereNull('application_id');
    }

    /**
     * A user (admin) can create many jobs.
     */
    public function createdJobs(): HasMany
    {
        return $this->hasMany(Job::class, 'created_by');
    }
}
