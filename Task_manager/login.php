<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Login & Signup</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.css"> -->
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- css styles-->
  <link rel="stylesheet" type="text/css" href="asset/css/login.css">
</head>
<body>

<div class="container">
  <input type="radio" id="tab-login" name="tab" checked>
  <input type="radio" id="tab-signup" name="tab">

  <div class="tabs">
  <div class="slider"></div> <!-- Animated background -->
  <label for="tab-login">Login</label>
  <label for="tab-signup">Signup</label>
</div>


  <div class="forms" id="loginForm">
    <!-- Login Form -->
    <form action="siging_data.php" method="POST" class=" p-5 ml-auto">
      <div class="field"><input type="email" placeholder="Email Address" name='email' required></div>
      <div class="field"><input type="password" placeholder="Password"  name='password'required></div>
      <div class="field"><a href="#">Forgot password?</a></div>
      <div class="field"><button type="submit" class="btn" name="login_btn">Login</button></div>
     <article class="d-flex justify-content-center gap-3 my-3 col-5  m-auto" id="social_links">
  <a href="https://accounts.google.com/" class="btn btn-outline-grey bg-light text-danger rounded-circle" title="Login with Google">
    <i class="fab fa-google"></i>
  </a>
  <a href="https://facebook.com/" class="btn btn-outline-grey bg-light text-primary rounded-circle" title="Login with Facebook">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a href="https://github.com/" class="btn btn-outline-dark bg-light text-dark rounded-circle" title="Login with GitHub">
    <i class="fab fa-github"></i>
  </a>
  <a href="https://linkedin.com/" class="btn btn-outline-info bg-light text-info rounded-circle" title="Login with LinkedIn">
    <i class="fab fa-linkedin-in"></i>
  </a>
</article>

      <div class="extra">Not a member? <a onclick="document.getElementById('tab-signup').checked = true;">
        <ins><span style="color:blue;">Signup now</span></ins></a></div>
    </form>

    <!-- Signup Form -->
    <form action="siging_data.php" method="POST"  class="form signup-form">
      <div class="field"><input type="text" placeholder="Name" name='name' required></div>
      <div class="field"><input type="email" placeholder="Email Address" name='email'  required></div>
      <div class="field"><input type="password" placeholder="Password"  name='password' required></div>
      <div class="field"><input type="password" placeholder="Confirm Password" name='co_password'  required></div>
      <div class="field"><button type="submit" class="btn" name='signup_btn'>Signup</button></div>
      <div class="extra">Already have an account? <a onclick="document.getElementById('tab-login').checked = true;">
        <ins><span style="color:blue;">Login</span></ins></a></div>
    </form>
  </div>
</div>

</body>
</html>
