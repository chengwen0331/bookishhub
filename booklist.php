<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include_once("dbconnect.php");
session_start();

$carttotal = isset($_SESSION['carttotal']) ? $_SESSION['carttotal'] : 0;
$useremail = "Guest";
$user_name = "Guest";
$user_phone = "-";

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
    $user_phone = $_SESSION['user_phone'];
}

// Database query to fetch all books
$sqlquery = "SELECT * FROM tbl_books";
$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to truncate a string if it exceeds a certain length
function subString($str)
{
    if (strlen($str) > 30) {
        return $substr = substr($str, 0, 25) . '...';
    } else {
        return $str;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>BookishHub</title>
    <link rel="shortcut icon" type="image/jpeg" href="images/logo1.jpeg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/booklist_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="js/script.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />

    <style>
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

</head>

<body>
    <header>
        <?php include_once("menu.php"); ?>
    </header>

    <div class="w3-main w3-content w3-padding" style="max-width:1000px;margin-top:20px">
        <div class="w3-container w3-center">
            <p style="font-size: 36px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">
                Welcome <?php echo $user_name; ?> !
            </p>
        </div>
    </div>

    <!-- Main content -->
    <div class="w3-main w3-content w3-padding" style="max-width:1350px;margin-top:10px">
        <!-- Book listings -->
        <div class="w3-grid-template">
            <?php
            // Displaying the books
            foreach ($books as $book) {
                // Extracting book details
                $bookid = $book['book_id'];
                $book_title = subString($book['book_title']);
                $book_author = $book['book_author'];
                $book_isbn = $book['book_isbn'];
                $book_price = $book['book_price'];
                $book_description = $book['book_description'];
                $book_pub = $book['book_pub'];
                $book_lang = $book['book_lang'];
                $book_date = $book['book_date'];
                $book_qty = $book['book_qty'];

                // Displaying book information in a card format with a link to details page
                echo "<div class='w3-center w3-padding-small' style='min-height:350px'>
        <div class='w3-card w3-round-large'>
            <div class='w3-padding-small'>
                <img class='w3-container w3-image' src='images/$bookid.jpg' onerror='this.onerror=null; this.src='images/books/default.jpg';' style='min-height:240px'>
            </div>
            <div class='w3-description'>
               <h6 class='book-title'><a href='bookdetails.php?bookid=$bookid'>$book_title</a></h6>



                <p>RM $book_price / $book_qty avail</p>
       <a href='index.php?bookid=$bookid&submit=cart' class='w3-button w3-round-small' style='background-color: #3286AA; color: white;'>
    <i class='fas fa-cart-plus'></i> Add to cart
</a>

            </div>
        </div>
    </div>";
            }
            ?>
        </div>
    </div>
</body>

</html>