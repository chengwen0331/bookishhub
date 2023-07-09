<?php
include_once("dbconnect.php");
include "menu.php";

$sqlquery = "";

if (isset($_GET['submit'])) {
    
    if ($_GET['submit'] == "cart") {
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
                echo "<script> window.location.replace('index.php')</script>";
            }
            else{
                $addcart = "INSERT INTO `tbl_carts`(`user_email`, `book_id`, `cart_qty`) VALUES ('$useremail','$bookid','$cartqty')";
                try{
                    $conn->exec($addcart);
                    echo "<script>alert('Success')</script>";
                    echo "<script> window.location.replace('index.php')</script>";
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
} 
else {
    $sqlquery = "SELECT * FROM tbl_newbooks";
}

$stmtqty = $conn->prepare("SELECT * FROM tbl_carts WHERE user_email = '$useremail'");
$stmtqty->execute();
$resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
$rowsqty = $stmtqty->fetchAll();
$carttotal = 0; // Initialize $carttotal variable
foreach ($rowsqty as $carts){
    $carttotal += $carts['cart_qty'];
}
$_SESSION['carttotal'] = $carttotal;

$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

function subString($str){
    if (strlen($str) > 15){
        return $substr = substr($str, 0, 15) . '...';
    }
    else{
        return $str;
    }
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .more {
            color: darkblue;
            font-size: large;
            text-decoration: none;
        }

        .more:hover {
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
        </style>
    </head> 
<body>
    <div class="w3-main w3-content w3-padding" style="max-width:1000px;margin-top:20px">
        <div class="w3-container w3-center">
            <p style="font-size: 36px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">
                Welcome <?php echo $user_name; ?> !
            </p>
        </div>
    </div>

    <!--Pictures Show-->
    <div class="slideshow-container">
        <div class="mySlides">
            <div class="numbertext" style="color: white;">1 / 3</div>
            <center><img src="images/first.png" width="100%"></center>
        </div>

        <div class="mySlides">
            <div class="numbertext">2 / 3</div>
            <center><img src="images/second.png" width="100%"></center>
        </div>

        <div class="mySlides">
            <div class="numbertext">3 / 3</div>
            <center><img src="images/third.jpg" width="100%"></center>
        </div>

        <!-- Previous and Next Buttons -->
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>
    <br>
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>

    <script>
        let slideIndex = 1;

        showSlides(slideIndex);

        function showSlides(index) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");

            if (index > slides.length) {
                slideIndex = 1;
            } else if (index < 1) {
                slideIndex = slides.length;
            }

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }

        // Function to handle manual slide selection
        function currentSlide(index) {
            showSlides(slideIndex = index);
        }

        // Function to handle previous/next button click
        function changeSlide(index) {
            showSlides(slideIndex += index);
        }

        // Add event listeners to dots for manual slide selection
        let dots = document.getElementsByClassName("dot");
        for (let i = 0; i < dots.length; i++) {
            dots[i].addEventListener("click", function () {
                currentSlide(i + 1);
            });
        }
    </script>

    <br>

    <section>
        <div class="container my-5">
            <header class="mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 style="font-weight: bold;">Latest Arrivals</h3>
                    </div>
                    <div class="col-auto">
                        <a href="booklist.php" style="color:darkblue; font-size: large;">More &rsaquo;&rsaquo;&rsaquo;</a>
                    </div>
                </div>
            </header>
        </div>

        <!--books list-->
        <div class="w3-main w3-content w3-padding" style="max-width:1350px;margin-top:10px">
            <div class="w3-grid-template">
                <?php
                foreach ($rows as $book) {
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
                            <a href='index.php?bookid=$bookid&submit=cart' class='cartbutton w3-round-small' style='margin-bottom: auto;'>
                                <i class='fas fa-cart-plus'></i> Add to cart
                            </a>
                        </div>
                    </div>
                </div>";
                }
                ?>
            </div>
        </div>
    </section>
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
    <script>
        function addToCart(bookid) {
            jQuery.ajax({
                type: "GET",
                url: "updatecartajax.php",
                data: {
                    bookid: bookid,
                    submit: 'add',
                },
                cache: false,
                dataType: "json",
                success: function(response) {
                    var res = JSON.parse(JSON.stringify(response));
                    console.log("HELLO ");
                    console.log(res.status);
                    if (res.status == "success") {
                        console.log(res.data.carttotal);
                        //document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
                        document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
                        alert("Success");
                    }
                    if (res.status == "failed") {
                        alert("Please login/register account");
                    }
                    

                }
            });
        }
</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>