<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'sort_order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $cacheKey = 'setting_' . $key;
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->where('is_active', true)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value, $type = 'text', $group = 'general', $label = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $label ?: $key,
                'is_active' => true,
            ]
        );

        // Clear cache
        Cache::forget('setting_' . $key);
        Cache::forget('settings_group_' . $group);

        return $setting;
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        $cacheKey = 'settings_group_' . $group;
        
        return Cache::remember($cacheKey, 3600, function () use ($group) {
            return self::where('group', $group)
                ->where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('label', 'asc')
                ->get()
                ->pluck('value', 'key');
        });
    }

    /**
     * Get all settings grouped
     */
    public static function getAllGrouped()
    {
        return self::where('is_active', true)
            ->orderBy('group', 'asc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('label', 'asc')
            ->get()
            ->groupBy('group');
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $groups = self::distinct('group')->pluck('group');
        
        foreach ($groups as $group) {
            Cache::forget('settings_group_' . $group);
        }

        $keys = self::pluck('key');
        foreach ($keys as $key) {
            Cache::forget('setting_' . $key);
        }
    }

    /**
     * Boot method to clear cache when settings are updated
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget('setting_' . $setting->key);
            Cache::forget('settings_group_' . $setting->group);
        });

        static::deleted(function ($setting) {
            Cache::forget('setting_' . $setting->key);
            Cache::forget('settings_group_' . $setting->group);
        });
    }

    /**
     * Scope for active settings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific group
     */
    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }
}
