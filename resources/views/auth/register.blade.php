<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register &mdash; OMDB</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>
                              {{-- Tombol Ganti Bahasa --}}
                  <div class="text-center mb-4">
                    <a href="{{ route('lang.switch', 'en') }}"
                      class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-secondary' }}">
                      <i class="fas fa-globe"></i> EN
                    </a>
                    <a href="{{ route('lang.switch', 'id') }}"
                      class="btn btn-sm {{ app()->getLocale() == 'id' ? 'btn-primary' : 'btn-outline-secondary' }}">
                      <i class="fas fa-globe"></i> ID
                    </a>
                  </div>

            <div class="card card-primary">
              <div class="card-header"><h4>{{ __('Register') }}</h4></div>
            
              <div class="card-body">

                <!-- {{-- Notifikasi Error (session) --}}
                @if (session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif -->

                <!-- {{-- Validasi Error --}}
                @if ($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong>Perbaiki kesalahan berikut:</strong>
                    <ul class="mb-0 mt-1">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif -->

                <form method="POST" action="{{ route('register.process') }}">
                  @csrf

                  <div class="form-group">
                    <label for="name">{{ __('Full Name') }}</label>
                    <input 
                      id="name" 
                      type="text" 
                      class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                      name="name" 
                      value="{{ old('name') }}"
                      autofocus
                    >
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                      id="email" 
                      type="email" 
                      class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                      name="email"
                      value="{{ old('email') }}"
                    >
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">{{ __('Password') }}</</label>
                      <input 
                        id="password" 
                        type="password" 
                        class="form-control pwstrength {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                        data-indicator="pwindicator" 
                        name="password"
                      >
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                      @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="password_confirmation" class="d-block">{{ __('Password Confirmation') }}</</label>
                      <input 
                        id="password_confirmation" 
                        type="password" 
                        class="form-control" 
                        name="password_confirmation"
                      >
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      {{ __('Register') }}</
                    </button>
                  </div>
                </form>

              </div>
            </div>

            <div class="mt-3 text-muted text-center">
              {{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login') }}</</a>
            </div>

            <div class="simple-footer">
              Copyright &copy; Stisla <span id="year"></span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraries -->
  <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
  <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/auth-register.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script>
    const year = document.getElementById('year');
    year.innerHTML = new Date().getFullYear();
  </script>
</body>
</html>