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
    if ($_GET['submit'] == "search") {
        $search = $_GET['search'];
        $sqlquery = "SELECT * FROM tbl_books WHERE book_qty > 0 AND book_title LIKE '%$search%'";
    }
} 
else {
    $sqlquery = "SELECT * FROM tbl_books WHERE book_qty > 0 ORDER BY book_id DESC LIMIT 8";
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
                        <a href="#" style="color:darkblue; font-size: large;">More &rsaquo;&rsaquo;&rsaquo;</a>
                    </div>
                </div>
            </header>
        </div>

        <!--books list-->
        <div class="row" style="margin-left: 180px; margin-right:180px">
            <?php foreach ($rows as $row) { ?>
                <div class="col-lg-3 col-md-6 col-sm-6 d-flex">
                    <div class="card w-100 my-2 shadow-2-strong">
                        <img src="images/logo.png" class="card-img-top" style="aspect-ratio: 1 / 1" />
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title" style="font-weight:bold;"><?php echo $row['book_title']; ?></h5>
                            <p class="card-text" style="font-size: medium;"><?php echo "RM ". $row['book_price']; ?></p>
                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                <a href="index.php?bookid=<?php echo $row['book_id']; ?>&submit=cart" class="button btn-sm px-3 me-2" onclick="addToCart(<?php echo $row['book_id']; ?>)">
                                    <i class="fas fa-cart-plus"></i> Add to cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

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