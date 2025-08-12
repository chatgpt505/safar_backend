@extends('adminlte::auth.register')

@section('title', 'Register - Safar Backend')

@section('auth_header', 'Register a new membership')

@section('auth_body')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="input-group mb-3">
            <input id="name" name="name" type="text" required 
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Full name" value="{{ old('name') }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input id="email" name="email" type="email" required 
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email" value="{{ old('email') }}">
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
            <input id="phone" name="phone" type="text" 
                   class="form-control @error('phone') is-invalid @enderror"
                   placeholder="Phone (optional)" value="{{ old('phone') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                </div>
            </div>
            @error('phone')
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

        <div class="input-group mb-3">
            <input id="password_confirmation" name="password_confirmation" type="password" required 
                   class="form-control"
                   placeholder="Retype password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                    <label for="agreeTerms">
                        I agree to the <a href="#">terms</a>
                    </label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">
                    Register
                </button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    <p class="mb-0">
        <a href="{{ route('login') }}" class="text-center">
            I already have a membership
        </a>
    </p>
@stop