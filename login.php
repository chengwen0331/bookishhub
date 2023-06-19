<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

include 'dbconnect.php';

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $pass = sha1($_POST["password"]);
    $otp = '1';
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE user_email = '$email' AND user_password = '$pass' AND user_otp='$otp'");
    $stmt->execute();
    $number_of_rows = $stmt->rowCount();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
    if ($number_of_rows  > 0) {
        foreach ($rows as $user)
        {
            $user_name = $user['user_name'];
            $user_phone = $user['user_phone'];
        }
        session_start();
        $_SESSION["sessionid"] = session_id();
        $_SESSION["user_email"] = $email;
        $_SESSION["user_name"] = $user_name;
        $_SESSION["user_phone"] = $user_phone;
        echo "<script>alert('Login Success');</script>";
        echo "<script> window.location.replace('index.php')</script>";
    }else{
         echo "<script>alert('Login Failed');</script>";
         echo "<script> window.location.replace('login.php')</script>";
    }
}
if (isset($_POST["reset"])) {
     $email = $_POST["email"];
     $resetotp = rand(10000,99999);
     sendMail($email,$resetotp);
}

function sendMail($email, $resetotp){
   $mail = new PHPMailer(true);
   $mail->SMTPDebug = 0;                                               //Disable verbose debug output
   $mail->isSMTP();                                                    //Send using SMTP
   $mail->Host       = 'smtp.gmail.com';                          //Set the SMTP server to send through
   $mail->SMTPAuth   = true;                                           //Enable SMTP authentication
   $mail->Username   = 'bookishhubb@gmail.com';  
   $mail->Password   = 'cpphpxzzxxjcsaxv';                                 //
   $mail->SMTPSecure = 'tls';         
   $mail->Port       = 587;

   $from = "bookishhubb@gmail.com";
   $to = $email;
   $subject = 'BookishHub - Reset password request';
   $message = "<h2>You have requested to reset your password</h2> <p>Please click on the following link to reset your password and using this $resetotp to verify. If your did not request for the reset. You can ignore this email<p>
   <p><button><a href ='http://localhost/bookishHub/verifyotp.php?email=$email&otp=$resetotp'>Verify Here</a></button>";
   
   $mail->setFrom($from,"BookishHub");
   $mail->addAddress($to);                                             //Add a recipient
   
   //Content
   $mail->isHTML(true);                                                //Set email format to HTML
   $mail->Subject = $subject;
   $mail->Body    = $message;
   if ($mail->send()) {
        echo '<script>alert("Email sent successfully. Check your email")</script>';
        echo "<script> window.location.replace('verifyotp.php')</script>";
   } else {
        echo '<script>alert("Error sending email: ". $mail->ErrorInfo)</script>'  ;
   }
}


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
            <a href="about.html" class="navb-link">About</a>
            <a href="faqs.html" class="navb-link">FAQs</a>
            <a href="contactus.html" class="navb-link">Contact</a>
        </nav>
    </header>

      <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">
         <div class="w3-row w3-card">
         <div class="w3-half w3-container" style="margin-top: 50px; margin-bottom: 50px; text-align: center;">
          <img class="w3-image w3-center w3-padding" style="width:100%; height:100%;object-fit:cover;" src="images/login.png">
        </div>
            <div class="w3-half w3-container" style="margin-top: 50px; margin-bottom:50px;">
               <h4 style="font-size: 40px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; margin-bottom:40px;">Login</h4>
               <form name="loginForm" class=""  action="login.php" method="post">
                  <p>
                     <label style="color: #004891;">
                     <b style="margin-top: 10px;">Email</b>
                     </label>
                     <input class="w3-input w3-border w3-round" name="email" type="email" id="idemail" required>
                  </p>
                  <p>
                     <label style="color: #004891;">
                     <b style="margin-top: 10px;">Password</b>
                     </label>
                     <div class="input-group">
                        <input class="w3-input w3-border w3-round" name="password" type="password" id="idpass" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('idpass', 'togglePassword')">
                        <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                        </button>
                    </div>
                  </p>
                  <p>
                     <input class="w3-check" style="margin-top: 10px;" type="checkbox" id="idremember" name="remember" onclick="rememberMe()">
                     <label>Remember Me</label>
                  </p>
                  <p>
                     <button class="button w3-btn w3-round w3-block" style="margin-top: 30px;" name="submit" value="login">Login</button>
                  </p>
               </form>

               <p style="margin-top: 30px; font-size:medium;">Dont have an account.  <a href="register.php" style="text-decoration:none;"> Create here.</a><br>
               Forgot your password?  <a href="" style="text-decoration:none;" onclick="document.getElementById('id01').style.display='block';return false;"> Click here.</a>
               </p>

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
         <p class="w3-center">&copy;2023 | BookishHub&reg;</p>
      </footer>

    
      <div id="id01" class="w3-modal">
      <div class="w3-modal-content" style="width:50%">
         <header class="w3-container" style="background-color:#004891; color:white;">
            <span onclick="document.getElementById('id01').style.display='none'" 
               class="w3-button w3-display-topright">&times;</span>
            <h4 style="margin-top: 15px; margin-bottom:15px">Email to reset password</h4>
         </header>
         <div class="w3-container w3-padding">
            <p>We will send you an email to reset your password.</p>
            <form action="login.php" method="post">
               <label><b style="margin-top: 15px;">Email</b></label>
               <input class="w3-input w3-border w3-round" style="margin-top: 5px;" name="email" type="email" id="idemail" required>
               <p>
                  <button class="button w3-btn w3-round" style="margin-top: 20px;" name="reset">Submit</button>
               </p>
            </form>
         </div>
      </div>

      
   </body>
</html>