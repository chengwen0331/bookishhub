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
    <title>Contact Us</title>
    <link rel="shortcut icon" type="image/jpeg" href="images/logo1.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background-color: rgb(250, 251, 253);
        }
        .box{
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 65rem;
            margin-left: auto;
            margin-right: auto;
        }
        .contact-form{
            position: relative;
        }
        form{
            padding: 2.3rem 2.2rem;
            z-index: 10;
            overflow: hidden;
            position: relative;
        }
        .reason {
            position: relative;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .title{
            color:black;
            font-weight: 500;
            font-size: 2rem;
            line-height: 1;
            margin-bottom: 2rem;
            text-align: center;
        }
        .input-container{
            position: relative;
            margin: 1.5rem 0;
        }
        .input{
            width: 100%;
            outline:none;
            border:2px solid black;
            background: none;
            padding: 0.8rem 1.2rem;
            color:black;
            font-weight: 500;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            
            transition: 0.3s;
        }
        textarea.input{
            padding: 0.8rem 1.2rem;
            min-height: 150px;
            resize: none;
            overflow-y:auto;          
        }
        .input-container label{
            position: absolute;
            top:50%;
            left:15px;
            transform: translateY(-50%);
            padding: 0 0.4rem;
            color:black;
            font-size: 1rem;
            font-weight: 400;
            pointer-events: none;
            z-index: 1000;
            transition: 0.5s;
            font-weight: bold;
        }
        .input-container.textarea label{
            top:1rem;
            transform: translateY(0);
        }
        .input-container span{
            position: absolute;
            top:0;
            left:25px;
            transform: translateY(-50%);
            font-size: 0.8rem;
            padding:0 0.4rem;
            color:transparent;
            pointer-events: none;
            z-index: 500;
           
        }
        .input-container span:before, 
        .input-container span:after{
            content:"";
            position: absolute;
            width:10%;
            opacity: 0;
            transition: 0.3s;
            height: 5px;
            background-color: rgb(250, 251, 253);;
            top:50%;
            transform: translateY(-50%);
        }
        .input-container span:before{
            left:50%;
        }
        .input-container span:after{
            right:50%;
        }
        .input-container.focus label{
            top:0;
            transform: translateY(-50%);
            left:25px;
            font-size: 0.8rem;
        }
        .input-container.focus span:before, 
        .input-container.focus span:after{
            width:50%;
            opacity:1 ;
        }
        .field {
            position: relative;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        @media (max-width: 991px){
            .field label.field__label {
                font-size: 18px;
                line-height: 28px;
                margin-bottom: 10px;
            }
        }
        .field label.field__label {
            font-size: 1rem;
            line-height: 30px;
            padding-top: 0;
            text-transform: capitalize;
            display: block;
            width: 100%;
            font-weight: bold;
        }
        .fileinputs {
            position: relative;
            width: 100%;
        }
        .fileinputs .field__input {
            position: relative;
        }
        .field__input {
            border: 2px solid black;
            box-shadow: none;
            padding: 10px 15px;
            height: auto;
            font-size: 1rem;
            width: 100%;
            line-height: 1.5;
            letter-spacing: 0.04rem;
        }
        .fileinputs .field__input:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            font-weight: normal;
            font-size: 18px;
            line-height: 27px;
            color: #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        @media (max-width: 991px){
                .select_reason {
                    padding: 12px 40px 12px 20px;
                }
            }
            .select_reason {
                font-weight: 600;
                font-size: 16px;
                line-height: 22px;
                color: #11142D;
                background: rgb(250, 251, 253);
                border: 2px solid black;
                text-transform: capitalize;
                max-width: 340px;
                width: 100%;
                margin-bottom: 2px;
                margin-top: 7px;
                background-repeat: no-repeat;
                background-size: 16px;
                background-position: center right 24px;
                cursor: pointer;
                padding: 0.8rem 1.2rem;
                
            }
            option {
                font-weight: normal;
                display: block;
                min-height: 1.2em;
                padding: 0px 2px 1px;
            }
        .view-icon{
            background-image: url("images/email.png");
            background-size: cover;
            width: 40px;
            height: 40px;
            margin-right: 0.7rem;
            display: inline-block;
        }
        .view-icon1{
            background-image: url("images/phone.png");
            background-size: cover;
            width: 40px;
            height: 40px;
            margin-right: 0.7rem;
            display: inline-block;
        }
        .view-icon2{
            background-image: url("images/location.png");
            background-size: cover;
            width: 40px;
            height: 40px;
            margin-right: 0.7rem;
            display: inline-block;
        }
        .contact_info{
            padding: 2.3rem 2.2rem;
            position: relative;
        }
        .contact_info .title{
            color: black;
        }
        .view-information{
            display: flex;
            color:#555;
            margin:0.7rem 0;
            align-items: center;
            font-size: 0.95rem;
        }
        .clickable-btn{
            padding:0.8rem 2rem;
            background-color: rgb(67, 149, 184);
            border: 2px solid #fafafa;
            font-size: 1.2rem;
            color: white;
            outline: none;
            cursor: pointer;
            transition: 0.3s;
            margin:10px;
            font-weight: 600;
            position: relative;
            left: 35%;
        }
        .clickable-btn:hover{
            background-color: rgb(146, 187, 209);
            color:white;
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
            <div class="contact-form">
                <form action="">
                    <h3 class="title">Contact Us</h3>
                    <h3 style="font-size: 1.2rem;">Reason for Contact</h3>
                    <div class="reason">
                        <select id="-name" class="select_reason"><option value="Retail Enquiry">Retail Enquiry</option><option value="Book Enquiry">Book Enquiry</option><option value="Billing &amp; Payment Enquiry">Billing &amp; Payment Enquiry</option><option value="Shipping Enquiry">Shipping Enquiry</option><option value="Promo &amp; Discount Enquiry">Promo &amp; Discount Enquiry</option><option value="Order Enquiry">Order Enquiry</option><option value="Others">Others</option></select>
                    </div>
                    <div class="input-container">
                        <input type="text" name="name" class="input" required>
                        <label for="">Username</label>
                        <span>Username</span>
                    </div>
                    <div class="input-container">
                        <input type="email" name="email" class="input" required>
                        <label for="">Email</label>
                        <span>Email</span>
                    </div>
                    <div class="input-container">
                        <input type="tel" name="phone" class="input" required>
                        <label for="">Phone Number</label>
                        <span>Phone Number</span>
                    </div>
                    <div class="input-container textarea">
                        <textarea name="message" class="input"></textarea>
                        <label for="">Message/Request</label>
                        <span>Message/Request</span>
                    </div>
                    <p>
                        Please enter the details of your request. A member of our support staff will respond within the next 24 hours. 
                    </p><br>
                    <div class="field">
                        <label class="form__label field__label" for="attachment">Attachments</label>
                        <div class="fileinputs">
                          <input class="field__input" autocomplete="off" type="file" id="attachment" name="attachment" value="">
                          <p>**File size should not exceed 2MB</p>
                        </div>
      
                    </div>
                    <input type="submit" value="Send" class="clickable-btn">
                    <input type="reset" value="Reset" class="clickable-btn">
                </form>
            </div>
            <div class="contact_info">
                <h3 class="title">Contact Information</h3>
                <div class="view-info">
                    <div class="view-information">
                        <span class="view-icon"></span>
                        <p>bookishhubb@gmail.com</p>
                    </div>
                    <div class="view-information">
                        <span class="view-icon1"></span>
                        <p>+6019-8745632 (Customer Service Enquiry Hotline)</p>
                    </div>
                    <div class="view-information">
                        <span class="view-icon2"></span>
                        <p>8, Jalan 7/118b, Desa Tun Razak, 56000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
                    </div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1615.6980298764083!2d101.7188327824274!3d3.0775515341498823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc359b609f33b7%3A0x7e5b7e7100a0c859!2s8%2C%20Jalan%207%2F118b%2C%20Desa%20Tun%20Razak%2C%2056000%20Kuala%20Lumpur%2C%20Wilayah%20Persekutuan%20Kuala%20Lumpur!5e0!3m2!1sen!2smy!4v1687049320333!5m2!1sen!2smy" width="100%" height="350" style="border:2px solid black;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                    <li><a href="#">All</a></li>
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
        const inputs = document.querySelectorAll(".input");
        function focusFunc(){
            let parent = this.parentNode;
            parent.classList.add("focus");
        }
        function blurFunc(){
            let parent = this.parentNode;
            if(this.value == ""){
                parent.classList.remove("focus");
            }
        }
        inputs.forEach(input => {
            input.addEventListener("focus", focusFunc);
            input.addEventListener("blur", blurFunc);
        });
    </script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>