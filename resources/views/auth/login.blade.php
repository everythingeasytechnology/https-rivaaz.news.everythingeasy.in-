<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rivaaz Admin Panel</title>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Compiled Assets -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    
    <style>
        body {
            background-color: var(--bs-body-bg);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
        
        .login-card {
            width: 420px;
            padding: 40px;
            border-radius: 16px;
            border: 1px solid var(--bs-border-color);
            background-color: var(--bs-body-bg);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -4px rgba(0,0,0,0.05);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-container i {
            font-size: 3rem;
            color: var(--bs-primary);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-container">
            <i class="fas fa-newspaper mb-2"></i>
            <h4 class="fw-extrabold mb-0">Rivaaz Chronicle</h4>
            <p class="text-muted small">Sign in to access control panel</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            
            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                <input type="email" name="email" id="email" class="form-control rounded-3 @error('email') is-invalid @enderror" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label small fw-bold text-uppercase">Password</label>
                <input type="password" name="password" id="password" class="form-control rounded-3 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-4 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label small text-muted">Remember my login</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2.5 fw-bold"><i class="fas fa-sign-in-alt me-2"></i>Sign In</button>
        </form>
    </div>

</body>
</html>
