@extends('adminlte::auth.login')

@section('title', 'Login - Safar Backend')

@section('auth_header', 'Sign in to start your session')

@section('auth_body')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="input-group mb-3">
            <input id="email" name="email" type="email" required 
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email" value="{{ old('email') }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input id="password" name="password" type="password" required 
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">
                    Sign In
                </button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    <p class="mb-1">
        <a href="{{ route('password.request') }}">
            I forgot my password
        </a>
    </p>
    <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">
            Register a new membership
        </a>
    </p>
@stop

@section('js')
<script>
// Demo credentials info
document.addEventListener('DOMContentLoaded', function() {
    const footer = document.querySelector('.login-box');
    if (footer) {
        const demoInfo = document.createElement('div');
        demoInfo.className = 'mt-3 p-3 bg-light rounded';
        demoInfo.innerHTML = `
            <h6 class="text-center mb-2"><strong>Demo Credentials</strong></h6>
            <div class="row text-center">
                <div class="col-md-4">
                    <small><strong>Admin:</strong><br>admin@safar.com / admin123</small>
                </div>
                <div class="col-md-4">
                    <small><strong>User:</strong><br>user@safar.com / user123</small>
                </div>
                <div class="col-md-4">
                    <small><strong>Moderator:</strong><br>moderator@safar.com / moderator123</small>
                </div>
            </div>
        `;
        footer.appendChild(demoInfo);
    }
});
</script>
@stop