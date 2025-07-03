<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories with all frontend views
        View::composer(['frontend.layout', 'frontend.*'], function ($view) {
            $headerCategories = Category::where('status', 'active')
                ->withCount('products')
                ->orderBy('name', 'asc')
                ->limit(10)
                ->get();
            
            // Load settings data (only if not in console to avoid migration errors)
            if (!app()->runningInConsole()) {
                try {
                    // Load site settings
                    $siteSettings = [
                        'site_name' => setting('site_name', 'ShopGrids'),
                        'site_description' => setting('site_description', 'Your trusted e-commerce partner'),
                        'site_logo' => setting('site_logo') ? asset(setting('site_logo')) : asset('frontend/assets/images/logo/logo.svg'),
                        'site_logo_white' => setting('site_logo') ? asset(setting('site_logo')) : asset('frontend/assets/images/logo/white-logo.svg'),
                    ];

                    // Load contact information
                    $contactInfo = [
                        'email' => setting('contact_email', 'info@yourstore.com'),
                        'support_email' => setting('support_email', 'support@yourstore.com'),
                        'phone_primary' => setting('phone_primary', '+966 12 345 6789'),
                        'phone_secondary' => setting('phone_secondary', '+966 98 765 4321'),
                        'address' => setting('address', '123 Business Street, Commercial District, Riyadh, Saudi Arabia 12345'),
                        'working_hours' => setting('working_hours', 'Mon-Fri: 9:00 AM - 6:00 PM, Sat: 10:00 AM - 4:00 PM, Sun: Closed'),
                    ];

                    // Load social media links
                    $socialLinks = [
                        'facebook' => setting('facebook_url'),
                        'twitter' => setting('twitter_url'),
                        'instagram' => setting('instagram_url'),
                        'linkedin' => setting('linkedin_url'),
                        'youtube' => setting('youtube_url'),
                        'whatsapp' => setting('whatsapp_number'),
                    ];

                    $view->with([
                        'headerCategories' => $headerCategories,
                        'siteSettings' => $siteSettings,
                        'contactInfo' => $contactInfo,
                        'socialLinks' => $socialLinks,
                    ]);

                } catch (\Exception $e) {
                    // Fallback values in case of errors
                    $view->with([
                        'headerCategories' => $headerCategories,
                        'siteSettings' => [
                            'site_name' => 'ShopGrids',
                            'site_description' => 'Your trusted e-commerce partner',
                            'site_logo' => asset('frontend/assets/images/logo/logo.svg'),
                            'site_logo_white' => asset('frontend/assets/images/logo/white-logo.svg'),
                        ],
                        'contactInfo' => [
                            'email' => 'info@yourstore.com',
                            'support_email' => 'support@yourstore.com',
                            'phone_primary' => '+966 12 345 6789',
                            'phone_secondary' => '+966 98 765 4321',
                            'address' => '123 Business Street, Commercial District, Riyadh, Saudi Arabia 12345',
                            'working_hours' => 'Mon-Fri: 9:00 AM - 6:00 PM, Sat: 10:00 AM - 4:00 PM, Sun: Closed',
                        ],
                        'socialLinks' => [
                            'facebook' => '',
                            'twitter' => '',
                            'instagram' => '',
                            'linkedin' => '',
                            'youtube' => '',
                            'whatsapp' => '',
                        ],
                    ]);
                }
            } else {
                $view->with('headerCategories', $headerCategories);
            }
        });
    }
}
