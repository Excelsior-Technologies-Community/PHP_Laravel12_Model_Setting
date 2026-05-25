<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SettingsHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    // Show Dashboard with all settings
    public function dashboard()
    {
        $user = User::first();
        if (!$user) {
            return redirect('/create-user')->with('error', 'Please create a user first');
        }
        
        $settings = $user->settings();
        $settingsData = $settings->getAllSettings();
        $historyCount = SettingsHistory::where('user_id', $user->id)->count();
        
        return view('dashboard', compact('user', 'settingsData', 'historyCount'));
    }

    // Create User
    public function createUser()
    {
        // Check if user already exists
        $user = User::first();
        if ($user) {
            return redirect('/dashboard')->with('info', 'User already exists!');
        }
        
        $user = User::create([
            'name' => 'Manasi',
            'email' => 'manasi@gmail.com',
            'password' => bcrypt('123456')
        ]);

        // Create default settings
        foreach ($user->defaultSettings() as $key => $value) {
            $user->setSetting($key, $value);
        }

        return redirect('/dashboard')->with('success', 'User Created Successfully!');
    }

    // Add Settings
    public function addSettings()
    {
        $user = User::first();
        
        if (!$user) {
            return redirect('/create-user')->with('error', 'No user found');
        }

        $user->setSetting('theme', 'dark');
        $user->setSetting('language', 'gu');
        $user->setSetting('notifications', true);

        return redirect('/dashboard')->with('success', 'Settings Added Successfully!');
    }

    // Show Settings Form
    public function showForm()
    {
        $user = User::first();
        $settings = $user ? $user->settings()->getAllSettings() : [];
        
        return view('settings-form', compact('user', 'settings'));
    }

    // Save Settings from Form
    public function saveSettings(Request $request)
    {
        $user = User::first();
        
        if (!$user) {
            return redirect('/create-user')->with('error', 'Please create a user first');
        }

        $validated = $request->validate([
            'theme' => 'required|in:light,dark',
            'language' => 'required|in:en,hi,gu',
            'notifications' => 'boolean',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'items_per_page' => 'required|integer|min:5|max:100',
        ]);

        $settings = [
            'theme' => $validated['theme'],
            'language' => $validated['language'],
            'notifications' => $request->has('notifications'),
            'timezone' => $validated['timezone'],
            'date_format' => $validated['date_format'],
            'items_per_page' => (int)$validated['items_per_page'],
        ];

        // Save all settings
        foreach ($settings as $key => $value) {
            $old = $user->getSetting($key);
            
            if ($old != $value) {
                $user->setSetting($key, $value);
                
                // Save history
                SettingsHistory::create([
                    'user_id' => $user->id,
                    'key' => $key,
                    'old_value' => $old,
                    'new_value' => $value,
                ]);
            }
        }

        // Clear cache
        Cache::forget("user_{$user->id}_settings");

        return redirect('/dashboard')->with('success', 'Settings Saved Successfully!');
    }

    // Get All Settings (API)
    public function getSettings()
    {
        $user = User::first();
        if (!$user) {
            return response()->json(['error' => 'No user found'], 404);
        }
        
        $settings = $user->settings()->getAllSettings();
        return response()->json($settings);
    }

    // Get Single Setting
    public function getSingle(Request $request)
    {
        $user = User::first();
        if (!$user) {
            return response()->json(['error' => 'No user found'], 404);
        }
        
        $key = $request->get('key', 'theme');
        return response()->json(['key' => $key, 'value' => $user->getSetting($key)]);
    }

    // Update Single Setting
    public function updateSetting(Request $request)
    {
        $user = User::first();
        if (!$user) {
            return response()->json(['error' => 'No user found'], 404);
        }
        
        $key = $request->get('key');
        $value = $request->get('value');
        
        $old = $user->getSetting($key);
        $user->setSetting($key, $value);
        
        SettingsHistory::create([
            'user_id' => $user->id,
            'key' => $key,
            'old_value' => $old,
            'new_value' => $value,
        ]);
        
        return response()->json(['message' => 'Setting Updated', 'old' => $old, 'new' => $value]);
    }

    // Delete Setting
    public function deleteSetting(Request $request)
    {
        $user = User::first();
        if (!$user) {
            return response()->json(['error' => 'No user found'], 404);
        }
        
        $key = $request->get('key', 'theme');
        
        $old = $user->getSetting($key);
        $settings = $user->settings();
        $settings->deleteSetting($key);
        
        SettingsHistory::create([
            'user_id' => $user->id,
            'key' => $key,
            'old_value' => $old,
            'new_value' => null,
        ]);
        
        return response()->json(['message' => 'Setting Deleted']);
    }

    // View Settings History
    public function settingsHistory()
    {
        $user = User::first();
        if (!$user) {
            return redirect('/create-user')->with('error', 'No user found');
        }
        
        $history = SettingsHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('history', compact('history', 'user'));
    }

    // Export Settings
    public function exportSettings()
    {
        $user = User::first();
        if (!$user) {
            return response()->json(['error' => 'No user found'], 404);
        }
        
        $settings = $user->settings()->getAllSettings();
        
        return response()->json([
            'user' => $user->name,
            'email' => $user->email,
            'settings' => $settings,
            'exported_at' => now()
        ]);
    }

    // Import Settings
    public function importSettings(Request $request)
    {
        $request->validate([
            'settings_file' => 'required|file|mimes:json|max:2048'
        ]);
        
        $user = User::first();
        if (!$user) {
            return redirect('/create-user')->with('error', 'No user found');
        }
        
        $content = json_decode(file_get_contents($request->file('settings_file')->getPathname()), true);
        
        if (isset($content['settings'])) {
            foreach ($content['settings'] as $key => $value) {
                $old = $user->getSetting($key);
                $user->setSetting($key, $value);
                
                SettingsHistory::create([
                    'user_id' => $user->id,
                    'key' => $key,
                    'old_value' => $old,
                    'new_value' => $value,
                ]);
            }
        }
        
        return redirect('/dashboard')->with('success', 'Settings Imported Successfully!');
    }

    // Reset to Default Settings
    public function resetSettings()
    {
        $user = User::first();
        
        if (!$user) {
            return redirect('/create-user')->with('error', 'No user found');
        }

        $oldSettings = $user->settings()->getAllSettings();
        
        // Clear all settings
        $settings = $user->settings();
        $settings->clearAllSettings();
        
        // Apply defaults
        foreach ($user->defaultSettings() as $key => $value) {
            $user->setSetting($key, $value);
            
            SettingsHistory::create([
                'user_id' => $user->id,
                'key' => $key,
                'old_value' => $oldSettings[$key] ?? null,
                'new_value' => $value,
            ]);
        }
        
        return redirect('/dashboard')->with('success', 'Settings Reset to Default!');
    }

    // Analytics Dashboard
    public function analytics()
    {
        $user = User::first();
        if (!$user) {
            return redirect('/create-user')->with('error', 'No user found');
        }
        
        $history = SettingsHistory::where('user_id', $user->id)
            ->select('key', DB::raw('count(*) as changes'))
            ->groupBy('key')
            ->get();
            
        $recentChanges = SettingsHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return view('analytics', compact('history', 'recentChanges', 'user'));
    }
}