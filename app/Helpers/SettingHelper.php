<?php

if (!function_exists('setting')) {
    /**
     * Get setting value by key
     */
    function setting($key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('site_name')) {
    /**
     * Get site name
     */
    function site_name()
    {
        return setting('site_name', 'ShopGrids');
    }
}

if (!function_exists('site_logo')) {
    /**
     * Get site logo URL
     */
    function site_logo()
    {
        $logo = setting('site_logo');
        return $logo ? asset($logo) : asset('frontend/assets/images/logo/logo.svg');
    }
}

if (!function_exists('contact_email')) {
    /**
     * Get contact email
     */
    function contact_email()
    {
        return setting('contact_email', 'info@yourstore.com');
    }
}

if (!function_exists('contact_phone')) {
    /**
     * Get primary contact phone
     */
    function contact_phone()
    {
        return setting('phone_primary', '+966 12 345 6789');
    }
}

if (!function_exists('social_links')) {
    /**
     * Get all social media links
     */
    function social_links()
    {
        return [
            'facebook' => setting('facebook_url'),
            'twitter' => setting('twitter_url'),
            'instagram' => setting('instagram_url'),
            'linkedin' => setting('linkedin_url'),
            'youtube' => setting('youtube_url'),
            'whatsapp' => setting('whatsapp_number'),
        ];
    }
}

if (!function_exists('contact_info')) {
    /**
     * Get all contact information
     */
    function contact_info()
    {
        return [
            'email' => setting('contact_email'),
            'support_email' => setting('support_email'),
            'phone_primary' => setting('phone_primary'),
            'phone_secondary' => setting('phone_secondary'),
            'address' => setting('address'),
            'working_hours' => setting('working_hours'),
        ];
    }
} 