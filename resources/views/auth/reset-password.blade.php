@extends('layouts.front')

@section('front')
<div class="content-wrapper">
  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <h1>Reset Password</h1>
      <p class="text-muted">Silakan masukkan email dan password baru Anda.</p>
    </div>
  </section>

  <!-- Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-body p-4">

              {{-- Error global --}}
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              {{-- Form Reset Password --}}
              <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="form-group">
                  <label for="email">Email</label>
                  <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                  >
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Password -->
                <div class="form-group mt-3">
                  <label for="password">Password Baru</label>
                  <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                  >
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group mt-3">
                  <label for="password_confirmation">Konfirmasi Password</label>
                  <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    required
                  >
                  @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end mt-4">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-lock mr-1"></i> Reset Password
                  </button>
                </div>
              </form>

            </div>
          </div>
          <div class="text-center text-muted mt-3" style="font-size:.9rem">
            Ingat password Anda? <a href="{{ route('login') }}">Kembali ke Login</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
