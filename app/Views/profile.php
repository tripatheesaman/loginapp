<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<section class="vh-100" style="background-color: #9de2ff;">
  <div class="container py-5 h-100">
  <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Error")) echo session()->getFlashData("Error"); ?></span>
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-md-9 col-lg-7 col-xl-5">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body p-4">
            <div class="d-flex text-black">
              <div class="flex-shrink-0">
                <img src="https://i1.sndcdn.com/avatars-000520142559-9n7qkh-t500x500.jpg"
                  alt="KOOL" class="img-fluid"
                  style="width: 180px; border-radius: 10px;">
              </div>
              <div class="flex-grow-1 ms-3">
                <h5 class="mb-1">Name: <?=session()->get("User Data")['full_name']?session()->get("User Data")['full_name']:"";  ?></h5>
                <p class="mb-2 pb-1" style="color: #2b2a2a;">The God</p>
                <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                  style="background-color: #efefef;">
                  <div>
                    <p class="small text-muted mb-1">Email: <?=session()->get("User Data")['email']?session()->get("User Data")['email']:"";  ?></p>
                  </div>
                </div>
                <div class="d-flex pt-1">
                  <!-- <button type="button" class="btn btn-outline-primary me-1 flex-grow-1"><a href="<?php base_url("public/logout");?>"><?php echo base_url("public/logout");?></a></button> -->
                  <a href="http://localhost/loginapp/public/logout"><button type="button" class="btn btn-outline-primary me-1 flex-grow-1">Logout</button></a>
                  <a href="http://localhost/loginapp/public/payment"> <button type="button" class="btn btn-primary flex-grow-1">Pay Me</button></a>
                  <!-- <form action="https://uat.esewa.com.np/epay/main" method="POST">
                  <input value="100" name="tAmt" type="hidden">
                  <input value="90" name="amt" type="hidden">
                  <input value="5" name="txAmt" type="hidden">
                  <input value="2" name="psc" type="hidden">
                  <input value="3" name="pdc" type="hidden">
                  <input value="EPAYTEST" name="scd" type="hidden">
                  <input value="ee2c3ca1-696b-4cc5-a6be-2" name="pid" type="hidden">
                  <input value="http://merchant.com.np/page/esewa_payment_success?q=su" type="hidden" name="su">
                  <input value="http://merchant.com.np/page/esewa_payment_failed?q=fu" type="hidden" name="fu">
                  <input value="Submit" type="submit">
                  </form> -->
                </div>
              </div>
            </div>
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
