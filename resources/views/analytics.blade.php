<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Analytics</title>
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
        
        .analytics-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .analytics-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-header {
            background: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .card-header h4 {
            margin: 0;
            color: #374151;
            font-weight: 600;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 1.5rem;
        }
        
        .stat-box {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #e5e7eb;
            padding: 1rem;
            font-weight: 600;
            color: #374151;
        }
        
        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .badge-changes {
            background: #e0e7ff;
            color: #4338ca;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .btn-back {
            background: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-back:hover {
            background: #4338ca;
            color: white;
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

<div class="analytics-container">
    <div class="analytics-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>Settings Analytics</h4>
                    <p style="margin: 0.5rem 0 0 0; color: #6b7280;">User: {{ $user->name }}</p>
                </div>
                <a href="/dashboard" class="btn-back">Back to Dashboard</a>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-number">{{ $history->sum('changes') }}</div>
                <div class="stat-label">Total Changes</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $history->count() }}</div>
                <div class="stat-label">Settings Modified</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $recentChanges->count() }}</div>
                <div class="stat-label">Recent Changes</div>
            </div>
        </div>
    </div>
    
    <div class="analytics-card">
        <div class="card-header">
            <h4>Changes by Setting</h4>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Setting Key</th>
                        <th>Number of Changes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $item)
                    <tr>
                        <td>
                            <span class="badge-changes">{{ $item->key }}</span>
                        </td>
                        <td>
                            <strong>{{ $item->changes }}</strong> time(s)
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="analytics-card">
        <div class="card-header">
            <h4>Recent Changes (Last 10)</h4>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Setting</th>
                        <th>Old Value</th>
                        <th>New Value</th>
                        <th>Changed At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentChanges as $change)
                    <tr>
                        <td><strong>{{ $change->key }}</strong></td>
                        <td>{{ $change->old_value ?: 'N/A' }}</td>
                        <td>{{ $change->new_value ?: 'Deleted' }}</td>
                        <td>{{ \Carbon\Carbon::parse($change->created_at)->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>