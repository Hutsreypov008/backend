<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-secondary: #F3F4F6;
            --admin-accent: #10B981;
        }

        body {
            background: var(--admin-secondary);
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: var(--admin-accent);
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.1);
        }

        .btn-login {
            background: var(--admin-accent);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }

        .btn-login:hover {
            background: #059669;
        }
    </style>
</head>
<body>
    <main class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card login-card">
                    <div class="card-body p-4">
                        <h1 class="h4 mb-1 text-center fw-bold">Admin Login</h1>
                        <p class="text-muted text-center mb-4">Sign in to manage your store</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-login w-100 text-white">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
