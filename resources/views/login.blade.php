<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPENA - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1d4ed8;
            --light-blue: #dbeafe;
            --gradient-start: #3b82f6;
            --gradient-end: #1e40af;
            --shadow-color: rgba(37, 99, 235, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            grid-column: 2;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px var(--shadow-color);
            padding: 32px;
            width: 380px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            box-shadow: 0 6px 16px var(--shadow-color);
        }

        .brand-logo .logo-icon i {
            color: white;
            font-size: 24px;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            color: #374151;
            font-weight: 600;
            font-size: 13px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-size: 13px;
        }

        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--primary-blue);
            background: rgba(37, 99, 235, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px var(--shadow-color);
            margin-top: 6px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px var(--shadow-color);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px;
            margin-bottom: 20px;
            background: #fef2f2;
            border-left: 3px solid #ef4444;
        }

        .alert ul {
            margin: 0;
            padding-left: 16px;
        }

        .alert li {
            color: #dc2626;
            font-size: 13px;
            margin-bottom: 2px;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            color: #9ca3af;
            font-size: 11px;
        }

        /* Remember me checkbox styles */
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            accent-color: var(--primary-blue);
            cursor: pointer;
        }

        .remember-me label {
            font-size: 13px;
            color: #4b5563;
            cursor: pointer;
            user-select: none;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            body {
                display: flex;
                justify-content: center;
                padding: 16px;
            }

            .login-container {
                width: 100%;
                max-width: 360px;
                padding: 28px 24px;
                border-radius: 16px;
            }

            .brand-title {
                font-size: 22px;
            }

            .form-control {
                padding: 14px 16px;
                font-size: 16px; /* Prevent zoom on iOS */
            }

            .btn-login {
                padding: 14px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                max-width: 320px;
                padding: 24px 20px;
            }

            .brand-logo .logo-icon {
                width: 48px;
                height: 48px;
            }

            .brand-logo .logo-icon i {
                font-size: 20px;
            }

            .brand-title {
                font-size: 20px;
            }

            .brand-subtitle {
                font-size: 12px;
            }
        }

        /* Loading Animation */
        .btn-login.loading {
            position: relative;
            color: transparent;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            top: 50%;
            left: 50%;
            margin-left: -9px;
            margin-top: -9px;
            border: 2px solid transparent;
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Focus visible for accessibility */
        .form-control:focus-visible,
        .btn-login:focus-visible,
        .password-toggle:focus-visible {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }

        /* Smooth entrance animation */
        .login-container {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand-logo">
            <div class="logo-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1 class="brand-title">SIPENA</h1>
            <p class="brand-subtitle">Sistem Informasi Penilaian</p>
        </div>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            
            <div class="form-group">
                <label for="login" class="form-label">Username / NIP / NIS</label>
                <div style="position: relative;">
                    <input 
                        type="text" 
                        name="login" 
                        id="login" 
                        class="form-control" 
                        placeholder="Username, NIP, atau NIS" 
                        required 
                        autofocus
                        autocomplete="username"
                        value="{{ old('login', Cookie::get('remember_username')) }}"
                    >
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control" 
                        placeholder="Masukkan password" 
                        required
                        autocomplete="current-password"
                    >
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                </div>
            </div>

            <div class="remember-me">
                <input 
                    type="checkbox" 
                    name="remember" 
                    id="remember" 
                    {{ old('remember') || Cookie::get('remember_username') ? 'checked' : '' }}
                >
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn-login" id="loginButton">
                <i class="fas fa-sign-in-alt" style="margin-right: 6px;"></i>
                Masuk ke SIPENA
            </button>
        </form>

        <div class="footer-text">
            © 2024 SIPENA. Kelola data dengan mudah dan efisien.
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const button = document.getElementById('loginButton');
            button.classList.add('loading');
            button.disabled = true;
        });

        // Input focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-1px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>