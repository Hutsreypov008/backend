<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #6C63FF;
            --primary-dark: #5A52D5;
            --primary-soft: rgba(108, 99, 255, 0.08);
            --primary-glow: rgba(108, 99, 255, 0.2);
            --accent: #FF6B9D;
            --accent-soft: rgba(255, 107, 157, 0.1);
            --bg: #F8F9FE;
            --surface: #FFFFFF;
            --text: #1A1A2E;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --border: #E5E7EB;
            --border-focus: #6C63FF;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 20px rgba(108, 99, 255, 0.08);
            --shadow-lg: 0 20px 60px rgba(108, 99, 255, 0.15);
            --shadow-xl: 0 30px 80px rgba(108, 99, 255, 0.2);
            --radius: 16px;
            --radius-sm: 12px;
            --radius-full: 9999px;
            --error: #EF4444;
            --error-bg: #FEF2F2;
            --error-border: #FECACA;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--bg);
            color: var(--text);
            overflow: hidden;
        }

        /* ==================== LEFT PANEL ==================== */
        .panel-left {
            flex: 0 0 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            background:
                radial-gradient(ellipse at 20% 30%, #6C63FF 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, #FF6B9D 0%, transparent 50%),
                radial-gradient(ellipse at 40% 80%, #00BFA5 0%, transparent 50%),
                radial-gradient(ellipse at 70% 70%, #6C63FF 0%, transparent 40%),
                linear-gradient(135deg, #4A42CC 0%, #6C63FF 30%, #5A52D5 60%, #FF6B9D 100%);
            overflow: hidden;
            padding: 3rem;
        }

        /* Animated gradient overlay */
        .panel-left .gradient-overlay {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 30% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 30%, rgba(255,255,255,0.05) 0%, transparent 40%);
            animation: gradientShift 8s ease-in-out infinite alternate;
        }

        @keyframes gradientShift {
            0% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
            100% { opacity: 0.6; transform: scale(1); }
        }

        /* Grid pattern */
        .panel-left .grid-pattern {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
        }

        /* Floating shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.12;
            animation: shapeFloat 12s ease-in-out infinite;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
            background: radial-gradient(circle, rgba(255,255,255,0.2), transparent);
            animation-delay: 0s;
        }

        .shape-2 {
            width: 250px;
            height: 250px;
            bottom: -50px;
            left: -50px;
            background: radial-gradient(circle, rgba(255,255,255,0.15), transparent);
            animation-delay: -3s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 15%;
            background: radial-gradient(circle, rgba(255,255,255,0.2), transparent);
            animation-delay: -6s;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }

        .shape-4 {
            width: 180px;
            height: 180px;
            top: 15%;
            left: 10%;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent);
            animation-delay: -9s;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        }

        @keyframes shapeFloat {
            0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
            33% { transform: translateY(-30px) rotate(5deg) scale(1.05); }
            66% { transform: translateY(15px) rotate(-3deg) scale(0.95); }
        }

        /* Floating dots */
        .dots-group {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
        }

        .dots-group .dot {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            animation: dotPulse 4s ease-in-out infinite;
        }

        .dots-group .dot:nth-child(1) { top: 20%; left: 25%; animation-delay: 0s; }
        .dots-group .dot:nth-child(2) { top: 45%; left: 75%; animation-delay: -1s; }
        .dots-group .dot:nth-child(3) { top: 75%; left: 30%; animation-delay: -2s; }
        .dots-group .dot:nth-child(4) { top: 30%; left: 60%; animation-delay: -3s; }
        .dots-group .dot:nth-child(5) { top: 65%; left: 15%; animation-delay: -0.5s; }
        .dots-group .dot:nth-child(6) { top: 15%; left: 80%; animation-delay: -1.5s; }

        @keyframes dotPulse {
            0%, 100% { opacity: 0.15; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.5); }
        }

        /* Brand content */
        .brand-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: white;
            max-width: 440px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.05) rotate(-3deg);
            box-shadow: 0 12px 40px rgba(0,0,0,0.18);
        }

        .brand-content h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            letter-spacing: -1px;
            text-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .brand-content .tagline {
            font-size: 1rem;
            opacity: 0.8;
            line-height: 1.7;
            margin-bottom: 0;
            font-weight: 400;
        }

        /* Feature badges */
        .feature-badges {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2.5rem;
        }

        .feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 1rem;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-full);
            font-size: 0.78rem;
            font-weight: 500;
            color: rgba(255,255,255,0.85);
        }

        .feature-badge i {
            font-size: 0.75rem;
        }

        /* ==================== RIGHT PANEL ==================== */
        .panel-right {
            flex: 0 0 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
            padding: 2rem;
            position: relative;
        }

        /* Subtle top bar decoration */
        .panel-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent), #00BFA5);
        }

        .form-wrap {
            width: 100%;
            max-width: 400px;
            animation: formEnter 0.6s ease both;
        }

        @keyframes formEnter {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form header */
        .form-head {
            margin-bottom: 2.25rem;
        }

        .form-head .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-decoration: none;
            margin-bottom: 1.25rem;
            transition: color 0.2s ease;
        }

        .form-head .back-link:hover {
            color: var(--primary);
        }

        .form-head .greeting {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-head h2 {
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .form-head p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.5;
        }

        /* Error alert */
        .alert-custom {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            border-radius: var(--radius-sm);
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 0.75rem;
            animation: alertShake 0.5s ease;
        }

        @keyframes alertShake {
            0%, 100% { transform: translateX(0); }
            10%, 50%, 90% { transform: translateX(-4px); }
            30%, 70% { transform: translateX(4px); }
        }

        .alert-custom .alert-icon {
            font-size: 1.1rem;
            color: var(--error);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alert-custom .alert-body strong {
            display: block;
            font-size: 0.85rem;
            color: var(--error);
            margin-bottom: 0.2rem;
        }

        .alert-custom .alert-body div {
            font-size: 0.8rem;
            color: #B91C1C;
            opacity: 0.85;
        }

        /* Input groups */
        .field {
            margin-bottom: 1.25rem;
        }

        .field-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.4rem;
        }

        .field-label label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
        }

        .field-label .error-text {
            font-size: 0.75rem;
            color: var(--error);
            font-weight: 500;
            display: none;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap .icon-left {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 1.1rem;
            z-index: 2;
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--text);
            background: var(--bg);
            transition: all 0.25s ease;
            outline: none;
        }

        .input-wrap input::placeholder {
            color: var(--text-muted);
        }

        .input-wrap input:focus {
            border-color: var(--border-focus);
            background: var(--surface);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .input-wrap:focus-within .icon-left {
            color: var(--primary);
        }

        .input-wrap .toggle-pass {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 1.1rem;
            transition: color 0.2s ease;
            line-height: 1;
        }

        .input-wrap .toggle-pass:hover {
            color: var(--text);
        }

        /* Focus ring indicator */
        .input-wrap .focus-ring {
            position: absolute;
            inset: -2px;
            border-radius: 14px;
            pointer-events: none;
            transition: opacity 0.3s ease;
            opacity: 0;
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .input-wrap:focus-within .focus-ring {
            opacity: 1;
        }

        /* Options row */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
        }

        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-wrap input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            border-radius: 4px;
            cursor: pointer;
        }

        .checkbox-wrap span {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 0.95rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px var(--shadow-lg);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Shimmer effect */
        .btn-submit::after {
            content: '';
            position: absolute;
 inset: 0;
            background: linear-gradient(
                105deg,
                transparent 40%,
                rgba(255,255,255,0.15) 45%,
                rgba(255,255,255,0.2) 50%,
                rgba(255,255,255,0.15) 55%,
                transparent 60%
            );
            transform: translateX(-120%);
            transition: transform 0.6s ease;
        }

        .btn-submit:hover::after {
            transform: translateX(120%);
        }

        .btn-submit i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .btn-submit:hover i {
            transform: translateX(4px);
        }

        /* Spinner state */
        .btn-submit.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        .btn-submit .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2.5px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .btn-submit.loading .spinner {
            display: block;
        }

        .btn-submit.loading .btn-text,
        .btn-submit.loading .btn-arrow {
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Footer */
        .form-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .form-footer i {
            color: var(--primary);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: var(--text-muted);
            font-size: 0.78rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Demo credentials hint */
        .demo-hint {
            background: var(--primary-soft);
            border-radius: var(--radius-sm);
            padding: 0.85rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        .demo-hint strong {
            color: var(--primary);
            font-weight: 700;
        }

        .demo-hint code {
            font-size: 0.78rem;
            background: rgba(108, 99, 255, 0.08);
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            font-family: 'Plus Jakarta Sans', monospace;
            color: var(--text);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1024px) {
            .panel-left {
                flex: 0 0 45%;
            }
            .panel-right {
                flex: 0 0 55%;
                padding: 2rem;
            }
            .form-wrap {
                max-width: 380px;
            }
        }

        @media (max-width: 860px) {
            body {
                overflow: auto;
            }

            .panel-left {
                display: none;
            }

            .panel-right {
                flex: 0 0 100%;
                padding: 2rem 1.5rem;
            }

            .form-wrap {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    {{-- LEFT PANEL — Brand / Visual --}}
    <div class="panel-left">
        <div class="gradient-overlay"></div>
        <div class="grid-pattern"></div>

        {{-- Shapes --}}
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>

        {{-- Dots --}}
        <div class="dots-group">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>

        <div class="brand-content">
            <div class="brand-logo">
                <i class="bi bi-shop"></i>
            </div>
            <h1>ShopAdmin</h1>
            <p class="tagline">
                Everything you need to manage your store,<br>
                track orders, and grow your business.
            </p>
            <div class="feature-badges">
                <span class="feature-badge"><i class="bi bi-check-lg" style="color: #00BFA5;"></i> Inventory</span>
                <span class="feature-badge"><i class="bi bi-check-lg" style="color: #00BFA5;"></i> Orders</span>
                <span class="feature-badge"><i class="bi bi-check-lg" style="color: #00BFA5;"></i> Analytics</span>
                <span class="feature-badge"><i class="bi bi-check-lg" style="color: #00BFA5;"></i> Customers</span>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL — Form --}}
    <div class="panel-right">
        <div class="form-wrap">
            {{-- Header --}}
            <div class="form-head">
                <span class="greeting">Welcome Back</span>
                <h2>Sign in to your account</h2>
                <p>Enter your credentials to access the admin dashboard.</p>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert-custom">
                    <span class="alert-icon"><i class="bi bi-exclamation-circle-fill"></i></span>
                    <div class="alert-body">
                        <strong>Unable to sign in</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                @csrf

                <div class="field">
                    <div class="field-label">
                        <label for="email">Email address</label>
                    </div>
                    <div class="input-wrap">
                        <span class="icon-left"><i class="bi bi-envelope-fill"></i></span>
                        <div class="focus-ring"></div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            required
                            autofocus
                            autocomplete="email"
                        />
                    </div>
                </div>

                <div class="field">
                    <div class="field-label">
                        <label for="password">Password</label>
                    </div>
                    <div class="input-wrap">
                        <span class="icon-left"><i class="bi bi-lock-fill"></i></span>
                        <div class="focus-ring"></div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        />
                        <button type="button" class="toggle-pass" onclick="togglePassword()" tabindex="-1">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="options-row">
                    <label class="checkbox-wrap">
                        <input type="checkbox" name="remember" />
                        <span>Keep me signed in</span>
                    </label>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-submit" id="loginBtn">
                    <span class="spinner"></span>
                    <span class="btn-text">Sign In</span>
                    <i class="bi bi-arrow-right btn-arrow"></i>
                </button>
            </form>

            <div class="divider">Secure access</div>

            <div class="demo-hint">
                <div><strong>Demo Credentials</strong></div>
                <div>Email: <code>admin@example.com</code></div>
                <div>Password: <code>password</code></div>
            </div>

            <div class="form-footer">
                <i class="bi bi-shield-fill-check"></i> Secured with 256-bit encrypted connection
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.className = 'bi bi-eye';
            } else {
                pw.type = 'password';
                icon.className = 'bi bi-eye-slash';
            }
        }

        // Loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('loginBtn').classList.add('loading');
        });
    </script>
</body>
</html>
