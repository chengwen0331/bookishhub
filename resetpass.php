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
        <style>
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
                font-size:20px;
            }
        </style>
      </head> 
      <body>
  <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">
    <div class="w3-row w3-card">
      <div class="w3-half w3-container" style="margin-top: 20px; margin-bottom:50px;display: flex; justify-content: center; align-items: center;">
        <img class="w3-image w3-padding" style="width:100%; height:100%;object-fit:cover; text-align: center;" src="images/reset.png">
      </div>

      <div class="w3-half w3-container" style="margin-top: 50px; margin-bottom:50px;">
        <h4 style="font-size: 40px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; margin-bottom:40px;">Reset Password</h4>
        <form name="registerPassword" class="" action="resetpass.php?email=<?php echo $email; ?>" method="post" id="resetForm">
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
                    <li><a href="booklist.php#">All</a></li>
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
    if (!empty($email)) {
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
    } else {
      echo "<script>alert('The email is empty')</script>";
      $password = $_POST["password"];
      $passwordb = $_POST["passwordb"];
      echo "<script>window.location.href = \"http://localhost/bookishHub/resetpass.php?email=$email\"</script>";
    }
  } else {
    echo "<script>alert('Please make sure the password is the same as the confirm password.')</script>";
    $password = $_POST["password"];
    $passwordb = $_POST["passwordb"];

    $_SESSION['password'] = $password;
    $_SESSION['passwordb'] = $passwordb;

    echo "<script>window.location.href = \"http://localhost/bookishHub/resetpass.php?email=$email\"</script>";
  }
}
?>