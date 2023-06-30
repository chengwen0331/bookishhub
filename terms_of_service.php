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
    <title>Terms of Service</title>
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
        p {
            display: block;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
        }
        .box-2{
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 80rem;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
        }
        .box-2 h2{
            top: -4rem;
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
        <div class="box-2">
                <h2>Terms of Service</h2>
                <div class="box-2-2">
                        <article>                           
                                    <p><strong>OVERVIEW</strong></p>
                                    <p>This website is operated by Bookish Hub. Throughout the site, the terms “we”, “us” and “our” refer to Bookish Hub. Bookish Hub offers this website, including all information, tools and services available from this site to you, the user, conditioned upon your acceptance of all terms, conditions, policies and notices stated here.</p>
                                    <p>By visiting our site and/ or purchasing something from us, you engage in our “Service” and agree to be bound by the following terms and conditions (“Terms of Service”, “Terms”), including those additional terms and conditions and policies referenced herein and/or available by hyperlink. These Terms of Service apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and/ or contributors of content.</p>
                                    <p>Please read these Terms of Service carefully before accessing or using our website. By accessing or using any part of the site, you agree to be bound by these Terms of Service. If you do not agree to all the terms and conditions of this agreement, then you may not access the website or use any services. If these Terms of Service are considered an offer, acceptance is expressly limited to these Terms of Service.</p>
                                    <p>Any new features or tools which are added to the current store shall also be subject to the Terms of Service. You can review the most current version of the Terms of Service at any time on this page. We reserve the right to update, change or replace any part of these Terms of Service by posting updates and/or changes to our website. It is your responsibility to check this page periodically for changes. Your continued use of or access to the website following the posting of any changes constitutes acceptance of those changes.</p><br>
                                    <p><strong>ONLINE STORE TERMS</strong></p>
                                    <p>By agreeing to these Terms of Service, you represent that you are at least the age of majority in your state or province of residence, or that you are the age of majority in your state or province of residence and you have given us your consent to allow any of your minor dependents to use this site.</p>
                                    <p>You may not use our products for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws).</p>
                                    <p>You must not transmit any worms or viruses or any code of a destructive nature. A breach or violation of any of the Terms will result in an immediate termination of your Services.</p><br>                                  
                                    <p><strong>GENERAL CONDITIONS</strong></p>
                                    <p>We reserve the right to refuse service to anyone for any reason at any time.</p>
                                    <p>You understand that your content (not including credit card information), may be transferred unencrypted and involve:</p> 
                                    <p>(a) transmissions over various networks; and</p> 
                                    <p>(b) changes to conform and adapt to technical requirements of connecting networks or devices.</p>
                                    <p>Credit card information is always encrypted during transfer over networks.</p>
                                    <p>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service or any contact on the website through which the service is provided, without express written permission by us.</p>
                                    <p>The headings used in this agreement are included for convenience only and will not limit or otherwise affect these Terms.</p><br>
                                    <p><strong>ACCURACY, COMPLETENESS AND TIMELINESS OF INFORMATION</strong></p>
                                    <p>We are not responsible if information made available on this site is not accurate, complete or current. The material on this site is provided for general information only and should not be relied upon or used as the sole basis for making decisions without consulting primary, more accurate, more complete or more timely sources of information. Any reliance on the material on this site is at your own risk.</p>
                                    <p>This site may contain certain historical information. Historical information, necessarily, is not current and is provided for your reference only. We reserve the right to modify the contents of this site at any time, but we have no obligation to update any information on our site. You agree that it is your responsibility to monitor changes to our site.</p><br>
                                    <p><strong>MODIFICATIONS TO THE SERVICE AND PRICES</strong></p>
                                    <p>Prices for our products are subject to change without notice.</p>
                                    <p>We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time.</p>
                                    <p>We shall not be liable to you or to any third-party for any modification, price change, suspension or discontinuance of the Service.</p><br>
                                    <p><strong>PRODUCTS OR SERVICES (if applicable)</strong></p>
                                    <p>Certain products or services may be available exclusively online through the website. These products or services may have limited quantities.</p>
                                    <p>We have made every effort to display as accurately as possible the colors and images of our products that appear at the store. We cannot guarantee that your computer monitor's display of any color will be accurate.</p>
                                    <p>We reserve the right, but are not obligated, to limit the sales of our products or Services to any person, geographic region or jurisdiction. We may exercise this right on a case-by-case basis. We reserve the right to limit the quantities of any products or services that we offer. All descriptions of products or product pricing are subject to change at anytime without notice, at the sole discretion of us. We reserve the right to discontinue any product at any time. Any offer for any product or service made on this site is void where prohibited.
                                        We do not warrant that the quality of any products, services, information, or other material purchased or obtained by you will meet your expectations, or that any errors in the Service will be corrected.</p><br>
                                    <p><strong>ACCURACY OF BILLING AND ACCOUNT INFORMATION</strong></p>
                                    <p>We reserve the right to refuse any order you place with us. We may, in our sole discretion, limit or cancel quantities purchased per person, per household or per order. These restrictions may include orders placed by or under the same customer account, the same credit card, and/or orders that use the same billing and/or shipping address. In the event that we make a change to or cancel an order, we may attempt to notify you by contacting the e-mail and/or billing address/phone number provided at the time the order was made. We reserve the right to limit or prohibit orders that, in our sole judgment, appear to be placed by dealers, resellers or distributors.</p>
                                    <p>You agree to provide current, complete and accurate purchase and account information for all purchases made at our store. You agree to promptly update your account and other information, including your email address and credit card numbers and expiration dates, so that we can complete your transactions and contact you as needed.</p><br>
                                    <p><strong>OPTIONAL TOOLS</strong></p>
                                    <p>We may provide you with access to third-party tools over which we neither monitor nor have any control nor input.</p>
                                    <p>You acknowledge and agree that we provide access to such tools ”as is” and “as available” without any warranties, representations or conditions of any kind and without any endorsement. We shall have no liability whatsoever arising from or relating to your use of optional third-party tools.</p>
                                    <p>Any use by you of optional tools offered through the site is entirely at your own risk and discretion and you should ensure that you are familiar with and approve of the terms on which tools are provided by the relevant third-party provider(s).</p>
                                    <p>We may also, in the future, offer new services and/or features through the website (including, the release of new tools and resources). Such new features and/or services shall also be subject to these Terms of Service.</p><br>
                                    <p><strong>THIRD-PARTY LINKS</strong></p>
                                    <p>Certain content, products and services available via our Service may include materials from third-parties.</p>
                                    <p>Third-party links on this site may direct you to third-party websites that are not affiliated with us. We are not responsible for examining or evaluating the content or accuracy and we do not warrant and will not have any liability or responsibility for any third-party materials or websites, or for any other materials, products, or services of third-parties.</p>
                                    <p>We are not liable for any harm or damages related to the purchase or use of goods, services, resources, content, or any other transactions made in connection with any third-party websites. Please review carefully the third-party's policies and practices and make sure you understand them before you engage in any transaction. Complaints, claims, concerns, or questions regarding third-party products should be directed to the third-party.</p><br>
                                    <p><strong>USER COMMENTS, FEEDBACK AND OTHER SUBMISSIONS</strong></p>
                                    <p>If, at our request, you send certain specific submissions (for example contest entries) or without a request from us you send creative ideas, suggestions, proposals, plans, or other materials, whether online, by email, by postal mail, or otherwise (collectively, 'comments'), you agree that we may, at any time, without restriction, edit, copy, publish, distribute, translate and otherwise use in any medium any comments that you forward to us. We are and shall be under no obligation</p> 
                                    <p>(1) to maintain any comments in confidence;</p> 
                                    <p>(2) to pay compensation for any comments; or</p> 
                                    <p>(3) to respond to any comments.</p>
                                    <p>We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms of Service.</p>    
                                    <p>You agree that your comments will not violate any right of any third-party, including copyright, trademark, privacy, personality or other personal or proprietary right. 
                                        You further agree that your comments will not contain libelous or otherwise unlawful, abusive or obscene material, or contain any computer virus or other malware that could in any way affect the operation of the Service or any related website. You may not use a false e-mail address, pretend to be someone other than yourself, or otherwise mislead us or third-parties as to the origin of any comments. You are solely responsible for any comments you make and their accuracy. We take no responsibility and assume no liability for any comments posted by you or any third-party.</p><br>
                                    <p><strong>PERSONAL INFORMATION</strong></p>
                                    <p>Your submission of personal information through the store is governed by our Privacy Policy. To view our Privacy Policy.</p><br>
                                    <p><strong>ERRORS, INACCURACIES AND OMISSIONS</strong></p>
                                    <p>Occasionally there may be information on our site or in the Service that contains typographical errors, inaccuracies or omissions that may relate to product descriptions, pricing, promotions, offers, product shipping charges, transit times and availability. </p>
                                    <p>We reserve the right to correct any errors, inaccuracies or omissions, and to change or update information or cancel orders if any information in the Service or on any related website is inaccurate at any time without prior notice (including after you have submitted your order).</p>
                                    <p>We undertake no obligation to update, amend or clarify information in the Service or on any related website, including without limitation, pricing information, except as required by law. </p>
                                    <p>No specified update or refresh date applied in the Service or on any related website, should be taken to indicate that all information in the Service or on any related website has been modified or updated.</p><br>
                                    <p><strong>PROHIBITED USES</strong></p>
                                    <p>In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the site or its content: </p>
                                    <p>(a) for any unlawful purpose;</p>
                                    <p>(b) to solicit others to perform or participate in any unlawful acts; </p>
                                    <p>(c) to violate any international, federal, provincial or state regulations, rules, laws, or local ordinances; </p>
                                    <p>(d) to infringe upon or violate our intellectual property rights or the intellectual property rights of others;</p>
                                    <p>(e) to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability;</p>
                                    <p>(f) to submit false or misleading information;</p>
                                    <p>(g) to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related website, other websites, or the Internet;</p>
                                    <p>(h) to collect or track the personal information of others; (i) to spam, phish, pharm, pretext, spider, crawl, or scrape;</p>
                                    <p>(j) for any obscene or immoral purpose; or</p>
                                    <p>(k) to interfere with or circumvent the security features of the Service or any related website, other websites, or the Internet.</p>
                                    <p>We reserve the right to terminate your use of the Service or any related website for violating any of the prohibited uses.</p><br>
                                    <p><strong>DISCLAIMER OF WARRANTIES; LIMITATION OF LIABILITY</strong></p>
                                    <p>We do not guarantee, represent or warrant that your use of our service will be uninterrupted, timely, secure or error-free.</p>
                                    <p>We do not warrant that the results that may be obtained from the use of the service will be accurate or reliable.</p>
                                    <p>You agree that from time to time we may remove the service for indefinite periods of time or cancel the service at any time, without notice to you.</p>
                                    <p>You expressly agree that your use of, or inability to use, the service is at your sole risk. The service and all products and services delivered to you through the service are (except as expressly stated by us) provided 'as is' and 'as available' for your use, without any representation, warranties or conditions of any kind, either express or implied, including all implied warranties or conditions of merchantability, merchantable quality, fitness for a particular purpose, durability, title, and non-infringement.</p>
                                    <p>In no case shall Bookish Hub, our directors, officers, employees, affiliates, agents, contractors, interns, suppliers, service providers or licensors be liable for any injury, loss, claim, or any direct, indirect, incidental, punitive, special, or consequential damages of any kind, including, without limitation lost profits, lost revenue, lost savings, loss of data, replacement costs, or any similar damages, whether based in contract, tort (including negligence), strict liability or otherwise, arising from your use of any of the service or any products procured using the service, 
                                        or for any other claim related in any way to your use of the service or any product, including, but not limited to, any errors or omissions in any content, or any loss or damage of any kind incurred as a result of the use of the service or any content (or product) posted, transmitted, or otherwise made available via the service, even if advised of their possibility. Because some states or jurisdictions do not allow the exclusion or the limitation of liability for consequential or incidental damages, in such states or jurisdictions, our liability shall be limited to the maximum extent permitted by law.</p><br>
                                    <p><strong>INDEMNIFICATION</strong></p>
                                    <p>You agree to indemnify, defend and hold harmless Bookish Hub and our parent, subsidiaries, affiliates, partners, officers, directors, agents, contractors, licensors, service providers, subcontractors, suppliers, interns and employees, harmless from any claim or demand, including reasonable attorneys’ fees, made by any third-party due to or arising out of your breach of these Terms of Service or the documents they incorporate by reference, or your violation of any law or the rights of a third-party.</p><br>
                                    <p><strong>SEVERABILITY</strong></p>
                                    <p>In the event that any provision of these Terms of Service is determined to be unlawful, void or unenforceable, such provision shall nonetheless be enforceable to the fullest extent permitted by applicable law, and the unenforceable portion shall be deemed to be severed from these Terms of Service, such determination shall not affect the validity and enforceability of any other remaining provisions.</p><br>
                                    <p><strong>TERMINATION</strong></p>
                                    <p>The obligations and liabilities of the parties incurred prior to the termination date shall survive the termination of this agreement for all purposes.</p>
                                    <p>These Terms of Service are effective unless and until terminated by either you or us. You may terminate these Terms of Service at any time by notifying us that you no longer wish to use our Services, or when you cease using our site.</p>
                                    <p>If in our sole judgment you fail, or we suspect that you have failed, to comply with any term or provision of these Terms of Service, we also may terminate this agreement at any time without notice and you will remain liable for all amounts due up to and including the date of termination; and/or accordingly may deny you access to our Services (or any part thereof).</p><br>
                                    <p><strong>ENTIRE AGREEMENT</strong></p>
                                    <p>The failure of us to exercise or enforce any right or provision of these Terms of Service shall not constitute a waiver of such right or provision.</p>
                                    <p>These Terms of Service and any policies or operating rules posted by us on this site or in respect to The Service constitutes the entire agreement and understanding between you and us and govern your use of the Service, superseding any prior or contemporaneous agreements, communications and proposals, whether oral or written, between you and us (including, but not limited to, any prior versions of the Terms of Service).</p>
                                    <p>Any ambiguities in the interpretation of these Terms of Service shall not be construed against the drafting party.</p><br>
                                    <p><strong>GOVERNING LAW</strong></p>
                                    <p>These Terms of Service and any separate agreements whereby we provide you Services shall be governed by and construed in accordance with the laws of Malaysia.</p><br>
                                    <p><strong>CHANGES TO TERMS OF SERVICE</strong></p>
                                    <p>You can review the most current version of the Terms of Service at any time at this page.
                                        We reserve the right, at our sole discretion, to update, change or replace any part of these Terms of Service by posting updates and changes to our website. It is your responsibility to check our website periodically for changes. Your continued use of or access to our website or the Service following the posting of any changes to these Terms of Service constitutes acceptance of those changes.</p><br>
                                    <p><strong>CONTACT INFORMATION</strong></p>
                                    <p>Questions about the Terms of Service should be sent to us at&nbsp;<a href="mailto:bookishhubb@gmail.com">bookishhubb@gmail.com</a>.</p>
                        </article>  
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