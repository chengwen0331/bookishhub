<?php
include_once ("dbconnect.php");
include 'menu.php';

if (isset($_SESSION['sessionid']))
{
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
}else{
    echo "<script>alert('Please login or register')</script>";
    echo "<script> window.location.replace('login.php')</script>";
}
$sqlpayment = "SELECT * FROM tbl_payments WHERE payment_email = '$useremail' ORDER BY payment_date DESC";
$stmt = $conn->prepare($sqlpayment);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html>
   <title>Book Depo</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
   <link rel="stylesheet" type="text/css" href="../css/style.css">
   <script src="../js/script.js"></script>
   <body onload="loadCookies()">
      <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
          <div class="w3-grid-template">
               <?php
               $totalpaid = 0.0;
               $count = 0;
                foreach ($rows as $payments){
                    $paymentid = $payments['payment_id'];
                    $paymentreceipt = $payments['payment_receipt'];
                    $paymentpaid = number_format($payments['payment_paid'], 2, '.', '');
                    $totalpaid = $paymentpaid + $totalpaid;
                    $count++;
                    $paymentdate = date_format(date_create($payments['payment_date']),"d/m/Y h:i A");
                     echo "<div class='w3-left w3-padding-small'><div class = 'w3-card w3-round-large w3-padding'>
                    <div class='w3-container w3-center w3-padding-small'><b>Receipt ID: $paymentreceipt</b></div><br>
                    Book ordered: $count<br>Paid: RM $paymentpaid<br>Date: $paymentdate<br>
                    <div class='w3-button w3-blue w3-round w3-block'><a style='text-decoration: none;' href='payment_details.php?receipt=$paymentreceipt'>Details</a></div>
                    </div></div>";
                }
                $totalpaid = number_format($totalpaid, 2, '.', '');
                $totalpaid = number_format($totalpaid, 2, '.', '');
            echo "</div><br><hr><div class='w3-container w3-left'><h4>Your Orders</h4><p>Name: $user_name <br>Phone: $user_phone<br>Total Paid: RM $totalpaid<p></div>";
               ?>
          </div>
      </div>
      <div id="id01" class="w3-modal">
      <div class="w3-modal-content" style="width:50%">
         <header class="w3-container w3-blue">
            <span onclick="document.getElementById('id01').style.display='none'" 
               class="w3-button w3-display-topright">&times;</span>
            <h4>Email to reset password</h4>
         </header>
         <div class="w3-container w3-padding">
            <form action="login.php" method="post">
               <label><b>Email</b></label>
               <input class="w3-input w3-border w3-round" name="email" type="email" id="idemail" required>
               <p>
                  <button class="w3-btn w3-round w3-blue" name="reset">Submit</button>
               </p>
            </form>
         </div>
      </div>
   </body>
</html>

