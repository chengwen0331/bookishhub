<?php 
session_start();
isset($_GET['email']) ? $email=$_GET['email'] : $email='';
?>

<!DOCTYPE html>
<html>
    <head>    
        <title>BookishHub</title>
        <link rel="shortcut icon" type="image/jpeg" href="images/logo1.jpeg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="js/script.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    </head> 
<body>
                    <header>
                        <div class="p-3 text-center bg-white border-bottom">
                            <div class="container">
                                <div class="row gy-3 align-items-center">
                                    <div class="col-lg-2 col-sm-4 col-4">
                                        <a href="index.php" class="float-start">
                                            <img src="images/logo.png" width="100%" />
                                        </a>
                                    </div>

                                    <div class="col-lg-4 col-sm-6 col-6" style="margin-left: 80px;">
                                        <div class="input-group">
                                            <input type="search" id="form1" class="form-control" placeholder="Search" />
                                            <label class="form-label visually-hidden" for="form1">Search</label>
                                            <button type="button" class="btn shadow-0" style="background-color:#3286AA; color:white;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="order-lg-last col-lg-5 col-sm-8 col-8">
                                        <div class="d-flex justify-content-end">
                                        <a href="#" class="icon-hover border rounded py-1 px-3 nav-link d-flex align-items-center btn-margin"> <i class="fas fa-shopping-cart m-1 me-md-2"></i><p class="d-none d-md-block mb-0">My cart</p> </a>
                                        <a href="register.php" class="icon-hover me-1 border rounded py-1 px-3 nav-link d-flex align-items-center btn-margin"> <i class="fas fa-user-plus m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Sign up</p> </a>    
                                        <a href="login.php" class="icon-hover me-1 border rounded py-1 px-3 nav-link d-flex align-items-center btn-margin"> <i class="fas fa-sign-in-alt m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Login</p> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <nav class="navb" style="font-size:20px; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">
                            <a href="index.php" class="navb-link">Home</a>
                            <a href="#" class="navb-link">Books</a>
                            <a href="#about.html" class="navb-link">About</a>
                            <a href="#faqs.html" class="navb-link">FAQs</a>
                            <a href="#contactus.html" class="navb-link">Contact</a>
                        </nav>
                    </header>

                    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">
                        <div class="w3-row w3-card">
                          <div class="w3-half w3-container" style="margin-top: 20px; margin-bottom:50px;display: flex; justify-content: center; align-items: center;"> 
                            <img class="w3-image w3-padding" style="width:100%; height:100%;object-fit:cover; text-align: center;" src="image/reset.png">
                          </div>

                          <div class="w3-half w3-container" style="margin-top: 50px; margin-bottom:50px;">
                                 <h4 style="font-size: 40px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; margin-bottom:40px;">Reset Password</h4>
                            <form name="registerPassword" class=""  action="resetpass.php?email=<?php echo $email; ?>" method="post" id="resetForm">
                              <p>
                                <label style="color: #004891;">
                                  <b style="margin-top: 10px;">Password</b>
                                </label>
                                <div class="input-group">
                                <input class="w3-input w3-border w3-round" name="password" type="password" id="idpass" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" required>
                                  <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('idpass', 'togglePassword')">
                                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                  </button>
                                </div>
                              </p>
                              <p>
                                <label style="color: #004891;">
                                  <b style="margin-top: 10px;">Confirm Password</b>
                                </label>
                                <div class="input-group">
                                <input class="w3-input w3-border w3-round" name="passwordb" type="password" id="idpassb" value="<?php echo isset($_SESSION['passwordb']) ? $_SESSION['passwordb'] : ''; ?>" required>
                                  <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('idpassb', 'togglePasswordb')">
                                    <i class="far fa-eye" id="togglePasswordb" style="cursor: pointer;"></i>
                                  </button>
                                </div>
                              </p>           
                              <p>
                              <button class="button w3-btn w3-round w3-block" style="margin-top: 30px;" name="reset" value="reset">Reset</button>
                            </form>
                            <script>
                              // Get the email parameter from the URL
                              var email = "<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>";

                              // Set the form action with the email parameter
                              document.getElementById("resetForm").action = "resetpass.php?email=<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>";
                            </script>
                          </div>
                        </div>
                      </div>
                  
                      <script>
                        function togglePasswordVisibility(inputId, eyeIconId) {
                          var input = document.getElementById(inputId);
                          var eyeIcon = document.getElementById(eyeIconId);
                  
                          if (input.type === 'password') {
                            input.type = 'text';
                            eyeIcon.classList.remove('fa-eye');
                            eyeIcon.classList.add('fa-eye-slash');
                          } else {
                            input.type = 'password';
                            eyeIcon.classList.remove('fa-eye-slash');
                            eyeIcon.classList.add('fa-eye');
                          }
                        }
                      </script>
                  
                      <footer class="w3-row-padding w3-padding-32" style="background-color: white;">
                          <hr></hr>
                          <p class="w3-center">&copy;2023 | BookishHub&reg;
                            <?php echo $email?>
                          </p>
                      </footer>    
    </body>
</html>

<?php
  include_once("dbconnect.php");

  if (isset($_GET['email'])) {
    $email = $_GET['email'];
  } else {
      $email = '';
  }

  if (isset($_POST['reset'])) {
    $password = $_POST['password'];
    $passwordb = $_POST['passwordb'];

    if ($password == $passwordb) {
      $haspassword = sha1($password);
      if (!empty($email)){
        $sqlupdate = "UPDATE `tbl_users` SET user_password = '$haspassword' WHERE user_email = '$email'";
        $stmt = $conn->prepare($sqlupdate);
        $stmt->execute();
        $number_of_rows = $stmt->rowCount();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
        if ($number_of_rows  > 0) {
          echo "<script>alert('Reset Success')</script>";
          echo "<script>window.location.replace('login.php')</script>";
        } else {
            echo "<script>alert('Failed to update password.')</script>";
        }
      }else {
        echo "<script>alert('The email is empty')</script>";
        $password = $_POST["password"];
        $passwordb = $_POST["passwordb"];
        echo "<script>window.location.href = \"http://localhost/bookishhub/resetpass.php?email=$email\"</script>";
       
      }
    } else {
      echo "<script>alert('Please make sure the password is the same as the confirm password.')</script>";
      $password = $_POST["password"];
      $passwordb = $_POST["passwordb"];

      $_SESSION['password'] = $password;
      $_SESSION['passwordb'] = $passwordb;

      echo "<script>window.location.href = \"http://localhost/bookishhub/resetpass.php?email=$email\"</script>";
      
    }
  }
?>
