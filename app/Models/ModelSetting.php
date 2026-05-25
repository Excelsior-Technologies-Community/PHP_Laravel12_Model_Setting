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
        'settings' => 'array'
    ];
    
    // Get the parent model
    public function model()
    {
        return $this->morphTo();
    }
    
    // Get a specific setting value
    public function getSetting($key, $default = null)
    {
        $settings = is_array($this->settings) ? $this->settings : json_decode($this->settings, true);
        return $settings[$key] ?? $default;
    }
    
    // Set a specific setting value
    public function setSetting($key, $value)
    {
        $settings = is_array($this->settings) ? $this->settings : json_decode($this->settings, true);
        $settings[$key] = $value;
        $this->settings = json_encode($settings);
        $this->save();
        return $this;
    }
    
    // Get all settings (renamed from all() to getAll() to avoid conflict)
    public function getAllSettings()
    {
        return is_array($this->settings) ? $this->settings : json_decode($this->settings, true);
    }
    
    // Delete a specific setting
    public function deleteSetting($key)
    {
        $settings = is_array($this->settings) ? $this->settings : json_decode($this->settings, true);
        unset($settings[$key]);
        $this->settings = json_encode($settings);
        $this->save();
        return $this;
    }
    
    // Clear all settings
    public function clearAllSettings()
    {
        $this->settings = json_encode([]);
        $this->save();
        return $this;
    }
}