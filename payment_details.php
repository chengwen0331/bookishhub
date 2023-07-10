<?php
include_once("dbconnect.php");
include 'menu.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
} else {
    echo "<script>alert('Please login or register')</script>";
    echo "<script>window.location.replace('login.php')</script>";
}
$email_add = $_GET['email'];
$amount = $_GET['amount'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['full_name'];
    $email = $_POST['email'];
    $billing_address = $_POST['billing_address'];
    $delivery_address = $_POST['delivery_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $phone_number = $_POST['phone'];
    $remark = $_POST['remark'];
    $receipt_file = $_FILES['receipt']['name'];
    $receiptTmp = $_FILES['receipt']['tmp_name'];

    if (!empty($receipt_file)) {
      $targetDirectory = "images/";
      $targetFile = $targetDirectory . basename($receipt_file);
      move_uploaded_file($receiptTmp, $targetFile);
      $sqlpayment = "INSERT INTO `tbl_payments` (`payment_email`, `payment_fullname`, `payment_billing_address`, `payment_delivery_address`, `payment_city`, `payment_state`, `payment_zip_code`, `payment_phone_number`, `payment_remark`,`payment_receipt`) 
                VALUES ('$email', '$fullname', '$billing_address', '$delivery_address', '$city', '$state', '$zip_code', '$phone_number', '$remark', '$receipt_file')";
    
      $orderReceiptId = generateOrderReceiptId();
      $orderstatus ='Processing';
      try {
         $conn->exec($sqlpayment);

         $sqlcart = "SELECT * FROM tbl_carts JOIN tbl_books ON tbl_carts.book_id = tbl_books.book_id WHERE user_email = '$useremail'";
         $stmt = $conn->prepare($sqlcart);
         $stmt->execute();
         $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

         foreach ($cartItems as $item) {
            $bookid = $item['book_id'];
            $bookname = $item['book_title'];
            $ttlqty=$item['book_qty'];
            $qty = intval($item['cart_qty']);
            $avail = $ttlqty - $qty;
            $bookPrice = $item['book_price'];
            $bookTtlPrice = $qty * $bookPrice ;

            $ordersql ="INSERT INTO `tbl_orders`(`order_receiptid`, `order_bookid`, `order_qty`, `order_custid`, `order_paid`, `order_status`) VALUES ('$orderReceiptId','$bookid','$qty','$useremail','$bookTtlPrice','$orderstatus')";
            $conn->exec($ordersql);

            $minusQtyBook= "UPDATE `tbl_books` SET `book_qty`='$avail' WHERE `book_id` = '$bookid'";
            $conn->exec($minusQtyBook);

            $minusQtyBest="UPDATE `tbl_bestbooks` SET `book_qty`='$avail' WHERE `book_title` = '$bookname'";
            $conn->exec($minusQtyBest);

            $minusQtyNew="UPDATE `tbl_newbooks` SET `book_qty`='$avail' WHERE `book_title` = '$bookname'";
            $conn->exec($minusQtyNew);
         }
         
         sendMail($email);
         $clearCartSql = "DELETE FROM `tbl_carts` WHERE user_email = '$email_add'";
         $conn->exec($clearCartSql);

         echo "<script>alert('Payment successfully')</script>";
         echo "<script>window.location.replace('index.php')</script>";
     }catch (PDOException $e) {
         echo "<script>alert('Error: Payment failed')</script>";
         echo "<script>window.location.replace('payment_details.php?email='.$email_add.'&amount='.$amount)</script>";
     }
   } 
   else {
      echo "<script>alert('Please fill in all the required fields')</script>";
   }
}

function generateOrderReceiptId() {
    $prefix = 'ORD-';
    $randomId = uniqid();
    return $prefix . $randomId;
}

function sendMail($recipientEmail){
  $mail = new PHPMailer(true);
  $mail->SMTPDebug = 0;                                               // Disable verbose debug output
  $mail->isSMTP();                                                    // Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                                // Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                           // Enable SMTP authentication
  $mail->Username   = 'bookishhubb@gmail.com';
  $mail->Password   = 'cpphpxzzxxjcsaxv';                              //
  $mail->SMTPSecure = 'tls';         
  $mail->Port       = 587;
  $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
  );
  
  $from = "bookishhubb@gmail.com";
  $to = $recipientEmail;   
  $subject = 'BookishHub - Payment Confirmation';
  $message = "Thank you for your payment. Your payment has been successfully processed.";
    
  $mail->setFrom($from, "BookishHub");
  $mail->addAddress($to);                                             // Add a recipient
    
  // Content
  $mail->isHTML(true);                                                // Set email format to HTML
  $mail->Subject = $subject;
  $mail->Body    = $message;

  try {
    $mail->send();
  } catch (Exception $e) {
    // Failed to send email, handle the error if needed
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
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
   <style>
        body{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* CSS for Payment Form */
        .form-container {
        width: 50%;
        padding: 20px;
        border-radius: 5px;
        }

        .form-container label {
        font-weight: bold;
        }

        .form-container input[type=text],
        .form-container input[type=email],
        .form-container input[type=file],
        .form-container textarea,
        .form-container select {
        width: 100%;
        padding: 12px 15px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 2px solid #ddd;
        border-radius: 4px;
        resize: vertical;
        background-color: #f2f2f2;
        }

        .form-container input[type=submit] {
         background-color: rgb(50,134,171);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        }

        .form-container input[type=submit]:hover {
         background-color: rgb(0,50,100);
        }
        .form-container h3 {
        font-weight: bold;
        }
        .form-container p{
         margin-top:15px;
         font-size:15px;
        }
        .form-container a{
          text-decoration: none;
          color:blue;
        }
        .form-container a:hover{
          text-decoration: underline;
          color:darkblue;
        }
        /* CSS for Order Summary */
        .summary-container {
        width: 50%;
        margin: 20px;
        padding: 10px;
        border-radius: 5px;
        }

        .summary-container h3 {
        font-weight: bold;
        }

        .summary-container table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        }

        .summary-container th,
        .summary-container td {
        border: 2px solid #ddd;
        padding: 8px;
        text-align: left;
        }

        .summary-container th {
        background-color: rgb(50,134,171);
        color: white;
        }
        .payment-container{
         margin-top:20px;
         border:2px solid #ddd;
         padding:20px;
        }
        .payment-container h4 {
        font-weight: bold;
        }
        /* Additional Styles */
        .containerr {
        display: flex;
        margin-top:20px;
        margin-bottom:20px;
        }

        .cancel-btn{
         background-color: rgb(50,134,171);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 40%;
        margin-top: 20px;
        justify-content: center;
        float: right;
        }

        .cancel-btn:hover {
         background-color: rgb(0,50,100);
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

    <?php 
        $sqladdress = "SELECT * FROM `tbl_address` JOIN `tbl_users` ON tbl_address.user_id = tbl_users.user_id WHERE tbl_users.user_email = '$useremail' AND tbl_address.default = 'Yes'";
        $stmt = $conn->prepare($sqladdress);
        $stmt->execute();
        $addressrow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($addressrow) {
            $address1 = $addressrow['address1'];
            $address2 = $addressrow['address2'];
            $address3 = $addressrow['address3'];
            $city = $addressrow['city'];
            $state = $addressrow['state'];
            $country = $addressrow['country'];
            $postalcode = $addressrow['postalcode'];
        }else{
            $address1 = '';
            $address2 = '';
            $address3 = '';
            $city = '';
            $state = '';
            $country = '';
            $postalcode = '';
        }
    ?>

   <body>
      <div class="containerr container">
         <div class="form-container">
            <h3>Payment Details</h3>
            <form action="" method="post" enctype="multipart/form-data">
               <label for="full-name">Full Name</label>
               <input type="text" id="full-name" name="full_name" required>
               <label for="email">Email</label>
               <input type="email" id="email" name="email" value="<?php echo $useremail; ?>" required>
               <label for="billing-address">Billing Address</label>
               <textarea id="billing-address" name="billing_address" required><?php echo $address1.' '.$address2.' '.$address3; ?></textarea>
               <label for="delivery-address">Delivery Address</label>
               <textarea id="delivery-address" name="delivery_address" required></textarea>
               <label for="city">City</label>
               <input type="text" id="city" name="city" value="<?php echo $city; ?>" required>
               <label for="state">State</label>
               <select id="state" name="state" required>
                  <option value="">Select State</option>
                  <option value="Perak" <?php if ($state == "Perak") echo "selected"; ?>>Perak</option>
                  <option value="Kedah" <?php if ($state == "Kedah") echo "selected"; ?>>Kedah</option>
                  <option value="Johor" <?php if ($state == "Johor") echo "selected"; ?>>Johor</option>
                  <option value="Kelantan" <?php if ($state == "Kelantan") echo "selected"; ?>>Kelantan</option>
                  <option value="Melaka" <?php if ($state == "Melaka") echo "selected"; ?>>Melaka</option>
                  <option value="Perlis" <?php if ($state == "Perlis") echo "selected"; ?>>Perlis</option>
                  <option value="Penang" <?php if ($state == "Penang") echo "selected"; ?>>Penang</option>
                  <option value="Pahang" <?php if ($state == "Pahang") echo "selected"; ?>>Pahang</option>
                  <option value="Negeri Sembilan" <?php if ($state == "Negeri Sembilan") echo "selected"; ?>>Negeri Sembilan</option>
                  <option value="Terengganu" <?php if ($state == "Terengganu") echo "selected"; ?>>Terengganu</option>
                  <option value="Sabah" <?php if ($state == "Sabah") echo "selected"; ?>>Sabah</option>
                  <option value="Sarawak" <?php if ($state == "Sarawak") echo "selected"; ?>>Sarawak</option>
                  <option value="Selangor" <?php if ($state == "Selangor") echo "selected"; ?>>Selangor</option>
               </select>
               <label for="zip-code">Zip Code</label>
               <input type="text" id="zip-code" name="zip_code" value="<?php echo $postalcode; ?>" required>
               <label for="phone">Phone Number</label>
               <input type="text" id="phone" name="phone" value="<?php echo $user_phone; ?>" required>
               <label for="remark">Remark</label>
               <textarea id="remark" name="remark"></textarea>
               <label for="receipt">Receipt</label>
               <input type="file" id="receipt" name="receipt" required>
               <br><br><input type="submit" value="Place Order Now">
            </form>
            <p>By placing an order, I agree to the Bookish Hub's <a href="terms_of_service.php">Terms of Service</a> and <a href="privacy_policy.php">Privacy Policy</a>.</p>

         </div>
         <div class="summary-container">
            <h3>Order Summary</h3>
            <table>
               <tr>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Total (RM)</th>
               </tr>
               <!-- Add rows for each product -->
               <?php
               // Fetch cart items and calculate total payment
               $totalPayment = 0;
               $stmt = $conn->prepare("SELECT c.book_id, c.cart_qty, b.book_title, b.book_price FROM tbl_carts c INNER JOIN tbl_books b ON c.book_id = b.book_id WHERE c.user_email = :user_email");
               $stmt->bindParam(':user_email', $email_add);
               $stmt->execute();
               $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

               foreach ($cartItems as $item) {
                     $bookId = $item['book_id'];
                     $bookTitle = $item['book_title'];
                     $quantity = $item['cart_qty'];
                     $bookPrice = $item['book_price'];
                     $totalPrice = $quantity * $bookPrice;

                     echo "<tr>
                           <td>
                                 <div class='w3-center w3-padding-small' id='bookcard_$bookId'>
                                    
                                       <div class='w3-padding-small'>
                                             <a href='bookdetails.php?bookid=$bookId'>
                                                <img class='w3-container w3-image' src='images/books/$bookId.jpg' onerror='this.onerror=null; this.src='images/books/default.jpg';' style='max-height:150px; max-width:180px;'>
                                             </a>
                                       </div>
                                       <div>$bookTitle</div>
                                    
                                 </div>
                           </td>
                           <td>$quantity</td>
                           <td>$totalPrice</td>
                           </tr>";
               }

               $subTotal = $amount;
               $shippingFee = 8.00;
               $formattedShippingFee = number_format($shippingFee, 2);

               // Calculate the total payable amount
               $totalPayable = $subTotal + $shippingFee;
               echo "<tr>
                     <td colspan='2'>Subtotal (RM)</td>
                     <td>$subTotal</td>
                     </tr>";
               echo "<tr>
                     <td colspan='2'>Shipping Fee (RM)</td>
                     <td>$formattedShippingFee</td>
                     </tr>";
               echo "<tr>
                     <td colspan='2'>Total Payment (RM)</td>
                     <td>$totalPayable</td>
                     </tr>";
              
               ?>
            </table>
            <br><h3>Payment Information</h3>
            <div class="payment-container">
               <h4>Bank Transfer</h4>
               <img src="images/maybank.png" alt="Bank transfer image">
               <p>Bank name: Maybank</p>
               <p>Account name: Bookish Hub</p>
               <p>Account number: 558293579402</p><br>
               <h4>E-wallet</h4>
               <p>Type: Touch'n Go, Boost, GrabPay and Shopee Pay</p>
               <p>Account name: Bookish Hub</p>
               <p>Account number: 019-8745632</p><br>
               <p><strong>* Note: Please upload your transaction document, screenshot, or scanned copy once payment is made.</strong></p>
            </div>
            <button class="cancel-btn"onclick="cancelOrder()">Cancel Order</button>
         </div>
      </div>
      <hr style="color: rgba(0, 0, 0, 0.4);">

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
    <script>
      function cancelOrder() {
         window.location.href = 'cart.php';
      }
   </script>           
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
   </body>
</html>