<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 900px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .left-side {
            flex: 1;
            background: linear-gradient(135deg, #66a6ff, #89f7fe);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            color: white;
            text-align: center;
        }
        .left-side img { width: 100px; margin-bottom: 20px; }
        .left-side h2 { font-size: 24px; }
        .right-side {
            flex: 1.5;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        form { width: 100%; }
        .input-group { margin-bottom: 20px; text-align:left; }
        .input-style {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f9fafb;
            font-size: 15px;
            transition: border 0.3s;
        }
        .input-style:focus { border-color: #66a6ff; background: #fff; outline: none; }
        .hint { font-size: 12px; color: #666; margin-top: 5px; }
        .btn {
            width: 100%;
            background-color: #66a6ff;
            color: #fff;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-top: 10px;
        }
        .btn:hover { background-color: #5588dd; transform: translateY(-2px); }
        footer { margin-top: 20px; text-align: center; }
        footer a { color: #66a6ff; font-size: 14px; text-decoration: none; }
        footer a:hover { text-decoration: underline; }

        /* Responsive */
        @media (max-width: 768px) {
            .card { flex-direction: column; }
            .left-side, .right-side { width: 100%; padding: 20px; text-align: center; }
            .right-side { padding: 30px 20px; }
            .btn { padding: 14px; }
        }
        @media (max-width: 480px) {
            .left-side img { width: 80px; }
            .left-side h2 { font-size: 20px; }
            .btn { font-size: 14px; }
            .input-style { font-size: 14px; padding: 12px; }
            footer a { font-size: 13px; }
        }
    </style>
</head>

<body>
<div class="card">
    <div class="left-side">
        <img src="{{ asset('images/tjulogo.png') }}" alt="Logo">
        <h2>Register Your Account</h2>
    </div>

    <div class="right-side">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="input-group">
                <x-text-input class="input-style" id="name" type="text" name="name"
                              :value="old('name')" required autofocus autocomplete="name"
                              placeholder="Name (max 25 chars)" maxlength="25" />
                <div class="hint">Nama maksimal 25 karakter.</div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="input-group">
                <x-text-input class="input-style" id="email" type="email" name="email"
                              :value="old('email')" required autocomplete="username"
                              placeholder="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="input-group">
                <x-text-input class="input-style" id="password" type="password" name="password"
                              required autocomplete="new-password"
                              placeholder="Password (8-12 chars, min 3 angka)"
                              minlength="8" maxlength="12"
                              pattern="(?=(?:.*\d){3,})\S{8,12}"
                              title="Password 8–12 karakter, tanpa spasi, dan minimal 3 angka"
                              oninput="this.value=this.value.replace(/\s/g,'')" />
                <div class="hint">Password harus 8–12 karakter, tanpa spasi, dan mengandung minimal 3 angka.</div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="input-group">
                <x-text-input class="input-style" id="password_confirmation" type="password"
                              name="password_confirmation" required autocomplete="new-password"
                              placeholder="Confirm Password" minlength="8" maxlength="12"
                              oninput="this.value=this.value.replace(/\s/g,'')" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="btn">
                {{ __('Register') }}
            </x-primary-button>
        </form>

        <footer>
            <a href="{{ route('login') }}">
                {{ __('Already registered? Login') }}
            </a>
        </footer>
    </div>
</div>
</body>
</html>
