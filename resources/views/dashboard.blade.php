<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Settings Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #4f46e5;
        }
        
        .nav-link {
            color: #6b7280;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: #4f46e5;
        }
        
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            color: #6b7280;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .settings-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-header-custom {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            color: #374151;
        }
        
        .setting-item {
            border-bottom: 1px solid #f3f4f6;
            padding: 1rem 1.5rem;
            transition: background 0.2s;
        }
        
        .setting-item:hover {
            background: #f9fafb;
        }
        
        .setting-key {
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .setting-value {
            font-size: 1rem;
            color: #111827;
            margin-top: 0.25rem;
        }
        
        .btn-primary {
            background: #4f46e5;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background: #4338ca;
        }
        
        .btn-outline {
            background: white;
            border: 1px solid #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-outline:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .btn-danger {
            background: #ef4444;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-danger:hover {
            background: #dc2626;
        }
        
        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 8px;
            padding: 1rem;
        }
        
        .alert-info {
            background: #dbeafe;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            border-radius: 8px;
            padding: 1rem;
        }
        
        .badge-enabled {
            background: #d1fae5;
            color: #065f46;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        
        .badge-disabled {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="/dashboard">Settings Manager</a>
        <div>
            <a class="nav-link d-inline-block me-3" href="/dashboard">Dashboard</a>
            <a class="nav-link d-inline-block me-3" href="/settings-form">Settings</a>
            <a class="nav-link d-inline-block" href="/settings-history">History</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-info mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert-info mb-4">
            {{ session('info') }}
        </div>
    @endif

    

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ count($settingsData) }}</div>
                <div class="stats-label">Total Settings</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card">
                <div class="stats-number">{{ $historyCount }}</div>
                <div class="stats-label">History Records</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card">
                <div class="stats-number text-success">Active</div>
                <div class="stats-label">Status</div>
            </div>
        </div>
    </div>

    <!-- Current Settings -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="settings-card">
                <div class="card-header-custom">
                    Current Settings
                </div>
                <div>
                    @foreach($settingsData as $key => $value)
                    <div class="setting-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="setting-key">{{ $key }}</div>
                                <div class="setting-value">
                                    @if($key == 'notifications')
                                        @if($value)
                                            <span class="badge-enabled">Enabled</span>
                                        @else
                                            <span class="badge-disabled">Disabled</span>
                                        @endif
                                    @elseif($key == 'theme')
                                        {{ ucfirst($value) }}
                                    @elseif($key == 'language')
                                        {{ strtoupper($value) }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </div>
                            </div>
                            <button class="btn-outline" style="padding: 0.25rem 1rem;" onclick="editSetting('{{ $key }}', '{{ $value }}')">
                                Edit
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="settings-card">
                <div class="card-header-custom">
                    Quick Actions
                </div>
                <div class="p-4">
                    <div class="d-grid gap-2">
                        <a href="/settings-form" class="btn-primary" style="text-align: center; text-decoration: none;">
                            Edit Settings
                        </a>
                        <a href="/settings-history" class="btn-outline" style="text-align: center; text-decoration: none;">
                            View History
                        </a>
                        <button onclick="exportSettings()" class="btn-outline">
                            Export Settings
                        </button>
                        <button onclick="resetSettings()" class="btn-danger">
                            Reset to Default
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editKey">
                <div class="mb-3">
                    <label class="form-label">Setting Key</label>
                    <input type="text" id="editKeyDisplay" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Value</label>
                    <input type="text" id="editValue" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary" onclick="saveEdit()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editSetting(key, value) {
    document.getElementById('editKey').value = key;
    document.getElementById('editKeyDisplay').value = key;
    document.getElementById('editValue').value = value;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

function saveEdit() {
    const key = document.getElementById('editKey').value;
    const value = document.getElementById('editValue').value;
    window.location.href = `/update-setting?key=${key}&value=${value}`;
}

function exportSettings() {
    window.location.href = '/export-settings';
}

function resetSettings() {
    if(confirm('Are you sure you want to reset all settings to default?')) {
        window.location.href = '/reset-settings';
    }
}
</script>
</body>
</html>