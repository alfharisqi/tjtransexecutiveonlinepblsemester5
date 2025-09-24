{{-- <x-guest-layout> --}}
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Logins</title>
    <link rel="stylesheet" href="{{ asset('plugins/css-components-main/logins/login-1/loginsyz.css') }}">
  </head>

  <body>
    <div class="background"></div>
    <div class="card">
        <img class="logo" src="{{ asset('images/tjulogo.png') }}" />
        <h2>REGISTER YOUR ACCOUNT</h2>      

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            {{-- <x-input-label for="name" :value="__('Name')" /> --}}
            <x-text-input class="input-style" id="name"  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div >
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input class="input-style" id="email"  type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div >
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}

            <x-text-input class="input-style" id="password" 
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div >
            {{-- <x-input-label for="password_confirmation" :value="__('Confirm Password')" /> --}}

            <x-text-input class="input-style" id="password_confirmation" 
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Confirm Password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="btn">
                {{ __('Register') }}
            </x-primary-button>

        </div>
    </form>
    <footer>
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>    
    </footer>
    </div>
  </body>
</html>

{{-- </x-guest-layout> --}}
