# PHP_Laravel12_Model_Setting


## Project Description

PHP_Laravel12_Model_Setting is a Laravel 12 based application that demonstrates how to store and manage dynamic settings for Eloquent models using the Model Settings package.

This project allows each model (such as User) to have its own customizable settings like theme, language, and notification preferences. These settings are stored in the database and can be created, updated, retrieved, and deleted easily without modifying the database structure.

The project is useful for implementing user-specific preferences, application configurations, feature toggles, and personalized settings in real-world Laravel applications.

This project follows Laravel’s MVC architecture and demonstrates best practices for model configuration, database interaction, controller logic, and settings management.


## Key Features

• Create and manage users
• Store dynamic settings for each user
• Default settings support
• Settings validation rules
• Add, update, retrieve, and delete settings
• Database-based settings storage
• Clean MVC architecture
• Beginner-friendly implementation


## Learning Objectives

After completing this project, you will understand:

• How to install and use Laravel packages
• How to store dynamic settings in database
• How to use Traits in Laravel models
• How to manage model-based configurations
• How to use controllers for settings management
• How Laravel handles database relationships



## Technologies Used

• PHP 8.2
• Laravel 12
• MySQL
• Composer
• Eloquent ORM
• Glorand Model Settings Package


---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Model_Setting "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Model_Setting

```

#### Explanation:

This command installs a fresh Laravel 12 application with all required core files, dependencies, and folder structure. 

It prepares the environment for building your Model Settings project.





## STEP 2: Database Setup 

### Open .env and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_model_setting
DB_USERNAME=root
DB_PASSWORD=



SESSION_DRIVER=file

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_model_setting

```

### Run this command:

```
php artisan optimize:clear

```

### Run this command:

```
php artisan migrate

```



#### Explanation:

This command clears configuration, cache, route, and compiled files to ensure Laravel loads fresh database settings.

This command creates default tables like users, jobs, and cache in your database using Laravel migration system.





## STEP 3: Install Model Settings Package

### Run command:

```
composer require glorand/laravel-model-settings

```

#### Explanation:

This installs the Model Settings package which allows storing dynamic settings for models like User, Product, etc., using database storage.





## STEP 4: Publish Model Settings Migration (Table Method)

### Run command:

```
php artisan model-settings:model-settings-table

```

### This creates migration:

```
database/migrations/xxxx_xx_xx_create_model_settings_table.php

```

### Run Migration

```
php artisan migrate

```

#### Explanation:

This command generates a migration file to create the model_settings table, which stores settings in JSON format linked to models.




## STEP 5: Create User Model (Example Model)

### Run:

```
php artisan make:model User -m

```

#### Explanation:

This creates a User model and migration file. The model represents a database table and allows interaction with user data.





## STEP 6: Update User Migration

### Open: database/migrations/xxxx_create_users_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('email')->unique();

            $table->string('password');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};


```

### Run migration:

```
php artisan migrate

```

#### Explanation:

This creates the users table in the database, which stores user information like name, email, and password.





## STEP 7: Update User Model 

### Open: app/Models/User.php

#### Full Code:

```
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

```

#### Explanation:

Here we add the HasSettingsTable trait, which enables settings functionality for the User model.




## STEP 8: Create Controller

### Run:

```
php artisan make:controller UserController

```

### Open: app/Http/Controllers/UserController.php

```
<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{

    // Create User
    public function createUser()
    {

        $user = User::create([
            'name' => 'Manasi',
            'email' => 'manasi@gmail.com',
            'password' => bcrypt('123456')
        ]);

        return "User Created Successfully";

    }


    // Add Settings
    public function addSettings()
    {

        $user = User::first();

        $user->settings()->set('theme', 'dark');

        $user->settings()->set('language', 'gu');

        return "Settings Added";

    }


    // Get Settings
    public function getSettings()
    {

        $user = User::first();

        return $user->settings()->all();

    }


    // Get Single Setting
    public function getSingle()
    {

        $user = User::first();

        return $user->settings()->get('theme');

    }


    // Update Setting
    public function updateSetting()
    {

        $user = User::first();

        $user->settings()->set('theme', 'light');

        return "Setting Updated";

    }


    // Delete Setting
    public function deleteSetting()
    {

        $user = User::first();

        $user->settings()->delete('theme');

        return "Setting Deleted";

    }

}

