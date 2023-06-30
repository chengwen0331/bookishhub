<?php
include_once("dbconnect.php");
include "menu.php";

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
     $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
}
else{
   echo "<script>alert('Please login or register')</script>";
   echo "<script> window.location.replace('login.php')</script>";
}
$sqlcart = "SELECT * FROM tbl_carts WHERE user_email = '$useremail'";
$stmt = $conn->prepare($sqlcart);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
if ($number_of_rows>0){
   if (isset($_GET['submit'])) {
    if ($_GET['submit'] == "add"){
        $bookid = $_GET['bookid'];
        $qty = $_GET['qty'];
        $cartqty = $qty + 1 ;
        $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND book_id = '$bookid'";
        $conn->exec($updatecart);
        echo "<script>alert('Cart updated')</script>";
    }
    if ($_GET['submit'] == "remove"){
        $bookid = $_GET['bookid'];
        $qty = $_GET['qty'];
        if ($qty == 1){
            $updatecart = "DELETE FROM `tbl_carts` WHERE user_email = '$useremail' AND book_id = '$bookid'";
            $conn->exec($updatecart);
            echo "<script>alert('Book removed')</script>";
        }
        else{
            $cartqty = $qty - 1 ;
            $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND book_id = '$bookid'";
            $conn->exec($updatecart);    
            echo "<script>alert('Removed')</script>";
        }        
    }
} 
}
else{
    echo "<script>alert('Your cart is currently empty')</script>";
    echo "<script> window.location.replace('index.php')</script>";
}

$stmtqty = $conn->prepare("SELECT * FROM tbl_carts INNER JOIN tbl_books ON tbl_carts.book_id = tbl_books.book_id WHERE tbl_carts.user_email = '$useremail'");
$stmtqty->execute();
$resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
$rowsqty = $stmtqty->fetchAll();
foreach ($rowsqty as $carts) {
   $carttotal = $carts['cart_qty'] + $carttotal;
}



?>

