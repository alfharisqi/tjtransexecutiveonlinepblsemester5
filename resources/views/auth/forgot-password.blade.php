@extends('layouts.front')

@section('front')
<div class="content-wrapper">
  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h1 class="mb-1">Lupa Password</h1>
          <small class="text-muted">Kami akan kirimkan tautan reset ke email Anda.</small>
        </div>
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Lupa Password</li>
        </ol>
      </div>
    </div>
  </section>

  <!-- Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow-sm rounded-lg">
            <div class="card-body p-4">

              {{-- Info --}}
              <div class="alert alert-info d-flex align-items-start">
                <i class="fas fa-info-circle mr-2 mt-1"></i>
                <div>
                  Masukkan alamat email yang terdaftar. Kami akan mengirim <strong>tautan reset password</strong>.
                  Periksa juga folder <em>Spam/Junk</em> jika belum menerima email.
                </div>
              </div>

              {{-- Status sukses kirim email --}}
              @if (session('status'))
                <div class="alert alert-success">
                  <i class="fas fa-check-circle mr-1"></i>
                  {{ session('status') }}
                </div>
              @endif

              {{-- Form --}}
              <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf

                {{-- Anti-bot honeypot (opsional, boleh hapus jika tidak dipakai) --}}
                <input type="text" name="hp_field" class="d-none" tabindex="-1" autocomplete="off">

                <div class="form-group">
                  <label for="email" class="font-weight-medium">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input
                      id="email"
                      type="email"
                      name="email"
                      value="{{ old('email') }}"
                      class="form-control @error('email') is-invalid @enderror"
                      placeholder="nama@contoh.com"
                      required
                      autofocus
                    >
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4">
                  <a href="{{ route('login') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                  </a>

                  <button type="submit" class="btn btn-primary" id="submitBtn">
                    <span class="btn-text">Kirim Link Reset Password</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                  </button>
                </div>

                {{-- Catatan keamanan --}}
                <p class="text-muted mt-3 mb-0" style="font-size:.9rem">
                  Dengan menekan tombol di atas, sistem akan mengirim email berisi tautan valid untuk mengatur ulang kata sandi Anda.
                </p>
              </form>

            </div>
          </div>

          {{-- Bantuan tambahan --}}
          <div class="text-center text-muted" style="font-size:.9rem">
            Tidak menerima email? <a href="{{ route('password.request') }}">Coba lagi</a> atau hubungi admin.
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

{{-- Minimal JS untuk state tombol (opsional) --}}
@push('scripts')
<script>
  const form = document.querySelector('form');
  const btn  = document.getElementById('submitBtn');
  if (form && btn) {
    form.addEventListener('submit', function() {
      btn.disabled = true;
      btn.querySelector('.btn-text').classList.add('d-none');
      btn.querySelector('.spinner-border').classList.remove('d-none');
    });
  }
</script>
@endpush
@endsection
