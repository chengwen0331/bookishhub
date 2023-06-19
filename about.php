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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="shortcut icon" type="image/jpeg" href="images/logo1.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body{
            background-color: rgb(250, 251, 253);
        }
        .box{
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 85rem;
            margin-left: auto;
            margin-right: auto;
        }
        .about{
            margin-top: 0.5rem;
            overflow: hidden;
            position: relative;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            transition: all .3s ease;
            max-width: 75rem;
            margin-left: auto;
            margin-right: auto;
        }
        .description{
            margin-top:1rem;
        }
        .description h1{
            font-size: 1.5rem;
            padding-left: 1.5rem;
            padding-right: 1rem;
            font-weight: bold;
        }
        .vs-divider {
            width: 100%;
            margin: 15px 0;
            clear: both;
            width: 100%;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        .vs-divider .after, .vs-divider .before {
            position: relative;
            display: block;
        }
        .content{
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            display: block;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            text-align: justify;
            line-height: 20px;
        }
        footer{
            background-color: white;
            color: black;
        }
        .footer_info{
            width: 90%;
            margin: 0 auto;
            display: flex;
            padding: 50px 0;
        }
        .footer_info .footer_width{
            padding: 0 70px;
        }
        .footer_info h2{
            margin-bottom: 20px;
        }
        .about .service, .contact{
            width: 40%;
            justify-content: space-between;
        }
        .social_media{
            margin-top:30px;
        }
        .social_media ul{
            display: flex;
        }
        .social_media ul li i{
            display: inline-block;
            margin-right: 50px;
            width: 50px;
            height: 50px;
            padding-top: 12px;
            background-color: transparent;
            border: 1px solid black;
            text-align: center;
        }
        .contact ul li,
        .operation ul li{
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .contact ul li span, 
        .operation ul li span{
            margin-right: 15px;
        }
        .copy-right{
            padding:15px 0;
            text-align: center;
            background-color: #666;
        }
    </style>
</head>
<body> 
    <div class="box">
        <div class="about">
            <div style="max-height: 600px;">
                <img src="images/about.png" alt="" style="height: 500px; width:75rem">           
            </div>
            <div class="description">
                <h1>About Us</h1>
                <div class="vs-component vs-divider">
                    <span class="vs-divider-border after vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                    <span class="vs-divider-border before vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                </div>
                <main class="content">
                    <div>
                        <p>
                           Established in Kuala Lumpur, Malaysia, Bookish Hub is the leading online bookstore in Malaysia for professional books in various fields.
                        </p><br>
                        <p>
                            Bookish Hub is 100% managed by Malaysians and is strongly positioned as a trilingual bookstore catering for everyone from all walks of life.
                        </p><br>
                        <p>
                            We believe that books should be available to all, regardless of one’s background or creed.
                        </p><br>
                        <p>
                            In our endeavour to bring the joy of reading to our customers, we at Bookish Hub are proud to accept this challenge head on.
                        </p><br> 
                        <p>
                            Bookish Hub sells a wide variety of fiction, non-fiction and general interest books in English, Chinese and Malay languages, as well as text & assessments.
                        </p><br>
                        <p>
                            We aim to provide our customers an enriching reading experience at an affordable price while remaining profitable. We are continuously finding ways to reduce the cost to our customers to read a book.
                        </p><br>   
                        <p>
                            It is our hope that we are able to reach out to all readers throughout the world, while sharing the joy of reading one.
                        </p><br> 
                        <p>
                            Bookish Hub is continuously reinventing itself to become a customer-centric and dynamic retailer of the new millennium. 
                        </p><br>                                                 
                    </div>
                </main>
                <h1>Mission</h1>
                <div class="vs-component vs-divider">
                    <span class="vs-divider-border after vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                    <span class="vs-divider-border before vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                </div>
                <main class="content">
                    <div>
                        <p>
                            To inspire a love for reading and learning by providing a curated collection of diverse and high-quality books.
                            Besides, we aim to foster a reading revolution by making books accessible, engaging, and transformative for people of all ages and backgrounds.
                        </p><br>                                          
                    </div>
                </main>
                <h1>Vision</h1>
                <div class="vs-component vs-divider">
                    <span class="vs-divider-border after vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                    <span class="vs-divider-border before vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                </div>
                <main class="content">
                    <div>
                        <p>
                            To be the premier online destination for book lovers worldwide, recognized for our exceptional curation, unparalleled community engagement, and commitment to fostering a lifelong passion for reading. 
                            We aspire to be a catalyst for intellectual growth, personal enrichment, and cultural understanding, creating a global community united by a shared love for books and knowledge.
                        </p><br>                                          
                    </div>
                </main>
                <h1>Our Promise</h1>
                <div class="vs-component vs-divider">
                    <span class="vs-divider-border after vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                    <span class="vs-divider-border before vs-divider-border-default" style="width: 100%; border-top: 1px solid rgba(0, 0, 0, 0.1);"></span>
                </div>
                <main class="content">
                    <div>
                        <p>
                            Bookish Hub promises our customers that we will work endlessly to maintain the high standards we set ourselves. 
                            The promotion of readership across the age spectrum and the expression of originality and creativity will be our guide to our dynamic business model and decision making process.
                        </p><br>                                          
                    </div>
                </main>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer_info">
            <div class="footer_width about" id="about_info">
                <h2>About Us</h2>
                <p>
                    Sakura Restaurant is a good choice and everyone<br> 
                    can enjoy tasty food here. Better food, Better mood,<br> 
                    the food here tastes like paradise. You also have a <br>
                    chance to customize your meals. Please come and try it.<br> 
                </p>
                <div class="social_media">
                    <ul>
                        <li>
                            <i class="fa-brands fa-facebook-f" style="font-size: 20px;"></i>
                        </li>
                        <li>
                            <i class="fa-brands fa-instagram" style="font-size: 20px;"></i>
                        </li>
                        <li>
                            <i class="fa-brands fa-square-twitter" style="font-size: 20px;"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer_width service">
                <h2>Customer Service</h2>
                <ul>
                    <li>
                        <span><i class="fa-regular fa-clock"></i></span>
                        <p>
                            9:00 a.m. to 10:00 p.m.
                        </p>
                    </li>
                </ul>
            </div>
            <div class="footer_width contact" id="contact_info">
                <h2>Contact Info</h2>
                <ul>
                    <li>
                        <span><i class="fa-regular fa-envelope"></i></span>
                        <p>
                            sakuRa@gmail.com
                        </p>
                    </li>
                    <li>
                        <span><ion-icon name="call-outline"></ion-icon></span>
                        <p>
                            +60-182129139
                        </p>
                    </li>
                    <li>
                        <span><ion-icon name="location-outline"></ion-icon></span>
                        <p>
                            8, Lorong Ciku 5, Taman Mas Baru, 30100 Ipoh, Perak
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copy-right">
            <p>
                ©2023 | BookishHub®
            </p>
        </div>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>