<?php
include_once("dbconnect.php");
include "menu.php";

if (isset($_GET['submit'])) {
    include_once("dbconnect.php");
    if ($_GET['submit'] == "cart") {
        if ($useremail == "Guest") {
            echo "<script>alert('Please login or register')</script>";
            echo "<script> window.location.replace('login.php')</script>";
        }
    }
    if ($_GET['submit'] == "search") {
        $search = $_GET['search'];
        $sqlquery = "SELECT * FROM tbl_books WHERE book_qty > 0 AND book_title LIKE '%$search%'";
    }
} else {
    $sqlquery = "SELECT * FROM tbl_books WHERE book_qty > 0 ORDER BY book_id DESC LIMIT 8";
}

$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$rows = $stmt->fetchAll();

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
                                <a href="#" class="button btn-sm px-3 me-2" onclick="addToCart(<?php echo $row['book_id']; ?>)">
                                    <i class="fas fa-cart-plus"></i> Add to cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <footer class="w3-row-padding w3-padding-32">
        <hr></hr>
         <p class="w3-center">&copy;2023 | BookishHub&reg;</p>
    </footer>
</body>

</html>