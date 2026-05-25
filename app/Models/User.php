<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Settings relationship using polymorphic relation
    public function modelSettings()
    {
        return $this->morphMany(ModelSetting::class, 'model');
    }

    // Get or create settings
    public function settings()
    {
        $settings = $this->modelSettings()->first();
        
        if (!$settings) {
            $settings = new ModelSetting([
                'model_id' => $this->id,
                'model_type' => get_class($this),
                'settings' => json_encode($this->defaultSettings())
            ]);
            $this->modelSettings()->save($settings);
        }
        
        return $settings;
    }

    // Get setting value
    public function getSetting($key, $default = null)
    {
        $settings = $this->settings();
        return $settings->getSetting($key, $default);
    }

    // Set setting value
    public function setSetting($key, $value)
    {
        $settings = $this->settings();
        
        // Get old value for history
        $old = $settings->getSetting($key);
        
        // Set new value
        $settings->setSetting($key, $value);
        
        return $old;
    }

    // Default settings
    public function defaultSettings()
    {
        return [
            'theme' => 'light',
            'language' => 'en',
            'notifications' => true,
            'timezone' => 'UTC',
            'date_format' => 'Y-m-d',
            'items_per_page' => 10,
        ];
    }
    
    // Has many settings histories
    public function settingsHistories()
    {
        return $this->hasMany(SettingsHistory::class);
    }
}