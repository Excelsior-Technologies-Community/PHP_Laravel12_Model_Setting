<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelSetting extends Model
{
    protected $table = 'model_settings';
    
    protected $fillable = [
        'model_id',
        'model_type',
        'settings'
    ];
    
    protected $casts = [
        'settings' => 'encrypted:array'
    ];
    
    public function model()
    {
        return $this->morphTo();
    }
    
    public function getSetting($key, $default = null)
    {
        $settings = $this->getAllSettings();
        return $settings[$key] ?? $default;
    }
    
    public function setSetting($key, $value)
    {
        $settings = $this->getAllSettings();
        $settings[$key] = $value;
        $this->settings = $settings;
        $this->save();
        return $this;
    }
    
    public function getAllSettings()
    {
        $settings = $this->settings;
        
        if (is_string($settings)) {
            $decoded = json_decode($settings, true);
            $settings = is_array($decoded) ? $decoded : [];
        }
        
        return is_array($settings) ? $settings : [];
    }
    
    public function deleteSetting($key)
    {
        $settings = $this->getAllSettings();
        if (array_key_exists($key, $settings)) {
            unset($settings[$key]);
            $this->settings = $settings;
            $this->save();
        }
        return $this;
    }
    
    public function clearAllSettings()
    {
        $this->settings = [];
        $this->save();
        return $this;
    }
}