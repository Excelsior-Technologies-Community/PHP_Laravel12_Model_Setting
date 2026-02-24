<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Glorand\Model\Settings\Traits\HasSettingsTable;

class User extends Model
{

    use HasSettingsTable;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    */

    public $defaultSettings = [

        'theme' => 'light',

        'language' => 'en',

        'notifications' => true,

    ];

    /*
    |--------------------------------------------------------------------------
    | Settings Validation Rules
    |--------------------------------------------------------------------------
    */

    public $settingsRules = [

        'theme' => 'string',

        'language' => 'string|in:en,hi,gu',

        'notifications' => 'boolean',

    ];

}