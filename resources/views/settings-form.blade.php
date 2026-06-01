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
            color: white;
            cursor: pointer;
        }
        .btn-primary:hover { background: #4338ca; }

        .btn-success {
            background: #10b981;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
            color: white;
            margin-top: 10px;
            cursor: pointer;
        }
        .btn-success:hover { background: #059669; }

        .btn-secondary {
            background: #6b7280;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
            color: white;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
        }
        .btn-secondary:hover { background: #4b5563; }

        .text-muted {
            color: #6b7280;
            font-size: 0.875rem;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        #ajax-alert {
            display: none;
        }
        .validation-error {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 4px;
        }
    </style>
</head>
<body>
<div class="form-container">

    {{-- Laravel session success message (Normal Save pachhi aave) --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- AJAX success message (JS thi show/hide thay) --}}
    <div id="ajax-alert" class="alert-success"></div>

    {{-- Live Search Box --}}
    <div class="card mb-4">
        <div class="card-body py-3">
            <input type="text" id="searchInput" placeholder="Live Search Settings..." class="form-control">
        </div>
    </div>

    {{-- Main Settings Form --}}
    <div class="card">
        <div class="card-header">
            <h4>User Settings</h4>
            <p class="text-muted mb-0">Configure your application preferences</p>
        </div>
        <div class="card-body">

            {{-- 
                $settings variable controller thi aave che - array format ma
                Jો null hoy to empty array set kariye
            --}}
            @php
                $s = isset($settings) && is_array($settings) ? $settings : [];
            @endphp

            {{-- 
                IMPORTANT: Form fields na name attributes simple strings che (theme, language...)
                NOT settings[theme] - kyonke controller ma $request->validate(['theme' => ...]) use kari chhe
            --}}
            <form id="settingsForm" method="POST" action="{{ route('settings.update') }}">
                @csrf

                {{-- Theme --}}
                <div class="mb-4 setting-item" data-key="theme">
                    <label class="form-label">Theme</label>
                    <select name="theme" class="form-select" required>
                        <option value="light" {{ ($s['theme'] ?? 'light') === 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark"  {{ ($s['theme'] ?? '') === 'dark'  ? 'selected' : '' }}>Dark</option>
                    </select>
                    {{-- Laravel validation error show karva --}}
                    @error('theme')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Language --}}
                <div class="mb-4 setting-item" data-key="language">
                    <label class="form-label">Language</label>
                    <select name="language" class="form-select" required>
                        <option value="en" {{ ($s['language'] ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                        <option value="hi" {{ ($s['language'] ?? '') === 'hi' ? 'selected' : '' }}>Hindi</option>
                        <option value="gu" {{ ($s['language'] ?? '') === 'gu' ? 'selected' : '' }}>Gujarati</option>
                    </select>
                    @error('language')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Timezone --}}
                <div class="mb-4 setting-item" data-key="timezone">
                    <label class="form-label">Timezone</label>
                    <select name="timezone" class="form-select" required>
                        <option value="UTC"              {{ ($s['timezone'] ?? 'UTC') === 'UTC'              ? 'selected' : '' }}>UTC</option>
                        <option value="Asia/Kolkata"     {{ ($s['timezone'] ?? '') === 'Asia/Kolkata'     ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                        <option value="America/New_York" {{ ($s['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' }}>America/New York</option>
                        <option value="Europe/London"    {{ ($s['timezone'] ?? '') === 'Europe/London'    ? 'selected' : '' }}>Europe/London</option>
                    </select>
                    @error('timezone')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Date Format --}}
                <div class="mb-4 setting-item" data-key="date_format">
                    <label class="form-label">Date Format</label>
                    <select name="date_format" class="form-select" required>
                        <option value="Y-m-d" {{ ($s['date_format'] ?? 'Y-m-d') === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                        <option value="d/m/Y" {{ ($s['date_format'] ?? '') === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        <option value="m/d/Y" {{ ($s['date_format'] ?? '') === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                    </select>
                    @error('date_format')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Items Per Page --}}
                <div class="mb-4 setting-item" data-key="items_per_page">
                    <label class="form-label">Items Per Page</label>
                    <input type="number"
                           name="items_per_page"
                           class="form-control"
                           value="{{ $s['items_per_page'] ?? 10 }}"
                           min="5"
                           max="100"
                           required>
                    @error('items_per_page')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 
                    Notifications Checkbox
                    Hidden input value="0" - jyare checkbox uncheck hoy tyare 0 submit thay
                    Checkbox value="1"     - jyare check hoy tyare 1 submit thay
                --}}
                <div class="mb-4 form-check setting-item" data-key="notifications">
                    <input type="hidden"   name="notifications" value="0">
                    <input type="checkbox" name="notifications" value="1"
                           class="form-check-input" id="notify"
                           {{ ($s['notifications'] ?? 1) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="notify">Enable Notifications</label>
                </div>

                {{-- Buttons --}}
                <div class="d-grid">
                    {{-- Normal form submit - page reload kare che --}}
                    <button type="submit" class="btn-primary">Normal Save</button>

                    {{-- AJAX submit - page reload nathi karto --}}
                    <button type="button" id="ajaxBulkUpdate" class="btn-success">AJAX Bulk Update</button>

                    <a href="{{ route('dashboard') }}" class="btn-secondary">Back to Dashboard</a>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    // ============================================================
    // LIVE SEARCH - setting label ma query match karo
    // ============================================================
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();

        document.querySelectorAll('.setting-item').forEach(item => {
            // form-label ya form-check-label - banne check kariye
            const labelEl = item.querySelector('.form-label') || item.querySelector('.form-check-label');
            if (labelEl) {
                const matches = labelEl.innerText.toLowerCase().includes(query);
                item.style.display = matches ? 'block' : 'none';
            }
        });
    });

    // ============================================================
    // AJAX BULK UPDATE
    // FormData collect karo ane /bulk-update-ajax pe POST karo
    // ============================================================
    document.getElementById('ajaxBulkUpdate').addEventListener('click', function () {
        const btn      = this;
        const formEl   = document.getElementById('settingsForm');
        const formData = new FormData(formEl);

        btn.innerText    = 'Updating...';
        btn.disabled     = true;

        fetch('{{ route('settings.bulkUpdate') }}', {
            method: 'POST',
            body:   formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
                // Note: CSRF token FormData ma @csrf thi already hoy che
            }
        })
        .then(res => res.json())
        .then(data => {
            const alertBox = document.getElementById('ajax-alert');

            if (data.success) {
                alertBox.innerText       = data.message;
                alertBox.style.display   = 'block';
                alertBox.style.background = '#d1fae5'; // green
                alertBox.style.color      = '#065f46';
            } else {
                alertBox.innerText       = data.message || 'Something went wrong!';
                alertBox.style.display   = 'block';
                alertBox.style.background = '#fee2e2'; // red
                alertBox.style.color      = '#991b1b';
            }

            // 3 second pachhi hide karo
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
        })
        .catch(err => {
            console.error('AJAX Error:', err);
        })
        .finally(() => {
            btn.innerText = 'AJAX Bulk Update';
            btn.disabled  = false;
        });
    });
</script>
</body>
</html>