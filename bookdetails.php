<?php
include_once("dbconnect.php");
include "menu.php";
$bookid = $_GET['bookid'];

if (isset($_GET['submit']) && $_GET['submit'] == "cart" && isset($_GET['bookid']) && isset($_GET['bookqty'])) {
    if ($useremail != "Guest") {
        $bookid = $_GET['bookid'];
        $bookqty = $_GET['bookqty'];

        // Check if the book is already in the cart
        $stmt = $conn->prepare("SELECT * FROM tbl_carts WHERE user_email = '$useremail' AND book_id = '$bookid'");
        $stmt->execute();
        $number_of_rows = $stmt->rowCount();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();

        if ($number_of_rows > 0) {
            foreach ($rows as $carts) {
                $cartqty = $carts['cart_qty'];
            }
            $cartqty += $bookqty;
            $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND book_id = '$bookid'";
            $conn->exec($updatecart);
            echo "<script>alert('Cart updated')</script>";
            echo "<script>window.location.replace('bookdetails.php?bookid=$bookid')</script>";
        } else {
            $addcart = "INSERT INTO `tbl_carts`(`user_email`, `book_id`, `cart_qty`) VALUES ('$useremail','$bookid','$bookqty')";
            try {
                $conn->exec($addcart);
                echo "<script>alert('Success')</script>";
                echo "<script>window.location.replace('bookdetails.php?bookid=$bookid')</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Failed')</script>";
            }
        }
    } else {
        echo "<script>alert('Please login or register')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    }
}

// Use prepared statements to prevent SQL injection
$sqlquery = "SELECT * FROM tbl_books WHERE book_id = :bookid";
$stmt = $conn->prepare($sqlquery);
$stmt->bindParam(':bookid', $bookid); // Bind the bookid parameter
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {
    foreach ($rows as $books) {
        // Extract the book details
        $book_title = $books['book_title'];
        $book_author = $books['book_author'];
        $book_isbn = $books['book_isbn'];
        $book_price = $books['book_price'];
        $book_description = $books['book_description'];
        $book_pub = $books['book_pub'];
        $book_lang = $books['book_lang'];
        $book_qty = $books['book_qty'];
        $book_date = date_format(date_create($books['book_date']), 'd/m/y h:i A');
    }
} else {
    // Book details not found
    echo "Book details not available.";
    echo "SQL Query: " . $sqlquery . "<br>";
    echo "Book ID: " . $bookid . "<br>";

    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>BookishHub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <link rel="stylesheet" type="text/css" href="bookdetails_style.css">
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</head>

<body>

    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:75px">

        <div class="w3-row w3-card">
            <div class="w3-half w3-center">
                <img class="w3-image w3-margin w3-center" style="height:100%;width:100%;max-width:330px; padding:20px 0px 0px 0px" src="images/<?php echo $bookid ?>.jpg">
            </div>
            <div class="w3-half w3-container">
                <?php
                echo "<h3 class='w3-center' style='padding:5px 0px 5px 0px'><b>$book_title</h3></b>
                <div>
                <h4>Product Overview</h4>
                <table class='w3-table'>
        
                    <tr>
                        <td class='custom-table-row'>ISBN</td>
                        <td>$book_isbn</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Author(s)</td>
                        <td>$book_author</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Publisher</td>
                        <td>$book_pub</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Language</td>
                        <td>$book_lang</td>
                    </tr>
                    <tr>
                        <td class='custom-table-row'>Quantity Available</td>
                        <td>$book_qty</td>
                    </tr>
                </table>
                </div>
                <br>
                <p style='color:rgb(19, 96, 174); font-weight: 900;'>Description<p/>
                <p style='ext-align: justify;'>$book_description</p>
            
                <p style='font-size:160%; color:rgb(19, 96, 174); font-weight: 900; padding: 10px 0px 10px 0px;'>RM $book_price</p>
               <div class='w3-col w3-margin-bottom'>
    <label class='w3-col mb-2 d-block' style='color:rgb(19, 96, 174); font-weight: 900;'>Quantity</label>
    <div class='w3-input-group w3-margin-bottom' style='width: 170px; display: flex; align-items: center;'>
        <button class='w3-button w3-white w3-border w3-border-secondary w3-round-large' type='button' id='button-addon1' data-mdb-ripple-color='dark' style='margin-right: 10px;'>
            <i class='fa fa-minus' style='display: flex; align-items: center; justify-content: center;'></i>
        </button>
        <input type='text' id='quantity-input' class='w3-input w3-center w3-border w3-border-secondary' placeholder='1' aria-label='Example text with button addon' aria-describedby='button-addon1' style='margin-right: 10px;' readonly>
        <button class='w3-button w3-white w3-border w3-border-secondary w3-round-large' type='button' id='button-addon2' data-mdb-ripple-color='dark' style='display: flex; align-items: center; justify-content: center;'>
            <i class='fa fa-plus'></i>
        </button>
    </div>
</div>

<p>
    <a href='submit.php?bookid=<?php echo $bookid; ?>&submit=cart&bookqty=' + quantityInput.value' class='w3-button w3-round-small' style='background-color: #3286AA; color: white;' id='add-to-cart-button'>
    <i class='fas fa-cart-plus'></i> Add to cart
</a>

</p>
            ";
                ?>
            </div>
        </div>
    </div>
    <footer class="w3-row-padding w3-padding-32">
        <p class="w3-center">MyBookDepository&reg;</p>
    </footer>

    <!-- JavaScript code -->
    <script>
        // Wait for the DOM to load
        document.addEventListener('DOMContentLoaded', function() {
            // Get the quantity input and add event listeners
            var quantityInput = document.getElementById('quantity-input');
            var addToCartButton = document.getElementById('add-to-cart-button');
            var bookid = '<?php echo $bookid; ?>'; // Get the bookid value from PHP

            // Set the initial quantity value
            var quantity = 1;
            quantityInput.value = quantity;

            // Function to update the URL of the "Add to Cart" button
            function updateCartURL() {
                addToCartButton.href = "bookdetails.php?bookid=" + bookid + "&submit=cart&bookqty=" + quantity;
            }

            // Add event listener for the plus button
            document.getElementById('button-addon2').addEventListener('click', function() {
                // Increment the quantity by 1
                quantity += 1;
                quantityInput.value = quantity;

                // Update the "Add to Cart" button URL
                updateCartURL();
            });

            // Add event listener for the minus button
            document.getElementById('button-addon1').addEventListener('click', function() {
                // Decrement the quantity by 1, minimum value is 1
                if (quantity > 1) {
                    quantity -= 1;
                    quantityInput.value = quantity;

                    // Update the "Add to Cart" button URL
                    updateCartURL();
                }
            });

            // Add event listener for the "Add to Cart" button
            addToCartButton.addEventListener('click', function(e) {
                // Prevent the default link behavior if the quantity is not valid
                if (quantity < 1) {
                    e.preventDefault();
                    return;
                }
            });
        });
    </script>
    <!--  -->


</body>

</html>