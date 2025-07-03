<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'ShopGrids',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'The name of your website',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Your trusted e-commerce partner',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'A brief description of your website',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'site_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'general',
                'label' => 'Site Logo',
                'description' => 'Upload your website logo',
                'sort_order' => 3,
                'is_active' => true,
            ],
            
            // Contact Information
            [
                'key' => 'contact_email',
                'value' => 'info@yourstore.com',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Contact Email',
                'description' => 'Main contact email address',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'support_email',
                'value' => 'support@yourstore.com',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Support Email',
                'description' => 'Support email address',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'phone_primary',
                'value' => '+966 12 345 6789',
                'type' => 'phone',
                'group' => 'contact',
                'label' => 'Primary Phone',
                'description' => 'Main phone number',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'phone_secondary',
                'value' => '+966 98 765 4321',
                'type' => 'phone',
                'group' => 'contact',
                'label' => 'Secondary Phone',
                'description' => 'Secondary phone number',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'key' => 'address',
                'value' => '123 Business Street, Commercial District, Riyadh, Saudi Arabia 12345',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Address',
                'description' => 'Business address',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'key' => 'working_hours',
                'value' => 'Mon-Fri: 9:00 AM - 6:00 PM, Sat: 10:00 AM - 4:00 PM, Sun: Closed',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Working Hours',
                'description' => 'Business working hours',
                'sort_order' => 6,
                'is_active' => true,
            ],

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter profile URL',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profile URL',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'linkedin_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'LinkedIn profile URL',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'key' => 'youtube_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube URL',
                'description' => 'YouTube channel URL',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '',
                'type' => 'phone',
                'group' => 'social',
                'label' => 'WhatsApp Number',
                'description' => 'WhatsApp business number',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($defaultSettings as $settingData) {
            Setting::updateOrCreate(
                ['key' => $settingData['key']],
                $settingData
            );
        }
    }
}
