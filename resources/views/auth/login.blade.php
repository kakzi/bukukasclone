<x-guest-layout>

    <div id="auth-left">
        <a href="index.html"><img class="mb-5" width="50%" src="{{ asset('/images/logo/logo.png') }}" alt="Logo"></a>
        {{-- <div class="auth-logo">
        </div> --}}
        <p class="mb-3">LOGIN</p>
        <p class="mb-3">Log in with your data that you entered during registration.</p>

        @if (session('status'))
        <div class="mb-1 font-small text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mt-4 mb-4">
                <input class="form-control form-control-md" type="email" name="email" placeholder="Email"
                    value="{{ old('email') }}">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" class="form-control form-control-md" name="password" placeholder="Password"
                    placeholder="Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
            {{-- <div class="form-check form-check-lg d-flex align-items-end">
                <input class="form-check-input me-2" type="checkbox" name="remember" id="flexCheckDefault">
                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                    Keep me logged in
                </label>
            </div> --}}
            <button class="btn btn-primary btn-block btn-md shadow-md mt-2">Log in</button>
        </form>
        @if (Route::has('register'))
        <p class="text-gray-600 mt-3">Don't have an account? <a href="{{route('register')}}">Sign
                up</a>.</p>
        @endif


        @if (Route::has('password.request'))
        <p class="mt-1"><a  href="{{route('password.request')}}">Forgot password?</a>.</p>
        @endif
    </div>
</x-guest-layout>