@extends('layouts.front')

@section('front')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-10">

          <!-- Card -->
          <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header border-0 text-white" style="background: linear-gradient(135deg,#4f46e5,#06b6d4);">
              <div class="d-flex align-items-center">
                <!-- Icon -->
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" class="mr-2">
                  <path d="M3 7l9 6 9-6" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  <rect x="3" y="5" width="18" height="14" rx="2" stroke="white" stroke-width="1.6"/>
                </svg>
                <h4 class="mb-0 font-weight-bold">Verifikasi Email</h4>
              </div>
            </div>

            <!-- Body -->
            <div class="card-body p-4">
              <p class="mb-3 text-muted">
                Terima kasih sudah mendaftar!
                Kami telah mengirim tautan verifikasi ke email Anda.
                Silakan cek kotak masuk (atau folder <em>Spam/Promotions</em>).
              </p>

              @auth
              <div class="d-flex align-items-center mb-3 p-2 rounded" style="background:#f8fafc;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="mr-2">
                  <path d="M12 12c2.761 0 5-2.239 5-5S14.761 2 12 2 7 4.239 7 7s2.239 5 5 5z" stroke="#64748b" stroke-width="1.5"/>
                  <path d="M3.46 20.53C4.74 17.76 8.09 16 12 16s7.26 1.76 8.54 4.53" stroke="#64748b" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span class="small text-secondary">
                  Dikirim ke: <strong>{{ auth()->user()->email }}</strong>
                </span>
              </div>
              @endauth

              @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success d-flex align-items-start" role="alert">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="mr-2 mt-1">
                    <path d="M20 6L9 17l-5-5" stroke="#166534" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <div>
                    Link verifikasi baru telah dikirim ke email Anda.
                  </div>
                </div>
              @endif

              @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                  {{ $errors->first() }}
                </div>
              @endif

              <!-- Actions -->
              <div class="d-flex flex-wrap align-items-center gap-2">
                <form method="POST" action="{{ route('verification.send') }}" class="d-inline mr-2" id="resend-form">
                  @csrf
                  <button type="submit" class="btn btn-primary" id="resend-btn">
                    <span class="btn-label">Kirim Ulang Email Verifikasi</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="resend-spinner"></span>
                  </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-outline-secondary">Log Out</button>
                </form>
              </div>

              <!-- Tips -->
              <hr class="my-4">
              <div class="small text-muted">
                <strong>Tips bila belum menerima email:</strong>
                <ul class="mb-0 pl-3">
                  <li>Periksa folder <em>Spam</em> / <em>Junk</em> / <em>Promotions</em>.</li>
                  <li>Pastikan alamat email sudah benar.</li>
                  <li>Tunggu 1–2 menit, lalu klik “Kirim Ulang” sekali lagi.</li>
                </ul>
              </div>
            </div>

          </div>
          <!-- /Card -->

        </div>
      </div>
    </div>
  </section>
</div>

{{-- Minimal UX script: disable button & show spinner to prevent double submit --}}
@push('scripts')
<script>
  (function () {
    var form = document.getElementById('resend-form');
    var btn = document.getElementById('resend-btn');
    var spinner = document.getElementById('resend-spinner');
    if (form && btn && spinner) {
      form.addEventListener('submit', function () {
        btn.setAttribute('disabled', 'disabled');
        spinner.classList.remove('d-none');
        // Optional: prevent double-click form resubmission visual flicker
        var label = btn.querySelector('.btn-label');
        if (label) label.textContent = 'Mengirim...';
      });
    }
  })();
</script>
@endpush
@endsection
