<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include_once("dbconnect.php");
session_start();

$carttotal = isset($_SESSION['carttotal']) ? $_SESSION['carttotal'] : 0;
$useremail = "Guest";
$user_name = "Guest";
$user_phone = "-";

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
}

$books = []; // Initialize $books as an empty array

// Database query to fetch relevant books based on the search keyword
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    if ($search != "") {
        $sqlsearch = "SELECT * FROM tbl_books 
                      WHERE book_title LIKE :search
                      OR book_author LIKE :search
                      OR book_isbn LIKE :search
                      OR book_price LIKE :search
                      OR book_description LIKE :search
                      OR book_pub LIKE :search
                      OR book_lang LIKE :search";

        $stmt = $conn->prepare($sqlsearch);
        $stmt->bindValue(':search', '%' . $search . '%');
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    } else {
        echo "<script>alert('Please enter the search keyword.');</script>";
        // Database query to fetch all books
        $sqlquery = "SELECT * FROM tbl_newbooks";
        $stmt = $conn->prepare($sqlquery);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    // Database query to fetch new books
    $sqlquery = "SELECT * FROM tbl_newbooks";
    $stmt = $conn->prepare($sqlquery);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if (isset($_GET['submit']) && $_GET['submit'] == "cart") {
    if ($useremail != "Guest"){
        $bookid = $_GET['bookid'];
        $cartqty = "1";
        $stmt = $conn->prepare("SELECT * FROM tbl_carts WHERE user_email = '$useremail' AND book_id = '$bookid'");
        $stmt->execute();
        $number_of_rows = $stmt->rowCount();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
        if ($number_of_rows > 0){
            foreach ($rows as $carts){
                $cartqty = $carts['cart_qty'];
            }
            $cartqty = $cartqty + 1;
            $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND book_id = '$bookid'";
            $conn->exec($updatecart);
            echo "<script>alert('Cart updated')</script>";
            echo "<script> window.location.replace('booklist.php')</script>";
        }
        else{
            $addcart = "INSERT INTO `tbl_carts`(`user_email`, `book_id`, `cart_qty`) VALUES ('$useremail','$bookid','$cartqty')";
            try{
                $conn->exec($addcart);
                echo "<script>alert('Success')</script>";
                echo "<script> window.location.replace('booklist.php')</script>";
            }
            catch(PDOException $e){
                echo "<script>alert('Failed')</script>";
            }
        }
    }
    else{
        echo "<script>alert('Please login or register')</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }
}

// Function to truncate a string if it exceeds a certain length
function subString($str)
{
    if (strlen($str) > 20) {
        return $substr = substr($str, 0, 20) . '...';
    } else {
        return $str;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="js/script.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />

    <style>
        .book-title a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 19px;
            transition: color 0.3s, text-decoration 0.3s;
        }

        .book-title a:hover {
            color: #3286AA;
            text-decoration: underline;
        }

        .cartbutton {
            padding: 8px;
            background-color: #3286AA;
            color: aliceblue;
            font-size: medium;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px !important;
            max-width: 200px;
        }

        .cartbutton:hover {
            background-color: #2c7291;
        }

        /* Book List Styles */

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Karma", sans-serif;
        }

        .w3-bar-block .w3-bar-item {
            padding: 20px;
        }

        .w3-grid-template {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 15px;
        }

        .w3-card {
            width: 100%;
            height: 100%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .w3-card:hover {
            box-shadow: 0 8px 16px 0 rgba(50, 132, 171, 0.2);
        }

        .w3-image {
            width: 100%;
            height: 370px;
            object-fit: cover;
        }

        .w3-description {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;

        }

        .w3-button {
            padding: 8px 16px;
            font-size: 14px;
            background-color: blue;
            color: white;
            border-radius: 5px;
        }

        @media screen and (max-width: 600px) {
            .w3-card {
                height: auto;
            }

            .w3-image {
                width: 100%;
                height: auto;
                object-fit: cover;
            }

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

</head>

<body>
    <header>
        <?php include_once("menu.php"); ?>
    </header>

    <div class="w3-main w3-content w3-padding" style="max-width:1000px;margin-top:20px">
        <div class="w3-container w3-center">
        <div style="display: inline-block; border-bottom: 4px solid rgb(46,135,174);">
            <p style="font-size: 36px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                Latest Arrival
            </p>
        </div>

            <?php if (count($books) == 0 && !empty($search)) {
                echo '<div class="alert alert-danger"><em>The keyword "'.$search.'" is not found. Please try again.</em></div>';
            }?>
        </div>
    </div>

    <!-- Main content -->
    <div class="w3-main w3-content w3-padding" style="max-width:1350px;margin-top:10px">
        <!-- Book listings -->
        <div class="w3-grid-template">
            <?php
            // Displaying the books
            foreach ($books as $book) {
                // Extracting book details
                $bookid = $book['book_id'];
                $book_title = subString($book['book_title']);
                $book_author = $book['book_author'];
                $book_isbn = $book['book_isbn'];
                $book_price = $book['book_price'];
                $book_description = $book['book_description'];
                $book_pub = $book['book_pub'];
                $book_lang = $book['book_lang'];
                $book_date = $book['book_date'];
                $book_qty = $book['book_qty'];

                // Displaying book information in a card format with a link to details page
                echo "
                <div class='w3-center w3-padding-small' style='min-height:380px;'>
                    <div class='w3-card w3-round-large'>
                        <div class='w3-padding-small'>
                            <img class='w3-container w3-image' src='images/books/$bookid.jpg' onerror='this.onerror=null; this.src='images/logo1.jpeg'; style='min-height:240px; margin-top:15px;'>
                        </div>
                        <div class='w3-description'>
                        <h6 class='book-title' style='margin-top:10px;'><a href='bookdetails.php?bookid=$bookid'>$book_title</a></h6>
                            <p>RM " . number_format($book_price, 2) . " / $book_qty avail</p>
                            <a href='booklist.php?bookid=$bookid&submit=cart' class='cartbutton w3-round-small' style='margin-bottom: auto;'>
                                <i class='fas fa-cart-plus'></i> Add to cart
                            </a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
    
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