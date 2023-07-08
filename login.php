<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'menu.php';

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
      foreach ($rows as $user) {
         $userid = $user['user_id'];
         $user_name = $user['user_name'];
         $user_phone = $user['user_phone'];
      }
      session_start();
      $_SESSION["sessionid"] = session_id();
      $_SESSION["user_id"] = $userid;
      $_SESSION["user_email"] = $email;
      $_SESSION["user_name"] = $user_name;
      $_SESSION["user_phone"] = $user_phone;
      echo "<script>alert('Login Success');</script>";
      echo "<script> window.location.replace('index.php')</script>";
   } else {
      echo "<script>alert('Login Failed');</script>";
      echo "<script> window.location.replace('login.php')</script>";
   }
}
if (isset($_POST["reset"])) {
   $email = $_POST["email"];
   $resetotp = rand(10000, 99999);
   sendMail($email, $resetotp);
}

function sendMail($email, $resetotp)
{
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

   $mail->setFrom($from, "BookishHub");
   $mail->addAddress($to);                                             //Add a recipient

   //Content
   $mail->isHTML(true);                                                //Set email format to HTML
   $mail->Subject = $subject;
   $mail->Body    = $message;
   if ($mail->send()) {
      echo '<script>alert("Email sent successfully. Check your email")</script>';
      echo "<script> window.location.replace('verifyotp.php')</script>";
   } else {
      echo '<script>alert("Error sending email: ". $mail->ErrorInfo)</script>';
   }
}


?>
<!DOCTYPE html>
<html>

<head>
   <title>BookishHub</title>
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

   <style>
      .terms {
         color: #0061C2;
         text-decoration: none;
      }

      .terms:hover {
         color: #004891;
         text-decoration: underline;
      }

      .footer_info {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
         grid-gap: 20px;
         justify-items: center;
         align-items: flex-start;
         padding: 20px;
         background-color: #fff;
         box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      .quicklinks ul,
      .contact_info {
         list-style: none;
         padding: 0;
      }

      .quicklinks h2,
      .contact_us h2 {
         position: relative;
         margin-bottom: 15px;
      }

      .quicklinks h2:after,
      .contact_us h2:after {
         content: "";
         position: absolute;
         left: 0;
         bottom: -5px;
         height: 4px;
         width: 50px;
         background-color: #cc2e2e;
      }

      .quicklinks ul li,
      .contact_info li {
         margin-bottom: 10px;
      }

      .quicklinks ul li a {
         text-decoration: none;
         color: #000;
      }

      .quicklinks ul li a:hover {
         text-decoration: underline;
         color: blue;
      }

      .contact_info li {
         display: flex;
         margin-bottom: 10px;
      }

      .contact_info span {
         margin-right: 8px;
         display: flex;
      }

      .contact_info p {
         margin: 0;
         display: flex;
         align-items: center;
      }

      .contact_info li a {
         text-decoration: none;
         color: #000;
      }

      .contact_info li a:hover {
         text-decoration: underline;
         color: blue;
      }

      .copy-right {
         background-color: #f2f2f2;
         padding: 20px;
         text-align: center;
         font-size: 20px;
      }
   </style>
</head>

<body>
   <script>
      window.onload = loadCookies;
   </script>
   <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">
      <div class="w3-row w3-card">
         <div class="w3-half w3-container" style="margin-top: 50px; margin-bottom: 50px; text-align: center;">
            <img class="w3-image w3-center w3-padding" style="width:100%; height:100%;object-fit:cover;" src="images/login.png">
         </div>
         <div class="w3-half w3-container" style="margin-top: 50px; margin-bottom:50px;">
            <h4 style="font-size: 40px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; margin-bottom:40px;">Login</h4>
            <form name="loginForm" class="" action="login.php" method="post">
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

            <p style="margin-top: 30px; font-size:medium;">Dont have an account. <a href="register.php" class="terms"> Create here.</a><br>
               Forgot your password? <a href="" class="terms" onclick="document.getElementById('id01').style.display='block';return false;"> Click here.</a>
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
   <br><br>

   <footer>
      <div class="footer_info">
         <div class="quicklinks">
            <h2>Quick Links</h2>
            <ul>
               <li><a href="about.php">About</a></li>
               <li><a href="faqs.php">FAQs</a></li>
               <li><a href="privacy_policy.php">Privacy Policy</a></li>
               <li><a href="terms_of_service.php">Terms of Service</a></li>
               <li><a href="contactus.php">Contact Us</a></li>
            </ul>
         </div>
         <div class="quicklinks">
            <h2>Shop</h2>
            <ul>
               <li><a href="booklist.php">All</a></li>
               <li><a href="#">New Arrival</a></li>
               <li><a href="#">Best Seller</a></li>
            </ul>
         </div>
         <div class="contact_us">
            <h2>Contact Us</h2>
            <ul class="contact_info">
               <li>
                  <span><ion-icon name="location-outline" aria-hidden="true"></ion-icon></span>
                  <span>8, Jalan 7/118b,<br> Desa Tun Razak,<br> 56000 Kuala Lumpur,<br> Wilayah Persekutuan Kuala Lumpur</span>
               </li>
               <li>
                  <span><ion-icon name="call-outline" aria-hidden="true"></ion-icon></span>
                  <p><a href="tel:+6019-8745632">+6019-8745632</a></P>
               </li>
               <li>
                  <span><i class="fa-regular fa-envelope" aria-hidden="true"></i></span>
                  <p><a href="mailto:bookishhubb@gmail.com">bookishhubb@gmail.com</a></P>
               </li>
            </ul>
         </div>
      </div>
      <div class="copy-right">
         <p>
            Copyright © 2023 | BookishHub®
         </p>
      </div>
   </footer>
   <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


   <div id="id01" class="w3-modal">
      <div class="w3-modal-content" style="width:50%">
         <header class="w3-container" style="background-color:#004891; color:white;">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
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