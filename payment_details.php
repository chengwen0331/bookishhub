<?php
include_once("dbconnect.php");
include 'menu.php';

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
} else {
    echo "<script>alert('Please login or register')</script>";
    echo "<script>window.location.replace('login.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $billing_address = $_POST['billing_address'];
    $delivery_address = $_POST['delivery_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $phone_number = $_POST['phone_number'];
    $receipt_file = $_FILES['receipt_file'];

    // Perform validation and processing of the payment details
    if (empty($fullname) || empty($email) || empty($billing_address) || empty($delivery_address) || empty($city) || empty($state) || empty($zip_code) || empty($phone_number)) {
        // Display an error message if any field is empty
        echo "<script>alert('Please fill in all the required fields')</script>";
    } 
    else {
        // All fields are filled, proceed with processing the payment

        // Perform any necessary processing or calculations here

        // Save the payment details to the database
        $payment_receipt = ''; // Set the payment receipt filename or path
        $sql = "INSERT INTO `tbl_payments` (`payment_email`, `payment_fullname`, `payment_billing_address`, `payment_delivery_address`, `payment_city`, `payment_state`, `payment_zip_code`, `payment_phone_number`, `payment_receipt`) 
                VALUES ('$email', '$fullname', '$billing_address', '$delivery_address', '$city', '$state', '$zip_code', '$phone_number', '$payment_receipt')";
        
        // Execute the SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Payment successfully')</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
   <title>Bookish Hub</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
   <script src="../js/script.js"></script>
   <style>
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
        .form-container textarea,
        .form-container select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 2px solid black;
        border-radius: 4px;
        resize: vertical;
        background-color: #f2f2f2;
        }

        .form-container input[type=submit] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        }

        .form-container input[type=submit]:hover {
        background-color: #45a049;
        }

        /* CSS for Order Summary */
        .summary-container {
        width: 50%;
        margin: auto;
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 5px;
        }

        .summary-container h3 {
        font-weight: bold;
        }

        .summary-container table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        }

        .summary-container th,
        .summary-container td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        }

        .summary-container th {
        background-color: #4CAF50;
        color: white;
        }

        /* Additional Styles */
        .container {
        display: flex;
        margin-top:20px;
        }

   </style>
   <body>
      <div class="container">
         <div class="form-container">
            <h3>Payment Details</h3>
            <form action="process_payment.php" method="post">
               <label for="full-name">Full Name</label>
               <input type="text" id="full-name" name="full_name" required>
               <label for="email">Email</label>
               <input type="email" id="email" name="email" required>
               <label for="billing-address">Billing Address</label>
               <textarea id="billing-address" name="billing_address" required></textarea>
               <label for="delivery-address">Delivery Address</label>
               <textarea id="delivery-address" name="delivery_address" required></textarea>
               <label for="city">City</label>
               <input type="text" id="city" name="city" required>
               <label for="state">State</label>
               <select id="state" name="state" required>
                  <option value="">Select State</option>
                  <option value="state1">State 1</option>
                  <option value="state2">State 2</option>
                  <option value="state3">State 3</option>
               </select>
               <label for="zip-code">Zip Code</label>
               <input type="text" id="zip-code" name="zip_code" required>
               <label for="phone">Phone Number</label>
               <input type="text" id="phone" name="phone" required>
               <label for="receipt">Receipt</label>
               <input type="file" id="receipt" name="receipt" required>
               <input type="submit" value="Submit">
            </form>
         </div>
         <div class="summary-container">
            <h3>Order Summary</h3>
            <table>
               <tr>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Total</th>
               </tr>
               <!-- Add rows for each product -->
               <tr>
                  <td>Product 1</td>
                  <td>2</td>
                  <td>$20.00</td>
               </tr>
               <tr>
                  <td>Product 2</td>
                  <td>1</td>
                  <td>$10.00</td>
               </tr>
               <!-- End of rows -->
               <tr>
                  <td colspan="2">Total Payable</td>
                  <td>$30.00</td>
               </tr>
            </table>
         </div>
      </div>
   </body>
</html>
