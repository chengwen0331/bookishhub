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
    <title>FAQs</title>
    <link rel="shortcut icon" type="image/jpeg" href="images/logo1.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
            color:black;
        }
        body{
            background-color: rgb(250, 251, 253);
        }
        div {
            display: block;
        }
        @media (min-width: 760px){
            .contain {
                width: 66.666667%;
            }
        }
        .contain{
            width: 100%;
            margin: 10px;
            padding: 60px 12%;
        }
        .top_title {
            
            padding-bottom: 1.25rem;
            display: flex;
            margin: auto;
        }
        .title_box {
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 80rem;
            margin-left: auto;
            margin-right: auto;
        }
        .title {
            font-weight: 600;
            font-size: 2.25rem;       
            text-align: center;           
            margin-top: 3rem;
        }
        .text-center{
            text-align: center;
        }
        p {
            display: block;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
        }
        .site_content {
            padding-bottom: 38px;
            padding-top: 38px;
        }
        .box{
            max-width: 1200px;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        .section-row{
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .content-area{
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        .entry_content:before,
        .entry_content:after,
        .site_content:before,
        .site_content:after{
            content: "";
            display: table;
            table-layout: fixed;
        }
        .custom_row{
            margin-left: -15px;
            margin-right: -15px;
        }
        .custom_row:after, 
        .custom_row:before {
            content: " ";
            display: table;
        }
        .custom_column_box{
            padding-left: 0;
            padding-right: 0;
            position: relative;
            min-height: 1px;
            box-sizing: border-box;
            width: 100%;
        }
        .custom_column-inner{
            box-sizing: border-box;
            padding-left: 15px;
            padding-right: 15px;
            width: 100%;
        }
        .custom_column-inner::after, .vc_column-inner::before {
            content: " ";
            display: table;
        }
        .content-element{
            margin-bottom: 35px;
        }
        .wrapper_element.hidden {
            display: none;
        }
        p {
            margin: 0 0 1.5em;
            padding: 0;
            font-weight: 400;
            font-style: normal;
            font-size: 14px;
        }
        .box-element{
            margin-bottom: 35px;
        }
        .content-card{
            border-top-width: 1px;
            border-bottom-width: 1px;
            border-left-width: 1px;
            border-right-width: 1px;
            border-style: solid;
            border-color: #e9e9e9;
            border-radius: 0;
            margin-bottom: 0.6em;
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0,0,0,.125);
        }
        .content-card-header{
            border-bottom-width: 1px;
            border-bottom-style: solid;
            border-bottom-color: #e9e9e9;
            margin-bottom: -1px;
            text-align: left;
            padding: 0;
        }
        .content-card-title{
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            line-height: 1.4;
        }
        .content-card-header a:not(.collapsed) {
            background-color: #f8f8f8;
        }
        .content-card-header a {
            display: block;
            border: none;
            cursor: pointer;
            padding: 12px 20px;
            position: relative;
        }
        .content-card-body p{
            padding-left: 1.3rem;
            padding-right: 1.3rem;
            padding-top: 1rem;
            padding-bottom: 0.8rem;
            text-align: justify;
            font-size: 16px;
            line-height: 30px;
        }
        .content-card-link {
            text-decoration: none; 
            color: #000000; 
        }
        .content-card-link:hover{
            color: #2370F4;
        }
        @media (max-width: 640px){
            .custom_row.wpb_row {
                padding-left: 0 !important;
                padding-right: 0 !important;
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
        .copy_right {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
        }
        .copy_right p{
            font-size:20px;
        }
    </style>
</head>
<body>
<div class="contain">
        <div class="top_title">
            <div class="title_box">
                <h1 class="title">Frequently Asked Questions</h1>
                <p class="text-center"></p>
            </div>
        </div>
        <div id="main_content" class="site_content">						
			<div class="box">
				<div class="section-row">
                    <div class="content-area">
                        <article>	
                            <div class="entry_content">
	                            <div class="custom_row">
                                    <div class="custom_column_box">
                                        <div class="custom_column-inner">
                                            <div class="wrapper_element">
                                                <div class="content_element ">
                                                    <div class="wrapper_element">
                                                        <p>Please find answers to the most frequently asked questions below:</p>
                                                    </div>
                                                </div>
                                                <div class="box-element">
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link">Why do I need to register on the site before I can place an order?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>Establishing an online account assures you that your purchasing information is secure, confidential and accessible to you.<br>  Once you establish an account, you will only need to sign-in to place an order in the future, check on the status of your current order,  view past purchases or update your profile information.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">Are transactions safe?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>YES. Bookish Hub provides Internet security by hosting our site on a secure server. 
                                                                            No other company or organization shares the server we use to store information.
                                                                            It also create secure areas of the Web site for the transfer of confidential information such as your credit card number in our online bookstore. 
                                                                            When using Internet Explorer, for example, you'll know an area of the site is secure when you see a lock in the bottom left order of your screen.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">Do you sell audiobooks and / or ebooks?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>We do not currently have an ebook provider, but our hope is to develop and launch our own ebooks platform in the near future!</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">Does Bookish Hub share customer info with affiliates?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>We do not share our customer data with third parties. If customer orders from a bookstore’s shop page, the bookstore will be able to see the customer information.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">How do I notify you of changes to my mailing address and email address?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>If you wish to change any information on your customer profile, sign in, and you can update your information on your profile or contact us at +6019-8745632 or <a href="mailto:bookishhubb@gmail.com">bookishhubb@gmail.com</a>.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">How do I place an order on your online website?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>Please click the "Add to cart" button on the respective product page.<br>
                                                                            The shipping rate will be calculated automatically at checkout based on the total weight, shipping destination, and your choice of delivery option.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">How much is the shipping rate?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>The shipping rate will be calculated automatically at checkout based on the total weight, shipping destination, and your choice of delivery service.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">How will I know my order has been shipped?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>You will receive an email from the Don Bookstore when we have processed your order. You can also check your order status by logging in to your account from our website.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                                <a class="content-card-link" aria-expanded="false">Do you ship worldwide?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>Yes, we do, however, if you face any unusual issues to proceed, please contact our customer service at:<br>
    ◼️                                                                       Customer Service Enquiry Hotline: <span style="color: #3366ff;">
                                                                              <a style="color: #3366ff;" href="tel:+6019-8745632">+6019-8745632</a></span><br>
    ◼️                                                                       Email at: <span style="color: #3366ff;">
                                                                            <a style="color: #3366ff;" href="mailto:bookishhubb@gmail.com">bookishhubb@gmail.com</a></span>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" daria-expanded="false">Can I pay with PayPal? What are the payment methods that are accepted?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>Yes, we do accept payment methods via:<br>
    ◼️                                                                       Ipay88: Paypal, all major cards &amp; internet banking.<br>
    ◼️                                                                       Direct Bank Transfer: Please email us the payment slips.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">Can you deliver my purchase to another place?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>Yes, we deliver based on the delivery address, which can be different from the billing address. Do fill up the form correctly upon checkout.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">How long is your delivery time?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>We usually processed your order within 2 days after payment is received/confirmed. Then, the estimated delivery time* are:<br>
                                                                            ◼️ Locals(Malaysia): within 3 working days.<br>
                                                                            ◼️ Singapore: within 10 working days<br>
                                                                            ◼️ International: 15 to 45 working days.<br>                     
                                                                            All confirmed order before 10 am will be shipped out on the same day (MON, WED & FRI) EXCEPT for Weekend & Public Holiday.<br>                                                                           
                                                                           *However, the delivery time may differ, subjected to the courier companies.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">When will my order be posted out and where to find my tracking number?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>Your order will be processed and dispatched from our warehouse in 3 to 4 working days. This is the order processing duration. <br>
                                                                            You will receive a notification email / SMS once the tracking number is available. 
                                                                            Alternatively, you can click the "View your order" button in the order confirmation email to check the tracking number. 
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">What is my next course of action if my parcel is late?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>In case of late delivery, you may contact the courier service provider directly to file a report and actions will be taken to expedite the delivery.  
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                            <a class="content-card-link" aria-expanded="false">What is my next course of action if my parcel is lost?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>Bookish Hub is not responsible for lost merchandise during shipment by the postal/shipping delivery service provider. 
                                                                            However, we would provide assistance in claims of direct losses for missing items caused by delivery.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                                <a class="content-card-link" aria-expanded="false">What's the benefit of me creating an online account then?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>◼️ All your past & current orders are documented.<br>
                                                                            ◼️ You may re-download and view your ebooks within the website.<br>
                                                                            ◼️ Wishlist Cart <br>
                                                                            ◼️ You will be updated with our latest books, products, offers & sales. (via email)</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content-card">
                                                        <div class="content-card-header">
                                                            <h4 class="content-card-title">					
                                                                <a class="content-card-link" aria-expanded="false">Your site layout won't allow me to check out. What's wrong?</a>					
                                                            </h4>
                                                        </div>
                                                        <div>
                                                            <div class="content-card-body">
                                                                <div class="wpb_text_column wpb_content_element ">
                                                                    <div class="wrapper_element hidden">
                                                                        <p>If the layout of Bookish Hub is preventing you from placing your order, it can likely be solved by simply updating your browser.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
	                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom_row wpb_row custom_row-fluid">
                                    <div class="custom_column_box">
                                        <div class="custom_column-inner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
				</div>		
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
        <div class="copy_right">
            <p>
                Copyright © 2023 | BookishHub®
            </p>
        </div>
    </footer> 
    <script>
        const cardLinks = document.querySelectorAll('.content-card-link');
        let previousAnswerContainer = null;

        cardLinks.forEach((link) => {
            link.addEventListener('click', () => {
                const wrapper = link.closest('.content-card').querySelector('.wrapper_element');
                wrapper.classList.toggle('hidden');

                if (previousAnswerContainer && previousAnswerContainer !== wrapper) {
                    previousAnswerContainer.classList.add('hidden');
                }

                previousAnswerContainer = wrapper;

                const collapse = link.getAttribute('href');
                const answerContainer = document.querySelector(collapse);
                answerContainer.classList.toggle('show');
            });
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>