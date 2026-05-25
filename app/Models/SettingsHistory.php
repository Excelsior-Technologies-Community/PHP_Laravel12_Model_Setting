<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsHistory extends Model
{
    protected $table = 'settings_histories';
    
    protected $fillable = [
        'user_id', 'key', 'old_value', 'new_value'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    // Belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Accessor for formatted old value
    public function getFormattedOldValueAttribute()
    {
        return $this->old_value ?: 'N/A';
    }
    
    // Accessor for formatted new value
    public function getFormattedNewValueAttribute()
    {
        return $this->new_value ?: 'Deleted';
    }
}