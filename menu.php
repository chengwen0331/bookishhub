<?php
include_once("dbconnect.php");
session_start();

$useremail = "Guest";
$user_name = "Guest";
$user_phone = "-";

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
    $stmtQty = $conn->prepare("SELECT SUM(cart_qty) AS total_quantity FROM tbl_carts WHERE user_email = :useremail");
    $stmtQty->bindParam(':useremail', $useremail);
    $stmtQty->execute();
    $totalQuantity = $stmtQty->fetch(PDO::FETCH_ASSOC)['total_quantity'];

    // Set the $carttotal variable to the retrieved total quantity
    $carttotal = $totalQuantity ?? 0;
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
                            <a href="cart.php" class="icon-hover border rounded py-1 px-3 nav-link d-flex align-items-center">
                                <i class="fas fa-shopping-cart m-1 me-md-2"></i>
                                <p class="d-none d-md-block mb-0">My cart (<?php echo $carttotal?>)</p>
                            </a>
                            <?php if ($useremail == "Guest") { ?>
                                <a href="register.php" class="icon-hover me-1 border rounded py-1 px-3 nav-link d-flex align-items-center">
                                    <i class="fas fa-user-plus m-1 me-md-2"></i>
                                    <p class="d-none d-md-block mb-0">Sign up</p>
                                </a>
                                <a href="login.php" class="icon-hover me-1 border rounded py-1 px-3 nav-link d-flex align-items-center">
                                    <i class="fas fa-sign-in-alt m-1 me-md-2"></i>
                                    <p class="d-none d-md-block mb-0">Login</p>
                                </a>
                            <?php } else { ?>
                                <a href="#" class="icon-hover me-1 border rounded py-1 px-3 nav-link d-flex align-items-center">
                                    <i class="fas fa-user-circle m-1 me-md-2"></i>
                                    <p class="d-none d-md-block mb-0">Profile</p>
                                </a>
                                <a href="logout.php" class="icon-hover me-1 border rounded py-1 px-3 nav-link d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt m-1 me-md-2"></i>
                                    <p class="d-none d-md-block mb-0">Logout</p>
                                </a>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navb" style="font-size:20px; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">
            <a href="index.php" class="navb-link">Home</a>
            <a href="booklist.php" class="navb-link">Books</a>
            <a href="about.php" class="navb-link">About</a>
            <a href="faqs.php" class="navb-link">FAQs</a>
            <a href="contactus.php" class="navb-link">Contact</a>
        </nav>
    </header>

    </body>
</html>

                   