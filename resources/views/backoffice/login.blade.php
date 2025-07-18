<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('office/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('office/assets/img/favicon.png') }}">
  <title>
    Greats - Login
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('office/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('office/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('office/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('office/assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
  </head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">

  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-new text-gradient">Welcome back</h3>
                  <p class="mb-0">Enter your username and password to sign in</p>
                </div>
                <div class="card-body">
                  <form role="form" action="{{ route('postLogin') }}" method="POST">
                    @csrf
                    @if (session('message'))
                        <div class="alert alert-danger text-light">
                            {{ session('message') }}
                        </div>
                    @endif
                    <label>Username</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" placeholder="Email" value="{{ old('email') ?? '' }}" name="email" required>
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Password" name="password" value="" required>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-new text-white w-100 mt-2 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{ asset('office/assets/img/background/bg-login.jpg') }}')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-5">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> Malino Hills.
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>