```

#### Explanation:

This creates a controller that handles business logic such as creating users and managing their settings.




## STEP 9: Add Routes

### Open: routes/web.php

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Default Laravel welcome page
Route::get('/', function () {
    return view('welcome');
});

// Create new user
Route::get('/create-user', [UserController::class, 'createUser']);

// Add settings to user
Route::get('/add-settings', [UserController::class, 'addSettings']);

// Get all settings
Route::get('/get-settings', [UserController::class, 'getSettings']);

// Get single setting
Route::get('/get-single', [UserController::class, 'getSingle']);

// Update setting
Route::get('/update-setting', [UserController::class, 'updateSetting']);

// Delete setting
Route::get('/delete-setting', [UserController::class, 'deleteSetting']);

```

#### Explanation:

Routes define URLs that connect browser requests to controller functions.




## STEP 10: Test in Browser

### Run server:

```
php artisan serve

```

### Open URLs:

```
http://127.0.0.1:8000/create-user
http://127.0.0.1:8000/add-settings
http://127.0.0.1:8000/get-settings
http://127.0.0.1:8000/get-single
http://127.0.0.1:8000/update-setting
http://127.0.0.1:8000/delete-setting

```

#### Explanation:

This starts Laravel development server so you can access project in browser.

These URLs execute controller functions and allow you to create users and manage their settings.




## So you can see Output:

### Create-User:


<img width="1915" height="781" alt="Screenshot 2026-02-24 120054" src="https://github.com/user-attachments/assets/05451fa0-71cb-45e5-8cbe-44a0860bfaa7" />


### Add-Settings:


<img width="1919" height="835" alt="Screenshot 2026-02-24 120132" src="https://github.com/user-attachments/assets/eb082192-923e-48b4-b5a2-8e70635cfc65" />


### Get-Settings:


<img width="1919" height="887" alt="Screenshot 2026-02-24 120215" src="https://github.com/user-attachments/assets/d0633a74-a194-4863-9c37-6eb39c8e16f9" />


### Get-Single:


<img width="1919" height="772" alt="Screenshot 2026-02-24 120234" src="https://github.com/user-attachments/assets/f8a1ca22-e72c-4e59-be52-42776577f5cd" />


### Update-Setting:


<img width="1919" height="912" alt="Screenshot 2026-02-24 120253" src="https://github.com/user-attachments/assets/a70b8869-d80d-40a7-a102-5c7c22d21f03" />


### Delete-Setting:


<img width="1919" height="862" alt="Screenshot 2026-02-24 120358" src="https://github.com/user-attachments/assets/44006207-ee97-489b-a6e1-6f2322477723" />



---


# Project Folder Structure:

```
PHP_Laravel12_Model_Setting
│
├── app
│   │
│   ├── Http
│   │   └── Controllers
│   │       └── UserController.php
│   │
│   ├── Models
│   │   └── User.php
│   │
│   └── Providers
│       └── AppServiceProvider.php
│
├── bootstrap
│   └── app.php
│
├── config
│   ├── app.php
│   ├── database.php
│   ├── cache.php
│   ├── session.php
│   └── model_settings.php   (published automatically by package if used)
│
├── database
│   │
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── xxxx_xx_xx_xxxxxx_create_model_settings_table.php
│   │
│   ├── factories
│   │
│   └── seeders
│       └── DatabaseSeeder.php
│
├── public
│   ├── index.php
│   └── .htaccess
│
├── resources
│   │
│   ├── views
│   │   └── welcome.blade.php
│   │
│   ├── css
│   └── js
│
├── routes
│   ├── web.php
│   └── console.php
│
├── storage
│   ├── app
│   ├── framework
│   │   ├── cache
│   │   ├── sessions
│   │   └── views
│   └── logs
│       └── laravel.log
│
├── tests
│
├── vendor
│
├── .env
├── .env.example
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
└── README.md

```
