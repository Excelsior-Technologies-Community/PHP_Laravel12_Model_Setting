<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        .form-container {
            max-width: 600px;
            margin: 50px auto;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: none;
        }
        
        .card-header {
            background: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 12px 12px 0 0;
        }
        
        .card-header h4 {
            margin: 0;
            color: #374151;
            font-weight: 600;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.625rem;
            transition: all 0.2s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }
        
        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            margin-top: 0.2rem;
        }
        
        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        
        .btn-primary {
            background: #4f46e5;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
        }
        
        .btn-primary:hover {
            background: #4338ca;
        }
        
        .btn-secondary {
            background: #6b7280;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
        .text-muted {
            color: #6b7280;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
<div class="form-container">
    <div class="card">
        <div class="card-header">
            <h4>User Settings</h4>
            <p class="text-muted mb-0">Configure your application preferences</p>
        </div>
        <div class="card-body">
            <form method="POST" action="/save-settings">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label">Theme</label>
                    <select name="theme" class="form-select" required>
                        <option value="light" {{ ($settings['theme'] ?? 'light') == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ ($settings['theme'] ?? '') == 'dark' ? 'selected' : '' }}>Dark</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Language</label>
                    <select name="language" class="form-select" required>
                        <option value="en" {{ ($settings['language'] ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="hi" {{ ($settings['language'] ?? '') == 'hi' ? 'selected' : '' }}>Hindi</option>
                        <option value="gu" {{ ($settings['language'] ?? '') == 'gu' ? 'selected' : '' }}>Gujarati</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Timezone</label>
                    <select name="timezone" class="form-select" required>
                        <option value="UTC" {{ ($settings['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="Asia/Kolkata" {{ ($settings['timezone'] ?? '') == 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                        <option value="America/New_York" {{ ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New York</option>
                        <option value="Europe/London" {{ ($settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Date Format</label>
                    <select name="date_format" class="form-select" required>
                        <option value="Y-m-d" {{ ($settings['date_format'] ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                        <option value="d/m/Y" {{ ($settings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        <option value="m/d/Y" {{ ($settings['date_format'] ?? '') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Items Per Page</label>
                    <input type="number" name="items_per_page" class="form-control" value="{{ $settings['items_per_page'] ?? 10 }}" min="5" max="100" required>
                </div>
                
                <div class="mb-4 form-check">
                    <input type="checkbox" name="notifications" class="form-check-input" id="notify" {{ ($settings['notifications'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notify">
                        Enable Notifications
                    </label>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn-primary">Save Settings</button>
                    <a href="/dashboard" class="btn-secondary">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>