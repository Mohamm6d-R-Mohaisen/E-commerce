<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\SaveImageTrait;

class SettingController extends Controller
{
    use SaveImageTrait;

    /**
     * Display a listing of the settings grouped by category with edit form.
     */
    public function index()
    {
        $settingsGrouped = Setting::where('is_active', true)
            ->orderBy('group', 'asc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('label', 'asc')
            ->get()
            ->groupBy('group');
        
        return view('admin.settings.index', compact('settingsGrouped'));
    }

    /**
     * Update the settings in storage.
     */
    public function update(Request $request)
    {
        // Validation rules
        $rules = [
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'support_email' => 'nullable|email|max:255',
            'phone_primary' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'facebook_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'working_hours' => 'nullable|string|max:500',
        ];

        $request->validate($rules);

        try {
            $inputs = $request->except(['_token', '_method']);
            
            foreach ($inputs as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                
                if ($setting) {
                    // Handle file uploads for image type settings
                    if ($setting->type === 'image' && $request->hasFile($key)) {
                        // Delete old image if exists
                        if ($setting->value && file_exists(public_path($setting->value))) {
                            unlink(public_path($setting->value));
                        }
                        
                        $value = $this->saveImage($request->file($key), 'settings');
                    }
                    
                    // Handle checkbox values (convert to 1 or 0)
                    if ($setting->type === 'checkbox') {
                        $value = $request->has($key) ? '1' : '0';
                    }
                    
                    $setting->update(['value' => $value]);
                }
            }

            // Clear all settings cache
            Setting::clearCache();

            return redirect()->route('admin.settings.index')
                ->with('success', 'Settings updated successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating settings: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Initialize default settings if they don't exist
     */
    public function initializeDefaults()
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
                'sort_order' => 1
            ],
            [
                'key' => 'site_description',
                'value' => 'Your trusted e-commerce partner',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'A brief description of your website',
                'sort_order' => 2
            ],
            [
                'key' => 'site_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'general',
                'label' => 'Site Logo',
                'description' => 'Upload your website logo',
                'sort_order' => 3
            ],
            
            // Contact Information
            [
                'key' => 'contact_email',
                'value' => 'info@yourstore.com',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Contact Email',
                'description' => 'Main contact email address',
                'sort_order' => 1
            ],
            [
                'key' => 'support_email',
                'value' => 'support@yourstore.com',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Support Email',
                'description' => 'Support email address',
                'sort_order' => 2
            ],
            [
                'key' => 'phone_primary',
                'value' => '+966 12 345 6789',
                'type' => 'phone',
                'group' => 'contact',
                'label' => 'Primary Phone',
                'description' => 'Main phone number',
                'sort_order' => 3
            ],
            [
                'key' => 'phone_secondary',
                'value' => '+966 98 765 4321',
                'type' => 'phone',
                'group' => 'contact',
                'label' => 'Secondary Phone',
                'description' => 'Secondary phone number',
                'sort_order' => 4
            ],
            [
                'key' => 'address',
                'value' => '123 Business Street, Commercial District, Riyadh, Saudi Arabia 12345',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Address',
                'description' => 'Business address',
                'sort_order' => 5
            ],
            [
                'key' => 'working_hours',
                'value' => 'Mon-Fri: 9:00 AM - 6:00 PM, Sat: 10:00 AM - 4:00 PM, Sun: Closed',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Working Hours',
                'description' => 'Business working hours',
                'sort_order' => 6
            ],

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL',
                'sort_order' => 1
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter profile URL',
                'sort_order' => 2
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profile URL',
                'sort_order' => 3
            ],
            [
                'key' => 'linkedin_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'LinkedIn profile URL',
                'sort_order' => 4
            ],
            [
                'key' => 'youtube_url',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube URL',
                'description' => 'YouTube channel URL',
                'sort_order' => 5
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '',
                'type' => 'phone',
                'group' => 'social',
                'label' => 'WhatsApp Number',
                'description' => 'WhatsApp business number',
                'sort_order' => 6
            ],
        ];

        foreach ($defaultSettings as $settingData) {
            Setting::updateOrCreate(
                ['key' => $settingData['key']],
                $settingData
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Default settings initialized successfully.');
    }

    /**
     * Reset cache for all settings
     */
    public function clearCache()
    {
        Setting::clearCache();
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings cache cleared successfully.');
    }
}
