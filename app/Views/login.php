<?php $errors = session()->getFlashdata("errors")?? " ";?>
<?php $errorMsg = session()->getFlashdata("msg")?? " ";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Sign in</h3>
            <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Login Error")) echo session()->getFlashData("Login Error"); ?></span>

              <form action="login/loginWithForm" method="post">
            <div class="form-outline mb-4">
              <label class="form-label" for="typeEmailX-2">Email</label>
              <input name = "email" value="<?=old('email')?>" type="email" id="typeEmailX-2" class="form-control form-control-lg" />
              <span class = "text-danger"><?php echo $errors['email']?? ""; ?></span>
            </div>

            <div class="form-outline mb-4">
              <label class="form-label" for="typePasswordX-2">Password</label>
              <input name = "password" type="password" id="typePasswordX-2" value="<?=old('password')?>" class="form-control form-control-lg" />
              <span class = "text-danger"><?php echo $errors['password']?? ""; ?></span>
            </div>

            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            <span class = "text-danger"><?php echo $errorMsg ?? ""; ?></span>
            </form>

            <hr class="my-4">

            <button class="btn btn-lg btn-block btn-primary my-2" style="background-color: #dd4b39;"
              type="submit"><i class="fab fa-google me-2"></i> <?php echo   session()->get("Google Login");?></button>
            <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;"
              type="submit"><i class="fab fa-facebook-f me-2"></i><?php echo "<a class='text-reset text-decoration-none' href='".  session()->get("Facebook Login")."' >Sign in with Facebook</a>";?>
				</button>
        <p>Not a god? <a href="http://localhost/loginapp/public/register">Register</a></p>
       

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>