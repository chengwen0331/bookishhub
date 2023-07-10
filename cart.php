<?php
include_once("dbconnect.php");
include "menu.php";

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
} else {
    echo "<script>alert('Please login or register')</script>";
    echo "<script>window.location.replace('login.php')</script>";
    exit;
}

$sqlcart = "SELECT * FROM tbl_carts WHERE user_email = '$useremail'";
$stmt = $conn->prepare($sqlcart);
$stmt->execute();
$number_of_rows = $stmt->rowCount();

if ($number_of_rows <= 0) {
    echo "<script>alert('Your cart is currently empty')</script>";
    echo "<script>window.location.replace('index.php')</script>";
    exit;
}

$stmtqty = $conn->prepare("SELECT * FROM tbl_carts INNER JOIN tbl_books ON tbl_carts.book_id = tbl_books.book_id WHERE tbl_carts.user_email = '$useremail'");
$stmtqty->execute();
$rowsqty = $stmtqty->fetchAll(PDO::FETCH_ASSOC);
$carttotal = count($rowsqty);

function subString($str)
{
    if (strlen($str) > 20) {
        return $substr = substr($str, 0, 20) . '...';
    } else {
        return $str;
    }
}
?>

<!DOCTYPE html>
<html>
<title>Bookish Hub</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/jpeg" href="images/logo1.jpeg">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    body{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .clickable_button {
        background-color: rgb(50, 134, 171);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        max-width: 30%;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .clickable_button:hover {
        background-color: rgb(0, 50, 100);
    }

    .clickable_button2 {
        color: black;
        margin-top: 0px;
        cursor: pointer;
        width: 100%;
        text-decoration: none;
    }

    .clickable_button2:hover {
        color: rgb(0, 50, 100);
        text-decoration: underline;
    }

    .clickable_button3 {
        background-color: rgb(50, 134, 171);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 40%;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .clickable_button3:hover {
        background-color: rgb(0, 50, 100);
    }

    .box {
        width: 100%;
        align-items: center;
        margin-top: 10px;
    }

    .remove-button {
        cursor: pointer;
        margin-right: 10px;
    }

    .add-button {
        cursor: pointer;
        margin-left: 10px;
    }

    .carts{
        margin-left: 10px;
        margin-right: 10px;
        background-color: white;
        transition: all 0.3s;
    }
    .carts:hover{
        transform: scale(1.1);
        background-color: white;
        border: 1px solid #fff;
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
</style>

<body>
    <div class="w3-main w3-content w3-padding" style="max-width:1300px;margin-top:50px;">
        <div class="w3-container w3-center">
            <p style="font-size: 30px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Cart for <?php echo $user_name ?> </p>
        </div>
        <hr>
        <div class="w3-grid-template">
            <?php

            $total_payable = 0.00;
            foreach ($rowsqty as $books) {
                $bookid = $books['book_id'];
                $book_title = subString($books['book_title']);
                $book_isbn = $books['book_isbn'];
                $book_price = $books['book_price'];
                $book_qty = $books['cart_qty'];
                $book_total = $book_qty * $book_price;
                $total_payable += $book_total;
                $carttotal += $book_qty;
                echo "<div class='w3-center w3-padding-small' id='bookcard_$bookid'><div class='w3-card w3-round-large carts'>
                    <div class='w3-padding-small'><a href='bookdetails.php?bookid=$bookid'><img class='w3-container w3-image' 
                    src='images/books/$bookid.jpg' onerror=\"this.onerror=null; this.src='images/books/default.jpg';\" style='min-height:240px; margin-top:10px;'></a></div>
                    <b><span style='font-size: 18px;' class='book-title'><a href='bookdetails.php?bookid=$bookid'>$book_title</a></span></b><br>RM " . number_format($book_price, 2) . " / unit<br>
                    <div class='box'>
                        <input type='button' class='w3-button w3-white w3-border w3-border-secondary w3-round-large remove-button' id='button_id' value='-' onClick='removeCart($bookid,$book_price);'>
                        <label id='qtyid_$bookid'>$book_qty</label>
                        <input type='button' class='add-button w3-button w3-white w3-border w3-border-secondary w3-round-large' id='button_id' value='+' onClick='addCart($bookid,$book_price);'>
                    </div>
                    <div style='margin-top: 10px;'>
                        <b><label id='bookprid_$bookid' style='margin-bottom: 15px;'> Price: RM" . number_format($book_total, 2) ."</label></b>
                    </div>
                    <div style='margin-top: 5px;'>
                        <p><label class ='clickable_button3' onClick='deleteCart($bookid,$book_price);'><i class='fa-solid fa-trash-can' style='cursor: pointer; color: white;' onClick='deleteCart($bookid,$book_price);'></i></label></p>
                    </div>
                    <div style='margin-bottom: 20px'></div>
                </div></div>";
            }
            ?>
        </div>
        <?php
        echo "<div class='w3-container w3-padding w3-block w3-center'>
                <p><b><label id='totalpaymentid' style='margin-top:20px; margin-bottom:20px; font-size: 22px;'>Total Amount Payable: RM" . number_format( $total_payable, 2) ."</label></b></p>
                <a href='payment_details.php?email=$useremail&amount=$total_payable&quantity=$$book_qty'>
                <p><label class='clickable_button'>Check Out<i class='fas fa-arrow-right' style='margin-left: 5px;'></i></label></p>
                </a>
                <a href='booklist.php' class='clickable_button2' style='font-size:16px;'>Continue Shopping</a>
            </div>";
        ?>

        <script>

function addCart(bookid, book_price) {
    // Update the quantity label on the frontend immediately
    const qtyLabel = document.getElementById("qtyid_" + bookid);
    const currentQuantity = parseInt(qtyLabel.innerHTML);
    const newQuantity = currentQuantity + 1;
    qtyLabel.innerHTML = newQuantity;

    // Perform the AJAX request to update the cart on the backend
    jQuery.ajax({
        method: "GET",
        url: "mycartajax.php",
        data: "bookid=" + bookid + "&submit=add&bookprice=" + book_price,
        cache: false,
        dataType: "json",
        success: function(response) {
            console.log(response);
            if (response.status === "success") {
                // Check if the added quantity exceeds the quantity available
                const quantityAvailable = response.data.quantityAvailable[bookid];
                if (newQuantity > quantityAvailable) {
                    alert("Quantity exceeds availability");
                    // Update the quantity label on the frontend back to the previous value
                    qtyLabel.innerHTML = currentQuantity;
                } else {
                    // Update other elements on the frontend if needed
                    document.getElementById("cartTotal").innerHTML = response.data.carttotal;
                    document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + response.data.totalpayable;
                    document.getElementById("bookprid_" + bookid).innerHTML = "Price: RM " + response.data.booktotal[bookid];
                }
            } else {
                alert("Failed");
                // Update the quantity label on the frontend back to the previous value
                qtyLabel.innerHTML = currentQuantity;
            }
        },
        error: function(xhr, status, error) {
            // Handle error here
            console.log(xhr.responseText);
        }
    });
}


function removeCart(bookid, book_price) {
    // Update the quantity label on the frontend immediately
    const qtyLabel = document.getElementById("qtyid_" + bookid);
    const currentQty = parseInt(qtyLabel.innerHTML);
    
    if (currentQty > 1) {
        qtyLabel.innerHTML = currentQty - 1;
    } else if (currentQty === 1) {
        // Remove the item from the cart
        qtyLabel.innerHTML = ""; // Remove the quantity label
        qtyLabel.parentNode.parentNode.remove();
        window.location.replace("cart.php");
         // Remove the item row from the cart table
    }

    // Perform the AJAX request to update the cart on the backend
    jQuery.ajax({
        method: "GET",
        url: "mycartajax.php",
        data: "bookid=" + bookid + "&submit=remove&bookprice=" + book_price,
        cache: false,
        dataType: "json",
        success: function(response) {
            console.log(response);
            if (response.status === "success") {
                // Update other elements on the frontend if needed
                console.log(response.data.carttotal);
                if (response.data.carttotal == null || response.data.carttotal == 0) {
                    alert("Cart empty");
                    window.location.replace("index.php");
                } else {
                    document.getElementById("cartTotal").innerHTML = response.data.carttotal;
                    document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + response.data.totalpayable;
                    document.getElementById("bookprid_" + bookid).innerHTML = "Price: RM " + response.data.booktotal[bookid];
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
function deleteCart(bookid, book_price) {
                // Update the quantity label on the frontend immediately
                const qtyLabel = document.getElementById("qtyid_" + bookid);
                const currentQty = parseInt(qtyLabel.innerHTML);

                qtyLabel.innerHTML = ""; // Remove the quantity label
                qtyLabel.parentNode.parentNode.remove();
                window.location.replace("cart.php");
                // Remove the item row from the cart table

                // Perform the AJAX request to update the cart on the backend
                jQuery.ajax({
                    method: "GET",
                    url: "mycartajax.php",
                    data: "bookid=" + bookid + "&submit=delete&bookprice=" + book_price,
                    cache: false,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status === "success") {
                            // Update other elements on the frontend if needed
                            console.log(response.data.carttotal);
                            document.getElementById("cartTotal").innerHTML = response.data.carttotal;
                             document.getElementById("bookprid_" + bookid).innerHTML = "Price: RM " + response.data.booktotal[bookid];
                            if (response.data.carttotal == null || response.data.carttotal == 0) {
                                document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM 0.00";
                                alert("Cart empty");
                                
                            } else {
                                document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + response.data.totalpayable;
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