<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'profile_picture', 'isActive', 'suspended_at',
    ];

    protected $hidden = [ 'password', 'remember_token', ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'isActive' => 'boolean',
        'suspended_at' => 'datetime',
    ];

    // --- RELATIONSHIPS FOR LIVE DATA ---

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }


    public function applicationHistories()
{
    return $this->hasMany(ApplicationHistory::class);
}

    public function educations()
    {
        return $this->hasMany(UserEducation::class);
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class);
    }

    public function publications()
    {
        return $this->hasMany(UserPublication::class);
    }

    public function awards()
{
    return $this->hasMany(UserAward::class);
}

    public function languageProficiencies()
    {
        return $this->hasMany(LanguageProficiency::class);
    }

    public function referees()
    {
        return $this->hasMany(Referee::class);
    }

    public function trainings()
    {
        return $this->hasMany(UserTraining::class);
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    // --- RELATIONSHIPS FOR APPLICATIONS ---

    public function jobApplications()
    {
        return $this->hasMany(ApplicationHistory::class);
    }

    public function profileHistory()
    {
        return $this->hasMany(UserProfileHistory::class);
    }

    public function educationHistory()
    {
        return $this->hasMany(UserEducationHistory::class);
    }

    public function experienceHistory()
    {
        return $this->hasMany(UserExperienceHistory::class);
    }

    public function publicationHistory()
    {
        return $this->hasMany(UserPublicationHistory::class);
    }

    public function trainingHistory()
    {
        return $this->hasMany(UserTrainingHistory::class);
    }

    public function languageHistory()
    {
        return $this->hasMany(LanguageProficiencyHistory::class);
    }

    public function refereeHistory()
    {
        return $this->hasMany(RefereeHistory::class);
    }

    public function awardHistory()
    {
        return $this->hasMany(UserAwardHistory::class);
    }

    public function documentHistory()
    {
        return $this->hasMany(UserDocumentHistory::class);
    }

    public function applicationHistory() { return $this->hasMany(ApplicationHistory::class); }

    public function hasAppliedFor($jobId)
    {
        return $this->jobApplications()->where('job_id', $jobId)->exists();
    }

    // public function createdJobApplications()
    // {
    //     return $this->hasMany(JobApplication::class, 'created_by');
    // }

    // --- RELATIONSHIPS FOR HISTORY ---

}
