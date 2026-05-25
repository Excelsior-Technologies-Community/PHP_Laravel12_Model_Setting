<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCategory extends Model
{
    protected $table = 'settings_categories';
    
    protected $fillable = [
        'name', 'slug', 'description'
    ];
    
    // If you don't have the migration yet, create it
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }
}