<?php
include_once("dbconnect.php");
include "menu.php";

/*if (isset($_GET['submit'])) {
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
$rows = $stmt->fetchAll();*/

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
        .footer_info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
            justify-items: center;
            align-items: flex-start;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
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