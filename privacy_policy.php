<?php
include_once("dbconnect.php");
include "menu.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
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
            padding-bottom: 2.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
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
            padding-top: 2rem;           
            margin-top: 3rem;
        }
        .text-center{
            text-align: center;
        }
        .box-1{
            padding-top: 0.5rem;
            overflow: hidden;
        }
        .box-1-1{
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 64rem;
            margin-left: auto;
            margin-right: auto;
        }
        .box-1-1 h2{
            
            font-size: 2.25rem;
            line-height: 2.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
            margin-left: auto;
            margin-right: auto;
        }
        .contain-text{
            font-size: 1rem;
            line-height: 1.5rem;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        .contain-text p{
            margin-top: 0;
            font-size: 1rem;
            line-height: 1.5rem;
            margin-bottom: 1.25rem;
            margin: 0;
        }
        .p1{
            font-size: 1rem;
            line-height: 1.5rem;
            margin-top: 1.25rem;
            margin-bottom: 1.25rem;
            margin: 0;
            font-weight: 500;
        }
        .contain-text ul{
            margin-bottom: 0;
            text-align: left;
            padding-left: 2.8rem;
            list-style-type: disc;
            margin-top: 1.25rem;
            list-style: none;
            margin: 0;
            
        }
        .contain-text ul li{
            margin-bottom: 0.5rem;
            display: list-item;
            list-style-type: circle;
        }
        .contain-text ul li a{
            text-decoration-line: none;
            font-weight: 500;
            text-decoration: inherit;
            cursor: pointer;
            color: rgb(24, 76, 233);
        }
        .contain-text ul li a:hover(){
            border:2px solid whitesmoke;
            transition: 0.5s;
            border-radius: 15px;
            color: blue;
            text-decoration: underline;
        }
        .box-2{
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 64rem;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
        }
        .box-2 h2{
            width: 100%;
            display: block;
            font-weight: 700;
            font-size: 2.25rem;
            line-height: 2.5rem;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        @media (min-width: 760px){
            .box-2 h2 {
                width: 66.666667%;
            }
        }
        .box-2-2{
            gap: 2rem;
            flex-direction: column;
            display: flex;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            font-size: 1rem;
            line-height: 1.5rem;
            text-align: justify;
        }
        .box-2-2 p{
            font-size: 1rem;
            line-height: 1.5rem;
            margin-top: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .box-2-2 a{
            color: rgb(24, 76, 233);
            text-decoration: underline;
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
    <div class="contain">
        <div class="top_title">
            <div class="title_box">
                <h1 class="title">Privacy Policy</h1>
                <p class="text-center"></p>
            </div>
        </div>
        <div class="box-1">
            <div class="box-1-1">
                <h2>Privacy Statement for Bookish Hub</h2>
                <div class= "contain-text">
                    <p><strong>Bookish Hub is committed to safeguarding your privacy online. Please read the following policy to understand how your personal information will be treated when you use or register on the Bookish Hub site.</strong></p><br>
                    <p class="p1">What this policy covers:</p><br>
                    <ul>
                        <li><a href="#q1">What personally identifiable information is collected from you</a></li>
                        <li><a href="#q2">What does Bookish Hub COMPONENTS do to protect your personal data online?</a></li>
                        <li><a href="#q3">What cookies are and how they are used</a></li>
                        <li><a href="#q4">How your information is used</a></li>
                        <li><a href="#q5">Who is collecting your information</a></li>
                        <li><a href="#q6">With whom your information may be shared</a></li>
                        <li><a href="#q7">What are my choices regarding collection, use, and distribution of my information?</a></li>
                        <li><a href="#q8">How you can access, update or delete your information</a></li>
                     </ul>
                </div>
            </div>
        </div>
        <div class="box-2">
                <h2>What personal information does Bookish Hub collect?</h2>
                <div class="box-2-2">
                        <article>                           
                                <p style="font-size: 1rem; line-height: 1.5rem; margin-bottom: 1.25rem"><strong id="q1">What personal information does Bookish Hub collect from me?</strong></p>
                                    <p>Bookish Hub collects information in several ways:</p>
                                    <p>Some personal information is gathered when you register, During registration, Bookish Hub asks you for a Username, Password, Security Password, your name, telephone number, email address, address.</p>
                                    <p>We may also record some details of how you use the site, such as adverts you click on, products you search for and products you purchase. If you accessed this site following a search on the internet, we may record the search you undertook and how it relates to your use of this site.</p>
                                    <p>We may keep copies of information you submit when you send email feedback to the site, ask a technical question, or report a problem. If you contact Bookish Hub in writing we may keep a record of that correspondence. Bookish Hub also occasionally asks users to complete surveys that we use for research purposes.</p>
                                    <p id="q2"><strong>What does Bookish Hub do to protect your personal data online?</strong></p>
                                    <p>Bookish Hub Components always aim to deliver the highest level of service and security to our customers and Bookish Hub has been specifically designed with security in mind.</p>
                                    <p>In order to ensure the security and protection of your personal details whenever you submit any sensitive information such as credit card number and account details, we use the following security methods:</p>
                                    <p>128 bit Secure Sockets Layer (SSL) encryption - the latest technology to encode and protect your data - which is your guarantee for a safe and secure transaction.</p>
                                    <p>The Bookish Hub VeriSign Security Guarantee pops up whenever you submit sensitive information as an indication that the current information will be encrypted. This means that your information is protected and safe to submit.</p>
                                    <p>Sensitive credit card information stored on our in-house systems is also held in encrypted format.</p>
                                    <p>Your Bookish Hub Online Account Information and Bookish Hub Online Personal Profile are password-protected so that you and only you have access to this personal information. You may edit your RS Online Account Information and Bookish Hub Online Personal Profile by using your Bookish Hub user name and password and by clicking on the Update My Details button on your home page navigation bar. We recommend that you do not divulge your password to anyone. Bookish Hub will never ask you for your password in an unsolicited phone call or in an unsolicited email.</p>
                                    <p id="q3"><strong>What are cookies and how does Bookish Hub use them?</strong></p>
                                    <p>If you log-in to the site using a Username and Password, your browser may alert you to the fact that a cookie is being sent to your PC. This is a permanent cookie and is used the next time you visit Bookish Hub. It identifies you to our server so that we can display web pages which are more relevant to your needs.</p>
                                    <p>If you use the InfoZone on the site to locate and download data sheets, your browser may again alert you to the fact that a cookie is being sent. This will not be stored on your hard drive. It's purpose is merely to identify you to the data sheet server for the time you are using it. Once you have finished using the server, this cookie will be deleted.</p>
                                    <p>If you accessed this site following a search on the internet, your browser may again alert you to the fact that a cookie is being sent. This cookie will be stored on your hard drive. The purpose of the cookie is to monitor the effectiveness of the keywords we submit to search engines on the internet and to better understand and serve our users as described in&nbsp;<a href="#q4">How does Bookish Hub use my information?</a></p>
                                    <p id="q4"><strong>How does Bookish Hub use my information?</strong></p>
                                    <p>Bookish Hub uses your information for the purposes of order fulfilment, occasional direct marketing activities (see&nbsp;<a href="#q7">What are my choices regarding collection, use and distribution of my information?</a>), for the administration of prize draws and competitions you may enter, and to provide you with customised and relevant information on your home page when you visit the site.</p>
                                    <p>Bookish Hub also does research on our users' demographics, interests, and behaviour. We do this to better understand and serve our users and to review, develop and improve the products and services we offer.</p>
                                    <p id="q5"><strong>Who is collecting information?</strong></p>
                                    <p>Bookish Hub Components Pte Ltd, a member of a world-wide Group of companies of which Electrocomponents plc is the parent company, collects your information via the Bookish Hub web site or through cookies. Bookish Hub Components Pte Ltd will not retain your personal data when there is no longer any business or legal purpose for doing so and will use appropriate measures to dispose or render such information non-personally identifiable in nature.</p>
                                    <p id="q6"><strong>With whom does Bookish Hub share my information?</strong></p>
                                    <p>Bookish Hub Components Pte Ltd is a member of a world-wide Group of companies of which Electrocomponents plc is the parent company. Bookish Hub Components Pte Ltd may share information collected about you via the Bookish Hub web site with other members of this Group . Where the sharing of information with other members of the Group involves a transfer of your information overseas, the recipient is either located in a country or under an enforceable legal obligation to Bookish Hub Components Pte Ltd (or the Group as a whole) to ensure that the standard of protection is comparable to the protection under the PDPA. The members of this Group never sell, rent, or give away information that personally identifies customers to third parties except where elements of the business have been outsourced and the provision of such information is required for the provision of the service to you. Under such circumstances, the security and confidentiality of personal information would form a part of the legal agreement between us and the supplier. From time to time, we may release aggregated and anonymised marketing statistics to business partners, or may use these in press releases, advertising, or published reports. We would only personally identify you or any other customer in such press releases, advertising, or reports with your prior consent. Bookish Hub Components Pte Ltd may also disclose user information in special cases when we have reason to believe that disclosing this information is necessary to identify, contact or bring legal action against someone who may be causing injury to or interference with (either intentionally or unintentionally) Bookish Hub Components' rights or property, other Bookish Hub users, or anyone else that could be harmed by such activities. In addition, Bookish Hub Components Pte Ltd may disclose user information when the law requires it.</p>
                                    <p id="q7"><strong>What are my choices regarding collection, use, and distribution of my information?</strong></p>
                                    <p>Bookish Hub may, from time to time, send you email regarding our products and About Bookish Hub. In addition, we may occasionally send you direct mail about products and About Bookish Hub that we feel may be of interest to you. Only Bookish Hub or its agents will send you these direct mailings.</p>
                                    <p>If you do not wish to receive details of these other offers then please contact the Marketing Department of Bookish Hub Components Pte Ltd by faxing it to +60198745632 or sending via email to&nbsp;<a href="mailto:bookishhubb@gmail.com">bookishhubb@gmail.com</a>.</p>
                                    <p id="q8"><strong>What is Bookish Hub Online's policy on allowing me to update, correct, or delete my personally identifiable information?</strong></p>
                                    <p>You may access, correct or update your Personal Profile information at any time by clicking on the Update My Details button on your home page navigation bar. If you have forgotten your password, or have any other problems accessing the site, please contact the Bookish Hub HelpDesk on +60198745632.</p>
                                    <p>If you have forgotten your password, or have any other problems accessing the site, please contact the Marketing Department of Bookish Hub Components Pte Ltd by faxing it to +60198745632 or sending via email to&nbsp;<a href="mailto:bookishhubb@gmail.com">bookishhubb@gmail.com</a>.</p>
                                    <p>However, please note that should you edit or delete your personal information it may no longer be possible to provide you with information, notices, services and/or products requested; your ability to enter and participate in any contests or promotions organised by us may be affected; and the ability of third parties to enter into the necessary agreements in relation to the provision of services to you may also be affected.</p>
                                    <p><strong>Additional Information</strong></p>
                                    <p>You may contact Bookish Hub Components Pte Ltd at any time (a) to disclose all the information that it has collected about you, as well as the purposes for which such information had been used or disclosed in the preceding year, (b) request that we specify or explain our policies and procedures in relation to the information collected, used and disclosed by us; (c) withdraw, in full or in part, your consent given previously or request deletion of your information, in each case subject to any applicable legal restrictions, contractual conditions and a reasonable time period. Please note, however, that we may still be entitled to process your information if we have another legitimate reason (other than consent) for doing so; and (d) lodge a complaint with the competent authority if you think that any of your rights have been infringed by us.</p>
                                    <p>Questions regarding this policy or your information should be directed to the Marketing Department with the following contact details:</p>
                                    <p>Bookish Hub Components Pte Ltd.</p>
                                    <p>Tel:&nbsp;+60198745632 (Mon-Fri 9am-6pm)
                                    Email:&nbsp;<a href="mailto:bookishhubb@gmail.com">bookishhubb@gmail.com</a></p>
                                    <p><strong>Changes to our Privacy Policy</strong></p>
                                    <p>Bookish Hub Components Pte Ltd may occasionally change all or part of this privacy policy. Any changes will be effective immediately upon our posting of the updated privacy policy. If we make any material changes to this privacy policy, we will notify you of the changes through our website or e-mail. If we make changes to the type of information collected, the purpose for collecting your information, who we may share your information with, or how we may use your information, we will notify you in advance of such changes request your consent if required.</p>
                            
                        </article>  
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>      
</body>
</html>