<?php

namespace Database\Seeders;

use App\Models\Circular;
use App\Models\ApplicationHistory as JobApplication;
use App\Models\User;
use App\Services\SnapshotService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use App\Services\SnapshotService;

class DemoCircularsAndApplicationsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $snapshotService = resolve(SnapshotService::class);
        // 1. Ensure an Admin user exists to be the creator of the circulars
        $adminUser = User::where('email', 'admin@jobportal.test')->first();
        if (!$adminUser) {
            $adminUser = User::factory()->create([
                'name' => 'Default Admin',
                'email' => 'admin@jobportal.test',
            ]);
            $adminUser->assignRole('admin');
        }

        // 2. Create a couple of demo users who will apply for jobs
        $applicant1 = $this->createApplicant('Applicant One', 'applicant1@test.com');
        $applicant2 = $this->createApplicant('Applicant Two', 'applicant2@test.com');

        // 3. Create a sample Circular with multiple Job Posts
        $circular1 = Circular::create([
            'circular_no' => 'DEMO-CIRC-001',
            'post_date' => now()->subDays(10),
            'last_date_of_submission' => now()->addDays(20),
            'description' => 'We are hiring for multiple exciting positions in our technology department.',
            'status' => 'open',
            'created_by' => $adminUser->id,
        ]);

        $job1 = $circular1->jobs()->create([
            'post_name' => 'Senior Software Engineer (Backend)',
            'department_office' => 'Technology Division',
            'application_fee' => 100.00,
        ]);

        $job2 = $circular1->jobs()->create([
            'post_name' => 'Frontend Developer (React)',
            'department_office' => 'Technology Division',
            'application_fee' => 100.00,
        ]);

        // 4. Create another sample Circular
        $circular2 = Circular::create([
            'circular_no' => 'DEMO-CIRC-002',
            'post_date' => now()->subDays(5),
            'last_date_of_submission' => now()->addDays(15),
            'description' => 'Join our dynamic marketing team.',
            'status' => 'open',
            'created_by' => $adminUser->id,
        ]);

        $job3 = $circular2->jobs()->create([
            'post_name' => 'Digital Marketing Manager',
            'department_office' => 'Marketing Department',
            'application_fee' => 50.00,
        ]);

        // 5. Simulate applications and create snapshots

        // Applicant 1 applies for the Senior Software Engineer job
        $this->applyForJob($applicant1, $job1);

        // Applicant 2 applies for the Frontend Developer job
        $this->applyForJob($applicant2, $job2);

        // Applicant 2 also applies for the Marketing Manager job
        $this->applyForJob($applicant2, $job3);

        $this->command->info('Demo circulars, jobs, and applications with history snapshots have been created.');
    }

    /**
     * A helper method to create a user with pre-filled profile data.
     */
    private function createApplicant($name, $email)
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole('user');

        // Create some "live" profile data for this user
        $user->profile()->create([
            'full_name_en' => $name,
            'father_name_en' => $name . "'s Father",
            'mother_name_en' => $name . "'s Mother",
            'phone_mobile' => '01234567890',
            'dob' => '1990-01-01',
        ]);

        $user->educations()->create([
            'exam_name' => 'Bachelor of Science',
            'institution_name' => 'Demo University',
            'passing_year' => '2012',
            'gpa_or_cgpa' => '3.50',
        ]);

        $user->experiences()->create([
            'institute_name' => 'Some Company Ltd.',
            'post_and_scale' => 'Software Engineer',
            'from_date' => '2015-01-01',
            'to_date' => '2020-12-31',
        ]);

        return $user;
    }

    /**
     * A helper method to simulate a job application and trigger the snapshot service.
     */
    private function applyForJob(User $user, $job)
    {
        // $snapshotService = resolve(SnapshotService::class);
        // // Create the job application record
        // $application = JobApplication::create([
        //     'user_id' => $user->id,
        //     'job_id' => $job->id,
        //     'status' => 'submitted', // We assume it's paid/submitted for the seeder
        // ]);

        // // Call the static method on our service to create the snapshot
        // $snapshotService->createForJob($user, $job->id);
    }
}