<!DOCTYPE html>
<html>
<title>Book Depo</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    .clickable-button {
        background-color: rgb(50,134,171);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        text-decoration: none;
        margin-bottom:10px;
        }
        .clickable-button:hover {
         background-color: rgb(0,50,100);
        }
        .clickable-button2 {
        color: black;
        margin-top:0px;
        cursor: pointer;
        width: 100%;
        text-decoration: none;
        }
        .clickable-button2:hover {
         color: rgb(0,50,100);
         text-decoration: underline;
        }
        .box{
            width:100%;
            align-items: center;
            margin-top:10px;
        }
        .remove-button{
            cursor:pointer;
            margin-right:10px;
        }
        .add-button{
            cursor:pointer;
            margin-left:10px;
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

<body>
    <div id="cartContent" class="w3-main w3-content w3-padding" style="max-width:1300px;margin-top:100px;">
        <div class="w3-container w3-center"><p style="font-size: 30px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Cart for <?php echo $user_name?> </p></div><hr>
        <div class="w3-grid-template">
             <?php
             
             $total_payable = 0.00;
                foreach ($rowsqty as $books){
                    $bookid = $books['book_id'];
                    $book_title = $books['book_title'];
                    $book_isbn = $books['book_isbn'];
                    $book_price = $books['book_price'];
                    $book_qty = $books['cart_qty'];
                    $book_total = $book_qty * $book_price;
                    $total_payable = $book_total + $total_payable;
                    echo "<div class='w3-center w3-padding-small' id='bookcard_$bookid'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small'><a href='book_details.php?bookid=$bookid'><img class='w3-container w3-image' 
                    src='images/$bookid.jpg' onerror='this.onerror=null; this.src='images/books/default.jpg';' style='min-height:240px'></a></div>
                    <b>$book_title</b><br>RM $book_price/unit<br><div class='box'>
                    <input type='button' class='remove-button' id='button_id' value='-' onClick='removeCart($bookid,$book_price);'>
                    <label id='qtyid_$bookid'>$book_qty</label>
                    <input type='button' class='add-button' id='button_id' value='+' onClick='addCart($bookid,$book_price);'></div>
                    <br>

                    <button class='w3-button w3-white w3-border w3-border-secondary w3-round-large' type='button' id='button-addon1' data-mdb-ripple-color='dark' style='margin-right: 10px;'>
                            <i class='fa fa-minus' style='display: flex; align-items: center; justify-content: center;'></i>
                        </button>
                        <input type='text' id='quantity-input' class='w3-input w3-center w3-border w3-border-secondary' placeholder='1' aria-label='Example text with button addon' aria-describedby='button-addon1' style='margin-right: 10px;' readonly>
                        <button class='w3-button w3-white w3-border w3-border-secondary w3-round-large' type='button' id='button-addon2' data-mdb-ripple-color='dark' style='display: flex; align-items: center; justify-content: center;'>
                            <i class='fa fa-plus'></i>
                    </button>
                    <b><label id='bookprid_$bookid'> Price: RM $book_total</label></b><br></div></div>";
                }
             ?>
        </div>
        <?php 
            echo "<div class='w3-container w3-padding w3-block w3-center'>
                <p><b><label id='totalpaymentid'>Total Amount Payable: RM $total_payable</label></b></p>
                <a href='payment_details.php?email=$useremail&amount=$total_payable' class='clickable-button'>
                    CHECKOUT
                    <i class='fas fa-arrow-right' style='color: #ffffff; margin-left: 5px;'></i>
                </a><br><br>
                <a href='booklist.php' class='clickable-button2'>Continue Shopping</a>
            </div>";
        ?>
    </div>
  <script>

function addCart(bookid, book_price) {
    jQuery.ajax({
        type: "GET",
        url: "mycartajax.php",
        data: {
            bookid: bookid,
            submit: 'add',
            bookprice: book_price,
        },
        cache: false,
        dataType: "json",
        success: function(response) {
            var res = JSON.parse(JSON.stringify(response));
            console.log(res.data.carttotal);
            if (res.status == "success") {
                var bookid = res.data.bookid;
                document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
                document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
                document.getElementById("qtyid_" + bookid).innerHTML = res.data.qty;
                document.getElementById("bookprid_" + bookid).innerHTML = "Price: RM " + res.data.bookprice;
                document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + res.data.totalpayable;
            } else {
                alert("Failed");
            }
        },
        error: function(xhr, status, error) {
            // Handle error here
            console.log(xhr.responseText);
        }
    });
}

function removeCart(bookid, book_price) {
    jQuery.ajax({
        type: "GET",
        url: "mycartajax.php",
        data: {
            bookid: bookid,
            submit: 'remove',
            bookprice: book_price,
        },
        cache: false,
        dataType: "json",
        success: function(response) {
            var res = JSON.parse(JSON.stringify(response));
            if (res.status == "success") {
                console.log(res.data.carttotal);
                if (res.data.carttotal == null || res.data.carttotal == 0) {
                    alert("Cart empty");
                    window.location.replace("index.php");
                } else {
                    var bookid = res.data.bookid;
                    document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
                    document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
                    document.getElementById("qtyid_" + bookid).innerHTML = res.data.qty;
                    document.getElementById("bookprid_" + bookid).innerHTML = "Price: RM " + res.data.bookprice;
                    document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + res.data.totalpayable;
                    console.log(res.data.qty);
                    if (res.data.qty == null) {
                        var element = document.getElementById("bookcard_" + bookid);
                        element.parentNode.removeChild(element);
                    }
                }
            } else {
                alert("Failed");
            }
        },
        error: function(xhr, status, error) {
            // Handle error here
            console.log(xhr.responseText);
        }
    });
}
</script>
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
<!--// <a href='mycart.php?useremail=$useremail&bookid=$bookid&qty=$book_qty&submit=remove' class='w3-btn w3-blue w3-round'>-</a>-->
<!--     // $book_qty-->
<!--     // <a href='mycart.php?useremail=$useremail&bookid=$bookid&qty=$book_qty&submit=add' class='w3-btn w3-blue w3-round'>+</a><br>-->