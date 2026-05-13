<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RBAC System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .auth-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .form-control { border-radius: 8px; padding: 0.65rem 1rem; }
        .btn { border-radius: 8px; padding: 0.65rem 1.5rem; }
        .auth-brand { color: #fff; font-size: 1.5rem; font-weight: 700; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <div class="auth-brand">
                    <i class="bi bi-shield-check text-primary"></i> RBAC System
                </div>
                <p class="text-white-50 small">Role-Based Product Management</p>
            </div>

            <div class="card auth-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-1">Welcome back</h5>
                    <p class="text-muted small mb-4">Sign in to your account</p>

                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium small">Email Address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium small">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Remember me</label>
                            </div>
                            @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none">
                                Forgot password?
                            </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Sign In
                        </button>
                    </form>
                </div>
                <div class="card-footer bg-transparent text-center py-3">
                    <small class="text-muted">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Register</a>
                    </small>
                </div>
            </div>

            <!-- Demo Credentials -->
            <div class="card auth-card mt-3">
                <div class="card-body p-3">
                    <p class="fw-semibold small mb-2 text-muted">Demo Credentials:</p>
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <div class="badge bg-danger mb-1">Admin</div>
                                <div class="small" style="font-size:0.7rem;">admin@rbac.com</div>
                                <div class="small text-muted" style="font-size:0.7rem;">Admin@12345</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <div class="badge bg-warning mb-1">Manager</div>
                                <div class="small" style="font-size:0.7rem;">manager@rbac.com</div>
                                <div class="small text-muted" style="font-size:0.7rem;">Manager@12345</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <div class="badge bg-success mb-1">Customer</div>
                                <div class="small" style="font-size:0.7rem;">customer@rbac.com</div>
                                <div class="small text-muted" style="font-size:0.7rem;">Customer@12345</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>