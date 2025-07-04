<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\{
    UserEducation,
    UserExperience,
    Publication,
    LanguageProficiency,
    Referee,
    UserTraining,
    UserDocument
};
use App\Policies\{
    UserEducationPolicy,
    UserExperiencePolicy,
    PublicationPolicy,
    LanguageProficiencyPolicy,
    RefereePolicy,
    UserTrainingPolicy,
    UserDocumentPolicy
};



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        UserEducation::class => UserEducationPolicy::class,
        UserExperience::class => UserExperiencePolicy::class,
        Publication::class => PublicationPolicy::class,
        LanguageProficiency::class => LanguageProficiencyPolicy::class,
        Referee::class => RefereePolicy::class,
        UserTraining::class => UserTrainingPolicy::class,
        UserDocument::class => UserDocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //// Implicitly grant "super-admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can()
         Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
