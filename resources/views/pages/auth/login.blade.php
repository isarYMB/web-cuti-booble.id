<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from radixtouch.com/templates/admin/aegis/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Jul 2021 09:56:03 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Booble.id - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
  <link rel="stylesheet" href="{{asset('bundles/bootstrap-social/bootstrap-social.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/components.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href="{{asset('https://i.ibb.co/q5S0Gsp/LOGO-KOTAK-1.png')}}"/>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              {{-- <div class="card-header">
                <h4>Selamat Datang</h4>
              </div> --}}
              
              <div class="card-body">
                <h4>Selamat Datang</h4>
                <div>Sistem Permohonan Cuti Pegawai</div>
                <div>Booble Mitra Kreatif</div>

              <br>
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                  @csrf
                  @if(session('errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Something it's wrong:
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Mohon Menginputkan Email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Mohon Menginputkan Password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Masuk
                    </button>
                  </div>
                  <div class="form-group text-center">
                            <label>
                                <a href="{{ route('forget.password.get') }}">Lupa Password?</a>
                            </label>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{asset('js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{asset('js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{asset('js/custom.js')}}"></script>
</body>


<!-- Mirrored from radixtouch.com/templates/admin/aegis/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Jul 2021 09:56:03 GMT -->
</html>