<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'menu.php';

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    include_once("dbconnect.php");
    if (isset($_POST['tnc']) && $_POST['tnc'] == '1') {
      if($_POST['password']==$_POST['passwordb']){
        $email = $_POST["email"];
        $name =$_POST["name"];
        $phone =$_POST["phone"];
        $password = sha1($_POST["password"]);
        $otp = rand(10000,99999);
        echo $sqlregister = "INSERT INTO `tbl_users`(`user_email`, `user_password`, `user_otp`, `user_phone`, `user_name`) VALUES ('$email','$password','$otp','$phone','$name')";
        try {
            $conn->exec($sqlregister);
            sendMail($email,$otp);
            echo "<script>alert('Registration Success. Please check your email to verify the account.')</script>";
            echo "<script>window.location.replace('login.php')</script>";
        }catch (PDOException $e) {
            echo "<script>alert('Failed')</script>";
            echo "<script>window.location.replace('register.php')</script>";
        }
      }else{
        echo "<script>alert('Please make sure the password same with confirm password.')</script>";
        $email = $_POST["email"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $passwordb = $_POST["passwordb"];
      }
    }else{
      echo "<script>alert('Please accept the terms and conditions.')</script>";
      $email = $_POST["email"];
      $name = $_POST["name"];
      $phone = $_POST["phone"];
      $password = $_POST["password"];
      $passwordb = $_POST["passwordb"];
    }
}
function sendMail($email,$otp){
  $mail = new PHPMailer(true);
  $mail->SMTPDebug = 0;                                               //Disable verbose debug output
  $mail->isSMTP();                                                    //Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                          //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                           //Enable SMTP authentication
  $mail->Username   = 'bookishhubb@gmail.com';  
  $mail->Password   = 'cpphpxzzxxjcsaxv';                            //
  $mail->SMTPSecure = 'tls';         
  $mail->Port       = 587;
  $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
    $from = "bookishhubb@gmail.com";
    $to = $email;   
    $subject = 'BookishHub - Please verify your account';
    $message = "<h2>Welcome to BookishHub Website</h2> <p>Thank you for registering your account with us. To complete your registration please click the following.<p>
    <p><button><a href ='http://localhost/bookishhub/verifyaccount.php?email=$email&otp=$otp'>Verify Here</a></button>";
    
    $mail->setFrom($from,"BookishHub");
    $mail->addAddress($to);                                             //Add a recipient
    
    //Content
    $mail->isHTML(true);                                                //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->send();
}

?>
<!DOCTYPE html>
<html>
    <head>    
        <title>BookishHub</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/jpeg" href="images/logo1.jpeg">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="js/script.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
        <style>
            .footer_info {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                grid-gap: 20px;
                justify-items: center;
                align-items: flex-start;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                margin-top:20px;
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
                font-size:20px;
            }
            .terms {
              color: #0061C2;
              text-decoration: none;
            }

            .terms:hover {
              color: #004891;
              text-decoration: underline;
            }
        </style>
    </head> 
<body>
  <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">
      <div class="w3-row w3-card">
        <div class="w3-half w3-container" style="margin-top: 130px; margin-bottom:50px;display: flex; justify-content: center; align-items: center;">
          <img class="w3-image w3-padding" style="width:100%; height:100%;object-fit:cover; text-align: center;" src="images/register.jpg">
        </div>
        <div class="w3-half w3-container" style="margin-top: 50px; margin-bottom:50px;">
          <h4 style="font-size: 40px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; margin-bottom:40px;">Register New Account</h4>
          <form name="registerForm" class="" action="register.php" method="post">
            <p>
              <label style="color: #004891;">
                <b style="margin-top: 10px;">Name</b>
              </label>
              <input class="w3-input w3-border w3-round" name="name" type="name" id="idname" value="<?php echo isset($name) ? $name : ''; ?>" required>
            </p>
            <p>
              <label style="color: #004891;">
                <b style="margin-top: 10px;">Phone</b>
              </label>
              <input class="w3-input w3-border w3-round" name="phone" type="phone" id="idphone" value="<?php echo isset($phone) ? $phone : ''; ?>" required>
            </p>
            <p>
              <label style="color: #004891;">
                <b style="margin-top: 10px;">Email</b>
              </label>
              <input class="w3-input w3-border w3-round" name="email" type="email" id="idemail" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </p>
            <p>
              <label style="color: #004891;">
                <b style="margin-top: 10px;">Password</b>
              </label>
            <div class="input-group">
              <input class="w3-input w3-border w3-round" name="password" type="password" id="idpass" value="<?php echo isset($password) ? $password : ''; ?>" required>
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
              <input class="w3-input w3-border w3-round" name="passwordb" type="password" id="idpassb" value="<?php echo isset($passwordb) ? $passwordb : ''; ?>" required>
              <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('idpassb', 'togglePasswordb')">
                <i class="far fa-eye" id="togglePasswordb" style="cursor: pointer;"></i>
              </button>
            </div>
            </p>
            <p>
              <input class="w3-check" style="margin-top: 10px;" type="checkbox" id="idtnc" name="tnc" value="1" <?php echo isset($_POST['tnc']) && $_POST['tnc'] == '1' ? 'checked' : ''; ?>>
              <label>This is procted by <a href="terms_of_service.php" class="terms">Terms of Service</a> and <a href="privacy_policy.php" class="terms">Privacy Policy</a></label>
            </p>
            <p>
              <button class="button w3-btn w3-round w3-block" style="margin-top: 30px;" name="submit" value="register">Register</button>
            </p>
            <p style="margin-top: 30px; font-size:medium;">Already registered? <a href="login.php" class="terms"> Login here.</a><br>
            </p>
          </form>
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
                    <li><a href="newbooks.php">Latest Arrival</a></li>
                    <li><a href="bestseller.php">Best Seller</a></li>
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
  </body>
</html>