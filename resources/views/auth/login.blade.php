@extends('layouts.no_nav')

@section('content')


    <div class="login-container">
        <div class="h-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="logo-images text-center mb-4">
                            <img src="/images/logo1.png"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4 mx-auto">
                        <div class="formCard">
                            <h2>Welcome Back</h2>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row mb-3">

                                    <div class="col-md-12">
                                        <input id="email" placeholder="Email Address" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-12">
                                        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-4 ">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                    </div>
                                    <div class="col-md-8 right">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="text-small">© 2022 Hydrolore. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection