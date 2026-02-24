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