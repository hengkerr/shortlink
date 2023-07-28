<?php
  session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Registration</title>
</head>
<body style="background: rgb(171,78,202); background: linear-gradient(90deg, rgba(171,78,202,1) 12%, rgba(71,159,198,1) 46%, rgba(27,199,227,1) 100%);">

    <main class="m-3 d-block">
        <div class="container h-100 ">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 50px;">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Register</p>
                        <form class="mx-1 mx-md-4 mb-3" method="post" action="./CekDaftar.php">
                        <div class="d-flex flex-row align-items-center mb-4">
                          <div class="form-outline flex-fill mb-0">
                            <input type="text" name="username" id="username" class="form-control" />
                            <label class="form-label" for="username">Username</label>
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                            <div class="form-outline flex-fill mb-0">
                            <input type="password" id="password" class="form-control" name="password" />
                            <label class="form-label" for="password">Password</label>
                            </div>
                        </div>
      
                        <?php
                          if(!empty($_SESSION['error'])){
                            echo'<div class="error-reg">'; echo $_SESSION['error']; echo'</div>';
                            unset($_SESSION['error']);
                          }
                        ?>
                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                          <button type="submit" class="btn btn-primary btn-lg">Register</button>
                        </div>
      
                      </form>
      
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
</body>
</html>