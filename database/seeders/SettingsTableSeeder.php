<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method is idempotent, meaning it can be run multiple times
     * without creating duplicate entries, thanks to updateOrCreate().
     *
     * @return void
     */
    public function run(): void
    {
        $settings = [
            // --- Group: Site Settings ---
            [
                'key'          => 'site_title',
                'display_name' => 'Site Title',
                'value'        => 'JobPortal Pro',
                'type'         => 'text',
                'group'        => 'Site',
            ],
            [
                'key'          => 'site_logo',
                'display_name' => 'Site Logo',
                'value'        => '', // Path will be stored here after upload
                'type'         => 'image',
                'group'        => 'Site',
            ],
            [
                'key'          => 'site_favicon',
                'display_name' => 'Site Favicon',
                'value'        => '', // Path will be stored here after upload
                'type'         => 'image',
                'group'        => 'Site',
            ],
            [
                'key'          => 'footer_text',
                'display_name' => 'Footer Copyright Text',
                'value'        => '© ' . date('Y') . ' JobPortal Pro. All Rights Reserved.',
                'type'         => 'textarea',
                'group'        => 'Site',
            ],

            // --- Group: Contact Information ---
            [
                'key'          => 'contact_email',
                'display_name' => 'Contact Email',
                'value'        => 'contact@jobportal.test',
                'type'         => 'text',
                'group'        => 'Contact',
            ],
            [
                'key'          => 'contact_phone',
                'display_name' => 'Contact Phone Number',
                'value'        => '+1 (555) 123-4567',
                'type'         => 'text',
                'group'        => 'Contact',
            ],
            [
                'key'          => 'contact_address',
                'display_name' => 'Company Address',
                'value'        => "123 Job Seeker Lane, Employment City, EC 54321",
                'type'         => 'textarea',
                'group'        => 'Contact',
            ],

            // --- Group: Social Media Links ---
            // [
            //     'key'          => 'social_linkedin',
            //     'display_name' => 'LinkedIn URL',
            //     'value'        => 'https://linkedin.com/company/jobportal',
            //     'type'         => 'text',
            //     'group'        => 'Social',
            // ],
            // [
            //     'key'          => 'social_twitter',
            //     'display_name' => 'Twitter (X) URL',
            //     'value'        => 'https://twitter.com/jobportal',
            //     'type'         => 'text',
            //     'group'        => 'Social',
            // ],
            // [
            //     'key'          => 'social_facebook',
            //     'display_name' => 'Facebook URL',
            //     'value'        => 'https://facebook.com/jobportal',
            //     'type'         => 'text',
            //     'group'        => 'Social',
            // ],

            // --- Group: Job Board Configuration ---
            [
                'key'          => 'jobs_per_page',
                'display_name' => 'Jobs Shown Per Page',
                'value'        => '10',
                'type'         => 'number',
                'group'        => 'Job Board',
            ],
            [
                'key'          => 'allow_new_applications',
                'display_name' => 'Allow New Applications',
                'value'        => '1', // 1 for true/checked, 0 for false/unchecked
                'type'         => 'checkbox',
                'group'        => 'Job Board',
            ],

            // --- Group: SEO & Analytics ---
            [
                'key'          => 'seo_meta_description',
                'display_name' => 'Default Meta Description',
                'value'        => 'Find your next career opportunity with JobPortal Pro, the leading platform for professional job listings.',
                'type'         => 'textarea',
                'group'        => 'SEO',
            ],
            [
                'key'          => 'google_analytics_id',
                'display_name' => 'Google Analytics Tracking ID',
                'value'        => '', // e.g., 'UA-12345678-1'
                'type'         => 'text',
                'group'        => 'SEO',
            ],
        ];

        // Loop through the array and create or update each setting
        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']], // Find the setting by its unique key
                $setting                     // The data to insert or update
            );
        }
    }
}
