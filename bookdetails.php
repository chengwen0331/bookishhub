<?php
include_once("dbconnect.php");
include "menu.php";
$bookid = $_GET['bookid'];

if (isset($_GET['submit']) && $_GET['submit'] == "cart" && isset($_GET['bookid']) && isset($_GET['bookqty'])) {
    if ($useremail != "Guest") {
        $bookid = $_GET['bookid'];
        $bookqty = $_GET['bookqty'];

        if ($bookqty == '') {
            $bookqty = 1;
        } else {
            $bookqty = $bookqty;
        }

        // Retrieve the quantity available for the book from the database
        $stmt = $conn->prepare("SELECT book_qty FROM tbl_books WHERE book_id = '$bookid'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $quantityAvailable = $result['book_qty'];

        // Check if the added quantity exceeds the quantity available
        if ($bookqty > $quantityAvailable) {
            echo "<script>alert('Quantity exceeds availability')</script>";
            echo "<script>window.location.replace('bookdetails.php?bookid=$bookid')</script>";
        } else {
            // Check if the book is already in the cart
            $stmt = $conn->prepare("SELECT * FROM tbl_carts WHERE user_email = '$useremail' AND book_id = '$bookid'");
            $stmt->execute();
            $number_of_rows = $stmt->rowCount();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();

            if ($number_of_rows > 0) {
                foreach ($rows as $carts) {
                    $cartqty = $carts['cart_qty'];
                }
                $cartqty += intval($bookqty);

                $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND book_id = '$bookid'";
                $conn->exec($updatecart);
                echo "<script>alert('Cart updated')</script>";
                echo "<script>window.location.replace('bookdetails.php?bookid=$bookid')</script>";
            } else {
                $addcart = "INSERT INTO `tbl_carts`(`user_email`, `book_id`, `cart_qty`) VALUES ('$useremail','$bookid','$bookqty')";
                try {
                    $conn->exec($addcart);
                    echo "<script>alert('Success')</script>";
                    echo "<script>window.location.replace('bookdetails.php?bookid=$bookid')</script>";
                } catch (PDOException $e) {
                    echo "<script>alert('Failed')</script>";
                }
            }
        }
    } else {
        echo "<script>alert('Please login or register')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    }
}

if (isset($_GET['submit']) && $_GET['submit'] == "wishlist" && isset($_GET['bookid'])) {
    if ($useremail != "Guest") {
        $bookid = $_GET['bookid'];
        $stmt = $conn->prepare("SELECT book_qty FROM tbl_books WHERE book_id = '$bookid'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $bookqty = $result['book_qty'];

        // Check if the book is already in the wishlist
        $stmt = $conn->prepare("SELECT * FROM tbl_wishlist WHERE user_email = '$useremail' AND book_id = '$bookid'");
        $stmt->execute();
        $number_of_rows = $stmt->rowCount();

        if ($number_of_rows > 0) {
            echo "<script>alert('Book already in wishlist')</script>";
            echo "<script>window.location.replace('bookdetails.php?bookid=$bookid')</script>";
        } else {
            $addwishlist = "INSERT INTO `tbl_wishlist`(`user_email`, `book_id`, `book_qty`) VALUES ('$useremail', '$bookid', '$bookqty')";
            try {
                $conn->exec($addwishlist);
                echo "<script>alert('Added to wishlist')</script>";
                echo "<script>window.location.replace('bookdetails.php?bookid=$bookid')</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Failed to add to wishlist')</script>";
            }
        }
    } else {
        echo "<script>alert('Please login or register')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    }
}


// Use prepared statements to prevent SQL injection
$sqlquery = "SELECT * FROM tbl_books WHERE book_id = :bookid";
$stmt = $conn->prepare($sqlquery);
$stmt->bindParam(':bookid', $bookid); // Bind the bookid parameter
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {
    foreach ($rows as $books) {
        // Extract the book details
        $book_title = $books['book_title'];
        $book_author = $books['book_author'];
        $book_isbn = $books['book_isbn'];
        $book_price = $books['book_price'];
        $book_description = $books['book_description'];
        $book_pub = $books['book_pub'];
        $book_lang = $books['book_lang'];
        $book_qty = $books['book_qty'];
        $book_date = date_format(date_create($books['book_date']), 'd/m/y h:i A');
    }
} else {
    // Book details not found
    echo "Book details not available.";
    echo "SQL Query: " . $sqlquery . "<br>";
    echo "Book ID: " . $bookid . "<br>";

    exit; // Stop further execution
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
    <link rel="stylesheet" type="text/css" href="css/bookdetails_style.css">
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <script src="../js/script.js"></script>
    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            margin-top: 20px;
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
            text-align: center;
        }

        .cartbutton:hover {
            background-color: #2c7291;
        }
    </style>
</head>

<body>

    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:75px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

        <div class="w3-row w3-card">
            <div class="w3-half w3-center">
                <img class="w3-image w3-margin w3-center" style="height:100%;width:100%;max-width:330px; padding:20px 0px 0px 0px" src="images/books/<?php echo $bookid ?>.jpg">
            </div>
            <div class="w3-half w3-container" style="font-size: medium;">
                <?php
                echo "<h3 class='w3-center' style='padding:5px 0px 5px 0px'><b>$book_title</h3></b>
                <div>
                <h4>Product Overview</h4>
                <table class='w3-table'>
        
                    <tr>
                        <td class='custom-table-row'>ISBN</td>
                        <td>$book_isbn</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Author(s)</td>
                        <td>$book_author</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Publisher</td>
                        <td>$book_pub</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Language</td>
                        <td>$book_lang</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Quantity Available</td>
                        <td id='qtyAvailable'>$book_qty</td>
                    </tr>
                </table>
                </div>
                <br>
                <p style='color:rgb(19, 96, 174); font-weight: 900;'>Description<p/>
                <p style='ext-align: justify;'>$book_description</p>
            
                <p style='font-size:160%; color:rgb(19, 96, 174); font-weight: 900; padding: 10px 0px 10px 0px;'>RM " . number_format($book_price, 2) . "</p>
               
                ";
                if($book_qty<=0){
                    echo"<p style='color: red; font-size:xx-large; margin-top:30px;'><b>Out of stock</b></p>
                            <p>
                            <a href='bookdetails.php?bookid=$bookid&submit=wishlist' class='cartbutton w3-round-small' id='add-to-wishlist-button'>
                                <i class='fas fa-heart'></i> Wishlist
                            </a>
                        </p>";
                }else {
                    echo"<div class='w3-col w3-margin-bottom'>
                    <label class='w3-col mb-2 d-block' style='color:rgb(19, 96, 174); font-weight: 900;'>Quantity</label>
                        <div class='w3-input-group w3-margin-bottom' style='width: 170px; display: flex; align-items: center;'>
                            <button class='w3-button w3-white w3-border w3-border-secondary w3-round-large' type='button' id='button-addon1' data-mdb-ripple-color='dark' style='margin-right: 10px;'>
                                <i class='fa fa-minus' style='display: flex; align-items: center; justify-content: center;'></i>
                            </button>
                            <input type='text' id='quantity-input' value='1' class='w3-input w3-center w3-border w3-border-secondary' placeholder='1' aria-label='Example text with button addon' aria-describedby='button-addon1' style='margin-right: 10px;' readonly>
                            <button class='w3-button w3-white w3-border w3-border-secondary w3-round-large' type='button' id='button-addon2' data-mdb-ripple-color='dark' style='display: flex; align-items: center; justify-content: center;'>
                                <i class='fa fa-plus'></i>
                            </button>
                        </div>
                    </div>
                            
                    <p>
                        <a href='bookdetails.php?bookid=$bookid&submit=cart&bookqty=' + quantityInput.value' class='cartbutton w3-round-small' id='add-to-cart-button' style='margin-right: 10px;'>
                            <i class='fas fa-cart-plus'></i> Add to cart
                        </a>
                        <a href='bookdetails.php?bookid=$bookid&submit=wishlist' class='cartbutton w3-round-small' id='add-to-wishlist-button'>
                            <i class='fas fa-heart'></i> Wishlist
                        </a>
                    </p>";
                }
    
            
                ?>
            </div>
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


    <!-- JavaScript code -->
    <script>
        // Wait for the DOM to load
        document.addEventListener('DOMContentLoaded', function() {
            // Get the quantity input and add event listeners
            var quantityInput = document.getElementById('quantity-input');
            var addToCartButton = document.getElementById('add-to-cart-button');
            var bookid = '<?php echo $bookid; ?>'; // Get the bookid value from PHP

            // Function to update the URL of the "Add to Cart" button
            function updateCartURL() {
                var quantity = parseInt(quantityInput.value); // Get the current quantity value
                addToCartButton.href = "bookdetails.php?bookid=" + bookid + "&submit=cart&bookqty=" + quantity;
            }

            // Set the initial quantity value
            var quantity = 1;
            quantityInput.value = quantity;

            // Add event listener for the plus button
            document.getElementById('button-addon2').addEventListener('click', function() {
                // Increment the quantity by 1
                var currentqty = parseInt(quantityInput.value);
                var newqty = currentqty + 1;
                quantityInput.value = newqty;
                var quantityAvailable = parseInt(document.getElementById('qtyAvailable').textContent);

                if (newqty > quantityAvailable) {
                    alert("Quantity exceeds availability");
                    quantityInput.value = currentqty;
                }
                // Update the "Add to Cart" button URL
                updateCartURL();
            });

            // Add event listener for the minus button
            document.getElementById('button-addon1').addEventListener('click', function() {
                // Decrement the quantity by 1, minimum value is 1
                var currentqty = parseInt(quantityInput.value);
                if (currentqty > 1) {
                    var newqty = currentqty - 1;
                    quantityInput.value = newqty;

                    // Update the "Add to Cart" button URL
                    updateCartURL();
                }
            });

            // Add event listener for the "Add to Cart" button
            addToCartButton.addEventListener('click', function(e) {
                // Prevent the default link behavior if the quantity is not valid
                if (quantity < 1) {
                    e.preventDefault();
                    return;
                }
            });
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</body>

</html>