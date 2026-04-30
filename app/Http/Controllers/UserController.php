<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $old = $user->settings()->get('theme');

        $user->settings()->set('theme', 'light');

        // Save history
        DB::table('settings_histories')->insert([
            'user_id' => $user->id,
            'key' => 'theme',
            'old_value' => $old,
            'new_value' => 'light',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return "Setting Updated with History";
    }


    // Delete Setting
    public function deleteSetting()
    {
        $user = User::first();

        $old = $user->settings()->get('theme');

        $user->settings()->delete('theme');

        // Save history
        DB::table('settings_histories')->insert([
            'user_id' => $user->id,
            'key' => 'theme',
            'old_value' => $old,
            'new_value' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return "Setting Deleted with History";
    }


    // NEW: Show Settings Form
    public function showForm()
    {
        return view('settings');
    }


    // NEW: Save Settings from Form + History
    public function saveSettings(Request $request)
    {
        $user = User::first();

        $settings = ['theme', 'language', 'notifications'];

        foreach ($settings as $key) {

            $old = $user->settings()->get($key);
            $new = $request->$key;

            // Checkbox fix
            if ($key == 'notifications') {
                $new = $request->has('notifications') ? true : false;
            }

            $user->settings()->set($key, $new);

            // Save history
            DB::table('settings_histories')->insert([
                'user_id' => $user->id,
                'key' => $key,
                'old_value' => $old,
                'new_value' => $new,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return "Settings Saved Successfully with History";
    }


    // NEW: View Settings History
    public function settingsHistory()
    {
        return DB::table('settings_histories')->get();
    }


    // NEW: Reset Settings
    public function resetSettings()
    {
        $user = User::first();

        if (!$user) {
            return "No user found";
        }

        $oldSettings = $user->settings()->all();

        // Clear all settings
        $user->settings()->clear();

        // Reapply defaults + history
        foreach ($user->defaultSettings as $key => $value) {

            $old = $oldSettings[$key] ?? null;

            $user->settings()->set($key, $value);

            // Save history
            DB::table('settings_histories')->insert([
                'user_id' => $user->id,
                'key' => $key,
                'old_value' => $old,
                'new_value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return "Settings Fully Reset with History";
    }
}
