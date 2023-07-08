<?php
include 'dbconnect.php';

include 'menu.php';

// Check if the user is logged in
if (!isset($_SESSION["user_email"])) {
    echo "<script>alert('Please login or register')</script>";
    header("Location: login.php");
    exit();
}

// Get the user details from the session
$user_id = $_SESSION['user_id'];

$sqlquery = "SELECT * FROM tbl_users WHERE user_id = $user_id";
$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$row = $stmt->fetch();

if (isset($_POST['save'])) {
    // Get the updated form values
    $userid = $_POST['id'];
    $updatedName = $_POST["name"];
    $updatedEmail = $_POST["email"];
    $updatedPhone = $_POST["phone"];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // File was uploaded successfully
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        // Rest of the code for handling the uploaded file
    } else {
        // No file was uploaded or an error occurred during upload
        echo "<script>alert('Image upload failed!')</script>";
    }

    if (!empty($image)) {
        $targetDirectory = "images/profile/";
        $targetFile = $targetDirectory . $userid . ".jpg";
        move_uploaded_file($imageTmp, $targetFile);

        $stmt = $conn->prepare("UPDATE tbl_users SET user_name = :name, user_email = :email, user_phone = :phone WHERE user_id = :userid");
        $stmt->bindParam(':name', $updatedName);
        $stmt->bindParam(':email', $updatedEmail);
        $stmt->bindParam(':phone', $updatedPhone);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();

        echo "<script>alert('Update Success')</script>";
        echo "<script>window.location.replace('profile.php')</script>";
    } else {
        echo "<script>alert('Image upload failed!')</script>";
    }
}
if (isset($_POST['addaddress'])) {
    $uid = $_POST['id'];
    $fullname = $_POST['addname'];
    $addphone = $_POST['addphone'];
    $address1 = $_POST['add1'];
    $address2 = $_POST['add2'];
    $address3 = $_POST['add3'];
    $city = $_POST['city'];
    $code = $_POST['postalcode'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $labelas = $_POST['label'];

    $sqladd = "INSERT INTO `tbl_address`(`user_id`, `address1`, `address2`, `address3`, `city`, `state`, `country`, `postalcode`, `label`, `address_name`, `address_phone`) VALUES ('$uid','$address1','$address2','$address3','$city','$state','$country','$code','$labelas','$fullname','$addphone')";
    $result = $conn->exec($sqladd);
    if ($result !== false) {
        echo "<script>alert('Insertion address successful!')</script>";
    } else {
        echo "<script>alert('Insertion address failed!')</script>";
    }
}

if (isset($_POST['addcard'])) {
    $uid = $_POST['id'];
    $bank = $_POST['bank'];
    $cardno = $_POST['cardno'];
    $expires = $_POST['expires'];
    $ccv = $_POST['ccv'];
    $cardname = $_POST['cardname'];

    $sqladdcard = "INSERT INTO `tbl_card`(`card_no`, `card_expires`, `cvv`, `card_name`, `user_id`, `card_bank`) VALUES ('$cardno','$expires','$ccv','$cardname','$uid','$bank')";
    $result = $conn->exec($sqladdcard);
    if ($result !== false) {
        echo "<script>alert('Insertion debit / credit card successful!')</script>";
    } else {
        echo "<script>alert('Insertion debit / credit card failed!')</script>";
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
        .content {
            min-height: 65vh;
        }

        label {
            font-weight: bold;
        }

        .element {
            text-decoration: none;
            font-size: larger;
            color: #1B6281;
        }

        .element:hover {
            color: #5396B3;
        }

        .edit-button,
        .delete-button {
            text-decoration: none;
        }

        .edit-button:hover,
        .delete-button:hover {
            text-decoration: underline;
        }

        .bdesign {
            margin-bottom: 15px;
        }

        .labelas {
            border: 1px solid black;
            border-radius: 8px;
            border-color: #004891;
            padding: 8px;
            padding-left: 15px;
            padding-right: 15px;
            font-size: medium;
            text-align: left;
            margin-bottom: 0px ! important;
        }

        .card-details {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .reduced-margin {
            margin-bottom: 0px ! important;
        }

        .delete-entry-form {
            display: inline-block;
        }

        .delete-entry-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .delete-entry-modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 500px;
            text-align: center;
        }

        .delete-entry-modal-content h2 {
            margin-top: 20px;
        }

        .btnDelete {
            width: 80px;
            height: 40px;
            margin-top: 10px;
            margin-right: 10px;
            background-color: #E62236;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: white;
            margin-bottom: 20px;
        }

        .btnDelete:hover {
            background-color: #DB091E;
        }

        .btnCancel {
            width: 80px;
            height: 40px;
            margin-top: 10px;
            margin-left: 50;
            background-color: #3286AA;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: white;
            margin-bottom: 20px;
        }

        .btnCancel:hover {
            background-color: #2c7291;
        }

        .reduce {
            margin-left: -60px;
        }

        .status-container {
            display: flex;
            justify-content: flex-end;
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
        }

        .status {
            padding: 5px 10px;
            font-size: 22px;
        }
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
    </style>
    <script>
        $(document).ready(function() {
            // Hide the "My Orders" section by default
            $(".orders-section").show();

            // When the "Edit Profile" button is clicked
            $("#edit-profile-button").click(function() {
                // Hide the "My Orders" section
                $(".orders-section").hide();
                $(".address-section").hide();
                $(".cards-section").hide();

                // Show the "Edit Profile" section
                $(".edit-profile-section").show();
            });
            $("#address").click(function() {
                // Hide the "My Orders" section
                $(".orders-section").hide();
                $(".edit-profile-section").hide();
                $(".cards-section").hide();

                // Show the "Edit Profile" section
                $(".address-section").show();
            });
            $("#card").click(function() {
                // Hide the "My Orders" section
                $(".orders-section").hide();
                $(".edit-profile-section").hide();
                $(".address-section").hide();

                // Show the "Edit Profile" section
                $(".cards-section").show();
            });
            $("#orders").click(function() {
                // Hide the "My Orders" section
                $(".cards-section").hide();
                $(".edit-profile-section").hide();
                $(".address-section").hide();

                // Show the "Edit Profile" section
                $(".orders-section").show();
            });
        });
    </script>
</head>

<body>
    <div class="container mt-5 content">
        <div class="row">
            <div class="col-md-3">
                <!-- Sidebar -->
                <div class="w3-card w3-round" style="background-color: #E6E6E6;">
                    <div class="w3-container">
                        <h4 class="w3-center" style="font-weight: 600; margin-top:20px;">My Account</h4>
                        <hr>
                        <img src="<?php echo file_exists('images/profile/' . $user_id . '.jpg') ? 'images/profile/' . $user_id . '.jpg' : 'images/userimg.png'; ?>" alt="Profile Picture" class="w3-circle w3-margin-top" style="width: 120px;px; height: 120px; margin-left: 10px;">
                        <p style="font-size: large; margin-top: 20px; margin-left: 10px;"><strong><?php echo $row['user_name']; ?></strong></p>
                        <p style="margin-left: 10px; font-size: medium;"><i class="fa fa-envelope fa-fw w3-margin-right"></i><?php echo $row['user_email']; ?></p>
                        <p style="margin-left: 10px; font-size: medium; margin-bottom: 20px;"><i class="fa fa-phone fa-fw w3-margin-right"></i><?php echo $row['user_phone']; ?></p>
                        <a href="#" id="edit-profile-button" class="button w3-block" style="text-align: center; margin-bottom: 20px;">Edit Profile</a>
                        <div style="margin-bottom: 20px;">
                            <a href="#" id="address" class="element" style="margin-bottom: 30px;"><i class="fa fa-map-marker-alt" style="margin-right: 20px;"></i> My Addresses</a><br>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <a href="#" id="card" class="element" style="margin-bottom: 30px;"><i class="fa fa-credit-card" style="margin-right: 15px;"></i> My Cards</a>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <a href="#" id="orders" class="element" style="margin-bottom: 30px;"><i class="fas fa-shopping-bag" style="margin-right: 15px;"></i> My Orders</a>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-9">
                <!-- Content -->
                <div class="w3-card w3-round">
                    <div class="w3-container">
                        <!--My Orders-->
                        <?php
                        $email = $row['user_email'];
                        $sqlorder = "SELECT o.*, b.* FROM tbl_orders o JOIN tbl_books b ON o.order_bookid = b.book_id WHERE o.order_custid = :email ORDER BY o.order_date DESC";
                        $stmt = $conn->prepare($sqlorder);
                        $stmt->bindValue(':email', $email);
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                        ?>
                        <div class="orders-section">
                            <h4 class="w3-center" style="font-weight: 600; margin-top:20px;">My Orders</h4>
                            <hr>
                            <?php if (empty($rows)) echo "<p style='font-size: large;'>No order found.</p>";
                            else {
                                foreach ($rows as $order) { ?>
                                    <?php ?><div class="card mt-3" style="margin-bottom: 30px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <!-- Book Image -->
                                                    <img src="images/books/<?php echo $order['book_id']; ?>.jpg" alt="Book Image" class="img-fluid" style="width: 60%; margin-bottom: 10px;">
                                                </div>
                                                <div class="col-md-6" style="text-align: left;">
                                                    <!-- Order Details -->
                                                    <h3 class="card-title reduce" style="margin-top: 30px;"><b><?php echo $order['book_title']; ?></b></h3>
                                                    <p class="card-text reduce" style="font-size: large;">Price: RM <?php echo $order['book_price']; ?></p>
                                                    <p class="card-text reduce" style="font-size: large; margin-top: -10px;">Quantity: <?php echo $order['order_qty']; ?></p>
                                                    <p class="card-text reduce" style="font-size: large; margin-top: -10px; margin-bottom: 30px;">Order ID: <?php echo $order['order_receiptid']; ?></p>
                                                </div>
                                                <div class="status-container">
                                                    <span style="text-align: start;"></span>
                                                    <span class="status"><?php echo $order['order_status']; ?></span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="order-total">
                                                <p class="card-text" style="font-size: 20px;"><b>Order Total: RM <?php echo $order['order_paid']; ?></b></p>
                                            </div>
                                        </div>
                                    </div><?php }
                                    } ?>
                        </div>
                <!--Edit Profile-->
                <div class="edit-profile-section" style="display: none;">
                    <h4 class="w3-center" style="font-weight: 600; margin-top:20px;">Edit Profile</h4>
                    <hr>
                    <form name="editprofile" action="profile.php" method="post" id="editprofile" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['user_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['user_email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['user_phone']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">User Image</label>
                            <img class="w3-image w3-round w3-margin" src="<?php echo file_exists('images/profile/' . $user_id . '.jpg') ? 'images/profile/' . $user_id . '.jpg' : 'images/userimg.png'; ?>" style="height:30%;width:30%;max-width:330px"><br>
                            <input type="file" onchange="previewFile()" name="image" id="image">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="button save-button" style="margin-bottom: 20px;" name="save" value="save">Save <i class="fas fa-save"></i></button>
                        </div>
                    </form>
                </div>
                <!-- My Addresses -->
                <?php
                $sqladdress = "SELECT * FROM tbl_address WHERE user_id = $user_id";
                $stmt = $conn->prepare($sqladdress);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                ?>
                <div class="address-section" style="display: none; margin-top: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="w3-center" style="font-weight: 600; margin-top: 15px;">My Addresses</h4>
                        <a href="#" class="button" onclick="document.getElementById('addaddress').style.display='block';return false;"><i class="fas fa-plus"></i> Add New Address</a>
                    </div>
                    <hr>
                    <?php if (empty($rows)) echo "<p style='font-size: large;'>No addresses. Please add a new one.</p>";
                    else { ?>
                        <div class="row">
                            <?php foreach ($rows as $row) { ?>
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-body reduced-margin">
                                            <h5 class="card-title" style="font-size: x-large; font-weight: bold; margin-top: 10px;"><?php echo $row['address_name']; ?></h5>
                                            <p class="card-text"><?php echo $row['address1']; ?></p>
                                            <p class="card-text"><?php echo $row['address2']; ?></p>
                                            <p class="card-text"><?php echo $row['address3']; ?></p>
                                            <p class="card-text"><b><?php echo $row['postalcode'] . " " . $row['city'] . ", " . $row['state'] . ", " . $row['country']; ?></b></p>
                                            <div class="d-flex justify-content-end reduced-margin" style="margin-bottom: 0px !important;">
                                                <p class="labelas" style="margin-right: auto;" style="margin-bottom: 0px !important;"><?php echo $row['label']; ?></p>
                                                <a href="#" class="btn btn-link edit-button" onclick="openEditPopup('<?php echo $row['address_id']; ?>', '<?php echo $row['user_id']; ?>')"><b>Edit</b></a>

                                                <form class="delete-entry-form" method="POST" action="deleteprofile.php?addressid=<?php echo $row['address_id']; ?>">
                                                    <button type="button" class="btn btn-link text-danger delete-button" value="deleteAddress" onclick="openDeleteModal(<?php echo $row['address_id']; ?>, <?php echo $row['user_id']; ?>)">
                                                        <b>Delete</b>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- My Cards -->
                <?php
                $sqlcard = "SELECT * FROM tbl_card WHERE user_id = $user_id";
                $stmt = $conn->prepare($sqlcard);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                ?>
                <div class="cards-section" style="display: none; margin-top: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="w3-center" style="font-weight: 600; margin-top: 15px;">My Debit / Credit Cards</h4>
                        <a href="#" class="button" onclick="document.getElementById('addcard').style.display='block';return false;"><i class="fas fa-plus"></i> Add New Card</a>
                    </div>
                    <hr>
                    <?php if (empty($rows)) echo "<p style='font-size: large;'>No debit / credit cards. Please add a new one.</p>";
                    else { ?>
                        <div class="row">
                            <?php foreach ($rows as $row) { ?>
                                <div class="col-md-6">
                                    <div class="card mb-3" style="background-color: #303030;">
                                        <div class="card-body">
                                            <h5 class="card-title" style="font-size: x-large; font-weight: bold; margin-top: 10px; color: white; text-align: end;"><?php echo $row['card_bank']; ?></h5>
                                            <div style="text-align: left; margin-right: 10px; margin-bottom: 15px;">
                                                <img src="images/chip.png" style="width: 10%; height: 10%;" alt="Card Chip" />
                                            </div>
                                            <div class="d-flex justify-content-between" style="margin-bottom: 0 !important;">
                                                <div>
                                                    <h6 style="color: white; margin: 0;">Card Number</h6>
                                                    <div class="margin mb-4">
                                                        <p class="card-text" style="font-size: 20px; color: white; text-align: start;"><?php echo $row['card_no']; ?></p>
                                                    </div>
                                                </div>
                                                <div style="text-align: end;">
                                                    <div>
                                                        <h6 style="color: white; margin-right: 30px;">Valid Thru</h6>
                                                        <p class="card-text" style="font-size: 18px; color: white; margin: 3px 55px;"><?php echo $row['card_expires']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 0; margin-top: 5px;">
                                                <p class="card-text" style="font-size: 20px; color: white; margin: 0; margin-top: -15px;"><?php echo $row['card_name']; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <a href="#" class="btn btn-link edit-button" onclick="openEditCard('<?php echo $row['card_id']; ?>', '<?php echo $row['user_id']; ?>')"><b>Edit</b></a>
                                                <form class="delete-entry-form" method="POST" action="deleteprofile.php?cardid=<?php echo $row['card_id']; ?>">
                                                    <button type="button" class="btn btn-link text-danger delete-button" value="deleteCard" onclick="openDeleteCard(<?php echo $row['card_id']; ?>, <?php echo $row['user_id']; ?>)">
                                                        <b>Delete</b>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.querySelector('.w3-image');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                // convert image file to base64 string
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            } else {
                // Set default image if no file is selected
                preview.src = 'images/userimg.png';
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

    <!--Add New Address-->
    <div id="addaddress" class="w3-modal">
        <div class="w3-modal-content" style="width:50%">
            <header class="w3-container" style="background-color:#004891; color:white;">
                <span onclick="document.getElementById('addaddress').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h4 style="margin-top: 15px; margin-bottom:15px">Add New Address</h4>
            </header>
            <div class="w3-container w3-padding">
                <form action="profile.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
                        <div class="col-md-6">
                            <label><b>Full Name</b></label>
                            <input class="w3-input w3-border w3-round" style="margin-top: 10px;" name="addname" type="text" id="addname" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>Phone Number</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="addphone" type="number" id="addphone" required>
                        </div>
                    </div>

                    <label><b>Address 1</b></label>
                    <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="add1" type="text" id="add1" required>
                    <label><b>Address 2</b></label>
                    <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="add2" type="text" id="add2" required>
                    <label><b>Address 3</b></label>
                    <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="add3" type="text" id="add3" required>

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>City</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="city" type="text" id="city" pattern="[^\d]*" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>Postal Code</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="postalcode" type="text" id="postalcode" pattern="\d{1,5}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>State</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="state" type="text" id="state" pattern="[^\d]*" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>Country</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="country" type="text" id="country" pattern="[^\d]*" required>
                        </div>
                    </div>
                    <script>
                        const postalCodeInput = document.getElementById('postalcode');
                        postalCodeInput.addEventListener('input', enforcePostalCodeLength);

                        function enforcePostalCodeLength() {
                            const input = postalCodeInput.value;
                            postalCodeInput.value = input.slice(0, 5);
                        }
                    </script>

                    <p style="margin-top: 10px;"><b>Label As</b></p>
                    <div class="form-check form-check-inline">

                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="label" id="label" value="Home" checked>
                            Home
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="label" id="label" value="Work">
                            Work
                        </label>
                    </div>

                    <p class="d-flex justify-content-center">
                        <button class="button w3-btn w3-round bdesign" style="margin-top: 20px; padding-left:20px; padding-right:20px;" name="addaddress" value="addaddress">Add Address </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <!--Edit New Address-->
    <script>
        function openEditPopup(addressId, userId) {
            $.ajax({
                url: 'editprofile.php',
                method: 'POST',
                data: {
                    addressId: addressId,
                    userId: userId
                },
                dataType: 'json',
                success: function(data) {
                    // Populate the Edit popup box with the retrieved address details
                    $('#addid1').val(data.address_id);
                    $('#id1').val(data.user_id);
                    $('#addname1').val(data.address_name);
                    $('#addphone1').val(data.address_phone);
                    $('#add1i').val(data.address1);
                    $('#add2i').val(data.address2);
                    $('#add3i').val(data.address3);
                    $('#city1').val(data.city);
                    $('#postalcode1').val(data.postalcode);
                    $('#state1').val(data.state);
                    $('#country1').val(data.country);

                    if (data.label === 'Home') {
                        $('#homeLabel').prop('checked', true);
                    } else if (data.label === 'Work') {
                        $('#workLabel').prop('checked', true);
                    }

                    // Display the Edit popup box
                    $('#editaddress').css('display', 'block');
                },
                error: function(error) {
                    console.error('Error:', error);
                    alert("error");
                    // Handle error case if necessary
                }
            });
        }
    </script>
    <div id="editaddress" class="w3-modal">
        <div class="w3-modal-content" style="width:50%">
            <header class="w3-container" style="background-color:#004891; color:white;">
                <span onclick="document.getElementById('editaddress').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h4 style="margin-top: 15px; margin-bottom:15px">Edit Address</h4>
            </header>
            <div class="w3-container w3-padding">
                <form action="editprofile.php" method="post">
                    <input type="hidden" name="addid1" id="addid1">
                    <input type="hidden" name="id1" id="id1">
                    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
                        <div class="col-md-6">
                            <label><b>Full Name</b></label>
                            <input class="w3-input w3-border w3-round" style="margin-top: 10px;" name="addname1" type="text" id="addname1" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>Phone Number</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="addphone1" type="text" id="addphone1" required>
                        </div>
                    </div>
                    <label><b>Address 1</b></label>
                    <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="add1i" type="text" id="add1i" required>
                    <label><b>Address 2</b></label>
                    <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="add2i" type="text" id="add2i" required>
                    <label><b>Address 3</b></label>
                    <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="add3i" type="text" id="add3i" required>

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>City</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="city1" type="text" id="city1" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>Postal Code</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="postalcode1" type="text" id="postalcode1" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>State</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="state1" type="text" id="state1" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>Country</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px;" name="country1" type="text" id="country1" required>
                        </div>
                    </div>

                    <p style="margin-top: 10px;"><b>Label As</b></p>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="label1" id="homeLabel" value="Home">
                            Home
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="label1" id="workLabel" value="Work">
                            Work
                        </label>
                    </div>

                    <p class="d-flex justify-content-center">
                        <button class="button w3-btn w3-round bdesign" style="margin-top: 20px; padding-left:20px; padding-right:20px;" name="editaddress" value="editaddress">Update Address </button>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!--Delete New Address-->
    <div class="delete-entry-modal" id="deleteaddress">
        <div class="delete-entry-modal-content">
            <h2><b>Delete Address</b></h2>
            <p>Are you sure you want to delete this address?</p>
            <form method="POST" id="deleteAddressForm">
                <button class="btnDelete" type="submit" name="delete" value="deleteaddress">Delete</button>
                <button class="btnCancel" type="button" onclick="closeDeleteModal()">Cancel</button>
            </form>
        </div>
    </div>
    <script>
        function openDeleteModal(addressId, userId) {
            const modal = document.getElementById("deleteaddress");
            const form = document.getElementById("deleteAddressForm");
            form.action = `deleteprofile.php?addressid=${addressId}&&userid=${userId}`;
            modal.style.display = "block";
        }

        function closeDeleteModal() {
            const modal = document.getElementById("deleteaddress");
            modal.style.display = "none";
        }
    </script>
    <!--Add New Card-->
    <div id="addcard" class="w3-modal">
        <div class="w3-modal-content" style="width:50%">
            <header class="w3-container" style="background-color:#004891; color:white;">
                <span onclick="document.getElementById('addcard').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h4 style="margin-top: 15px; margin-bottom:15px">Add New Debit / Credit Card</h4>
            </header>
            <div class="w3-container w3-padding">
                <form action="profile.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                    <div style="margin-top: 15px; margin-bottom: 15px;">
                        <label><b>Card Bank</b></label>
                        <input class="w3-input w3-border w3-round" style="margin-top: 10px;" name="bank" type="text" id="bank" required>
                    </div>

                    <label><b>Card Number</b></label>
                    <input class="w3-input w3-border w3-round" style="margin-top: 10px; margin-bottom: 15px;" name="cardno" type="text" id="cardno" required>

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>Expiry Date (MM/YY)</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px; margin-bottom: 15px;" name="expires" type="text" id="expires" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>CCV</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px; margin-bottom: 15px;" name="ccv" type="text" id="ccv" required>
                        </div>
                    </div>
                    <label><b>Name on Card</b></label>
                    <input class="w3-input w3-border w3-round" style="margin-top: 10px;" name="cardname" type="text" id="cardname" required>

                    <p class="d-flex justify-content-center">
                        <button class="button w3-btn w3-round bdesign" style="margin-top: 20px; padding-left:20px; padding-right:20px;" name="addcard" value="addcard">Add Card</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Card number formatting
        const cardNumberInput = document.getElementById('cardno');
        cardNumberInput.addEventListener('input', formatCardNumber);

        function formatCardNumber() {
            let cardNumber = cardNumberInput.value.replace(/[^\d]/g, '');
            const cardNumberLength = cardNumber.length;

            if (cardNumberLength > 16) {
                cardNumber = cardNumber.slice(0, 16);
            }

            if (cardNumberLength > 0 && cardNumberLength % 4 === 0) {
                cardNumber = cardNumber.match(/.{1,4}/g).join(' ');
            }

            cardNumberInput.value = cardNumber;
        }

        // Expiry date validation
        document.addEventListener('DOMContentLoaded', function() {
            const expiryInput = document.getElementById('expires');
            expiryInput.addEventListener('input', validateExpiryDate);

            function validateExpiryDate() {
                let expiryDate = expiryInput.value;
                const sanitizedValue = expiryDate.replace(/[^0-9]/g, ''); // Remove non-numeric characters
                let formattedValue = '';
                const isValid = /^\d{2}$/.test(sanitizedValue);

                if (sanitizedValue.length > 2) {
                    const month = sanitizedValue.substr(0, 2);
                    const year = sanitizedValue.substr(2, 2);
                    formattedValue = month + '/' + year;
                } else {
                    formattedValue = sanitizedValue;
                }
                const valid = /^\d{2}\/\d{2}$/.test(formattedValue);

                expiryInput.value = formattedValue;
                expiryInput.setCustomValidity(valid ? '' : 'Invalid expiry date format (MM/YY)');
            }
        });

        // CCV validation
        const ccvInput = document.getElementById('ccv');
        ccvInput.addEventListener('input', validateCCV);

        function validateCCV() {
            let ccv = ccvInput.value;
            const sanitizedValue = ccv.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            const isValid = /^\d{3}$/.test(sanitizedValue);

            // Restrict the length of the CCV to 3 digits
            if (sanitizedValue.length > 3) {
                ccv = sanitizedValue.substr(0, 3);
            }

            ccvInput.value = ccv;
            ccvInput.setCustomValidity(isValid ? '' : 'CCV must be 3 digits');
        }
    </script>
    <!--Edit New Card-->
    <script>
        function openEditCard(cardId, userId) {
            $.ajax({
                url: 'editprofile.php',
                method: 'POST',
                data: {
                    cardId: cardId,
                    userId: userId
                },
                dataType: 'json',
                success: function(data) {
                    // Populate the Edit popup box with the retrieved card details
                    $('#cardid').val(data.card_id);
                    $('#uid').val(data.user_id);
                    $('#bank1').val(data.card_bank);
                    $('#cardno1').val(data.card_no);
                    $('#expires1').val(data.card_expires);
                    $('#ccv1').val(data.ccv);
                    $('#cardname1').val(data.card_name);

                    // Display the Edit popup box
                    $('#editcard').css('display', 'block');
                },
                error: function(error) {
                    console.error('Error:', error);
                    alert("error");
                    // Handle error case if necessary
                }
            });
        }
    </script>
    <div id="editcard" class="w3-modal">
        <div class="w3-modal-content" style="width:50%">
            <header class="w3-container" style="background-color:#004891; color:white;">
                <span onclick="document.getElementById('editcard').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h4 style="margin-top: 15px; margin-bottom:15px">Edit Card Details</h4>
            </header>
            <div class="w3-container w3-padding">
                <form action="editprofile.php" method="post">
                    <input type="hidden" name="cardid" id="cardid">
                    <input type="hidden" name="uid" id="uid">
                    <div style="margin-top: 15px; margin-bottom: 15px;">
                        <label><b>Card Bank</b></label>
                        <input class="w3-input w3-border w3-round" style="margin-top: 10px;" name="bank1" type="text" id="bank1" required>
                    </div>

                    <label><b>Card Number</b></label>
                    <input class="w3-input w3-border w3-round" style="margin-top: 10px; margin-bottom: 15px;" name="cardno1" type="text" id="cardno1" required>

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>Expiry Date (MM/YY)</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px; margin-bottom: 15px;" name="expires1" type="text" id="expires1" required>
                        </div>
                        <div class="col-md-6">
                            <label><b>CCV</b></label>
                            <input class="w3-input w3-border w3-round bdesign" style="margin-top: 10px; margin-bottom: 15px;" name="ccv1" type="text" id="ccv1" required>
                        </div>
                    </div>
                    <label><b>Name on Card</b></label>
                    <input class="w3-input w3-border w3-round" style="margin-top: 10px;" name="cardname1" type="text" id="cardname1" required>

                    <p class="d-flex justify-content-center">
                        <button class="button w3-btn w3-round bdesign" style="margin-top: 20px; padding-left:20px; padding-right:20px;" name="editcard" value="editcard">Save Changes</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Card number formatting
        const cardNumberInput1 = document.getElementById('cardno1');
        cardNumberInput1.addEventListener('input', formatCardNumber1);

        function formatCardNumber1() {
            let cardNumber1 = cardNumberInput1.value.replace(/[^\d]/g, '');
            const cardNumberLength1 = cardNumber1.length;

            if (cardNumberLength1 > 16) {
                cardNumber1 = cardNumber1.slice(0, 16);
            }

            if (cardNumberLength1 > 0 && cardNumberLength1 % 4 === 0) {
                cardNumber1 = cardNumber1.match(/.{1,4}/g).join(' ');
            }

            cardNumberInput1.value = cardNumber1;
        }

        // Expiry date validation
        document.addEventListener('DOMContentLoaded', function() {
            const expiryInput1 = document.getElementById('expires1');
            expiryInput1.addEventListener('input', validateExpiryDate1);

            function validateExpiryDate1() {
                let expiryDate1 = expiryInput1.value;
                const sanitizedValue1 = expiryDate1.replace(/[^0-9]/g, ''); // Remove non-numeric characters
                let formattedValue1 = '';
                const isValid1 = /^\d{2}$/.test(sanitizedValue1);

                if (sanitizedValue1.length > 2) {
                    const month1 = sanitizedValue1.substr(0, 2);
                    const year1 = sanitizedValue1.substr(2, 2);
                    formattedValue1 = month1 + '/' + year1;
                } else {
                    formattedValue1 = sanitizedValue1;
                }
                const valid1 = /^\d{2}\/\d{2}$/.test(formattedValue1);

                expiryInput1.value = formattedValue1;
                expiryInput1.setCustomValidity(valid1 ? '' : 'Invalid expiry date format (MM/YY)');
            }
        });

        // CCV validation
        const ccvInput1 = document.getElementById('ccv1');
        ccvInput1.addEventListener('input', validateCCV1);

        function validateCCV1() {
            let ccv1 = ccvInput1.value;
            const sanitizedValue1 = ccv1.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            const isValid1 = /^\d{3}$/.test(sanitizedValue1);

            // Restrict the length of the CCV to 3 digits
            if (sanitizedValue1.length > 3) {
                ccv1 = sanitizedValue1.substr(0, 3);
            }

            ccvInput1.value = ccv1;
            ccvInput1.setCustomValidity(isValid1 ? '' : 'CCV must be 3 digits');
        }
    </script>

    <!--Delete New Card-->
    <div class="delete-entry-modal" id="deletecard">
        <div class="delete-entry-modal-content">
            <h2><b>Delete Debit / Credit Card</b></h2>
            <p>Are you sure you want to delete this debit / credit card?</p>
            <form method="POST" id="deleteCardForm">
                <button class="btnDelete" type="submit" name="delete" value="deletecard">Delete</button>
                <button class="btnCancel" type="button" onclick="closeDeleteCard()">Cancel</button>
            </form>
        </div>
    </div>
    <script>
        function openDeleteCard(cardId, userId) {
            const modal = document.getElementById("deletecard");
            const form = document.getElementById("deleteCardForm");
            form.action = `deleteprofile.php?cardid=${cardId}&&userid=${userId}`;
            modal.style.display = "block";
        }

        function closeDeleteCard() {
            const modal = document.getElementById("deletecard");
            modal.style.display = "none";
        }
    </script>
</body>

</html>