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

            <h3 class="mb-5">Register</h3>
            <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Login Error")) echo session()->getFlashData("Login Error"); ?></span>

              <form action="register/registerConfirmation" method="post">
            <div class="form-outline mb-4">
              <label class="form-label" for="first_name">First Name</label>
              <input name = "first_name" value="<?php echo old('first_name')?>" type="text" id="text-2" class="form-control form-control-lg" />
              <span class = "text-danger"><?php echo $errors['first_name']?? ""; ?></span>
            </div>
            <div class="form-outline mb-4">
              <label class="form-label" for="last_name">Last Name</label>
              <input name = "last_name" value="<?php echo old('last_name')?>" type="text" id="text-2" class="form-control form-control-lg" />
              <span class = "text-danger"><?php echo $errors['last_name']?? ""; ?></span>
            </div>
   
            <div class="form-outline mb-4">
              <label class="form-label" for="typeEmailX-2">Email</label>
              <input name = "email" value="<?php echo old('email')?>" type="email" id="typeEmailX-2" class="form-control form-control-lg" />
              <span class = "text-danger"><?php echo $errors['email']?? ""; ?></span>
            </div>

            <div class="form-outline mb-4">
              <label class="form-label" for="typePasswordX-2">Password</label>
              <input name = "password" type="password" id="typePasswordX-2"value="<?=old('password')?>" class="form-control form-control-lg" />
              <span class = "text-danger"><?php echo $errors['password']?? ""; ?></span>
            </div>
            <div class="form-outline mb-4">
              <label class="form-label" for="typePasswordX-2">Confirm Password</label>
              <input name = "confirm_password" type="password" id="typePasswordX-2" value="<?=old('password')?>" class="form-control form-control-lg" />
              <span class = "text-danger"><?php echo $errors['confirm_password']?? ""; ?></span>
            </div>

            <button class="btn btn-primary btn-lg btn-block" type="submit">Register</button>
            <span class = "text-danger"><?php echo $errorMsg ?? ""; ?></span>
            </form>
       

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