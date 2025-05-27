<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="ACLC Tacloban Student Tuition Payment System Login">
  <title>Login | ACLC Tacloban Tuition System</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script type="text/javascript" src="{{ asset('javascript/main.js') }}"></script>
</head>
<body>

  <main class="login-container">
    <section class="brand-section" aria-label="ACLC Tacloban branding">
      <img class="brand-logo" src="{{ asset('images/aclctacloban.png') }}" alt="ACLC Tacloban Logo" width="150">
      <h1 class="system-name">Student Tuition Payment System</h1>
      <img class="feature-image" src="{{ asset('images/cash-register.png') }}" alt="Illustration of cash register" width="350">
    </section>

    <section class="login-section" aria-label="Login form">
      <form class="login-form" id="loginForm" action="/login" method="POST" novalidate>
        @csrf
        <div class="user-avatar">
          <img src="{{ asset('images/user.png') }}" alt="User profile icon" width="60" height="60">
        </div>

        <div class="form-floating mb-3">
          <input type="text" name="Username" value="{{ old('loginusername') }}" autocomplete="username" class="form-control" id="floatingInput" placeholder="username"  style="min-width: 350px;">
          <label for="floatingInput">Username</label>
          @error('Username')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-floating">
          <input type="password" name="Password" autocomplete="current-password" class="form-control" id="floatingPassword" placeholder="password"  style="min-width: 350px;">
          <label for="floatingPassword">Password</label>
          @error('Password')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>

        <div class="form-footer mt-3 text-center">
          <a href="#forgot-password" class="forgot-password">Forgot Password?</a>
        </div>
      </form>
    </section>
  </main>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"
  ></script>

</body>
</html>
