<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
        <meta name="author" content="themefisher.com">

        <title>Login</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

        <!-- bootstrap.min css -->
        <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
        <!-- Icon Font Css -->
        <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
        <!-- Slick Slider  CSS -->
        <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
        <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">

        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/register.css">
        <link rel="stylesheet" href="css/output.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src='https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js'></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/react@17/umd/react.development.js"></script>
        <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.js"></script>

  </head>

  <body class="bg-gray-100">
      <div class="hero-section">


        <form id="login-form" class="login-container" class="login-form" method="POST" action="/login">
            @csrf

              <h1 class="login-title">LOGIN</h1>
              <div>
                  <label class="login-label">Username:</label>

                  <input type="text"
                        name="username"
                        id="username"
                        placeholder="Enter your username"
                        required
                        class="login-input form-control @error('username') is-invalid @enderror">
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
              <div>
                  <label class="login-label">Password:</label>

                    <input type="password"
                        name="password"
                        id="password"
                        placeholder="Enter your password"
                        required
                        class="login-input form-control @error('password') is-invalid @enderror" />
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

              </div>
              <!-- Forgot Password link -->
            <p class="forgot-password-text text-right">
                <a href="/forgot-password" class="forgot-password-link">Forgot Password?</a>
            </p>


              <button type="submit" class="login-button mb-4">LOGIN</button>
            <p class="signup-text">
                  Don't have an account? <a href="/register" class="signup-link">Sign Up</a>
              </p>
          </form>
      </div>

      @if(session('status'))
      <script>
          Swal.fire({
              icon: 'error',
              title: 'Access Denied',
              text: '{{ session('status') }}',
          });
      </script>
  @endif

      <script src="js/Registration.js"></script>
      <script src="plugins/jquery/jquery.js"></script>
      <!-- Bootstrap 4.3.2 -->
      <script src="plugins/bootstrap/js/popper.js"></script>
      <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="plugins/counterup/jquery.easing.js"></script>
      <!-- Slick Slider -->
      <script src="plugins/slick-carousel/slick/slick.min.js"></script>
      <!-- Counterup -->
      <script src="plugins/counterup/jquery.waypoints.min.js"></script>

      <script src="plugins/shuffle/shuffle.min.js"></script>
      <script src="plugins/counterup/jquery.counterup.min.js"></script>

      <script src="js/script.js"></script>

  </body>
</html>






