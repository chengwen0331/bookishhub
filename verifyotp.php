<?php
error_reporting(0);
include_once("dbconnect.php");
$email = $_GET['email'];
$resetotp = $_GET['otp'];
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
    <script type='text/javascript'>
        var email = "<?php echo $email; ?>";
        var otp = "<?php echo $resetotp; ?>";
        var expirationTime = 5 * 60 * 1000; // 5 minutes in milliseconds
        var currentTime = new Date().getTime();
        var entered = prompt('Please enter the OTP: ');

        if (entered === otp && currentTime - <?php echo time() * 1000; ?> <= expirationTime) {
            window.location.href = "http://localhost/bookishhub/resetpass.php?email=" + email;
        } else {
            alert('OTP incorrect or expired');
            window.location.replace('login.php');
        }
    </script>
</body>

</html>