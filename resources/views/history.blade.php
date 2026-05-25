<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings History</title>
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
        
        .history-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .history-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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
        
        .card-header p {
            margin: 0.5rem 0 0 0;
            color: #6b7280;
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
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .badge-key {
            background: #e0e7ff;
            color: #4338ca;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .badge-old {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        
        .badge-new {
            background: #d1fae5;
            color: #065f46;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        
        .badge-deleted {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        
        .text-muted-small {
            color: #6b7280;
            font-size: 0.875rem;
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
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
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

<div class="history-container">
    <div class="history-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>Settings Change History</h4>
                    <p>User: {{ $user->name }} ({{ $user->email }})</p>
                </div>
                <a href="/dashboard" class="btn-back">Back to Dashboard</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Setting Key</th>
                        <th>Old Value</th>
                        <th>New Value</th>
                        <th>Changed At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge-key">{{ $record->key }}</span>
                        </td>
                        <td>
                            @if($record->old_value)
                                <span class="badge-old">{{ $record->old_value }}</span>
                            @else
                                <span class="text-muted-small">—</span>
                            @endif
                        </td>
                        <td>
                            @if($record->new_value)
                                <span class="badge-new">{{ $record->new_value }}</span>
                            @else
                                <span class="badge-deleted">Deleted</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted-small">
                                {{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y h:i A') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <p style="margin-bottom: 0;">No history records found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>