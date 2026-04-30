<!DOCTYPE html>
<html>
<head>
    <title>User Settings</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f7, #f8fafc);
            height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            background: #4f46e5;
            color: white;
            font-size: 20px;
            font-weight: 600;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }

        .form-control, .form-select {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #4f46e5;
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #4338ca;
        }

        .form-check-label {
            margin-left: 5px;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="col-md-5">

        <div class="card shadow-lg">
            
            <div class="card-header">
                ⚙️ User Settings
            </div>

            <div class="card-body p-4">

                <form method="POST" action="/save-settings">
                    @csrf

                    <!-- Theme -->
                    <div class="mb-3">
                        <label class="form-label">Theme</label>
                        <select name="theme" class="form-select">
                            <option value="light">🌞 Light</option>
                            <option value="dark">🌙 Dark</option>
                        </select>
                    </div>

                    <!-- Language -->
                    <div class="mb-3">
                        <label class="form-label">Language</label>
                        <select name="language" class="form-select">
                            <option value="en">English</option>
                            <option value="hi">Hindi</option>
                            <option value="gu">Gujarati</option>
                        </select>
                    </div>

                    <!-- Notifications -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="notifications" class="form-check-input" id="notify">
                        <label class="form-check-label" for="notify">Enable Notifications</label>
                    </div>

                    <!-- Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            💾 Save Settings
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>