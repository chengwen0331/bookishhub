<?php
// Database connection and query to fetch all books
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore_db";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$sqlquery = "SELECT * FROM tbl_books";
$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

///////////////Function to truncate a string if it exceeds a certain length
function subString($str)
{
    if (strlen($str) > 30) {
        return $substr = substr($str, 0, 25) . '...';
    } else {
        return $str;
    }
}

// function subString($str)
// {
//     return $str;
// }
?>

<!DOCTYPE html>
<html>
<title>BookishHub</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../js/script.js"></script>

<body>
    <!-- Main content -->
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
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

                // // Displaying book information in a card format
                // echo "<div class='w3-center w3-padding-small'><div class='w3-card w3-round-large'>
                //     <div class='w3-padding-small'><img class='w3-container w3-image' 
                //     src='../images/harrypotter.jpg' onerror='this.onerror=null; this.src='../images/books/default.jpg';'></div>
                //     <b>$book_title</b><br>$book_author<br>RM $book_price / $book_qty available<br>
                //     </div></div>";


                // Displaying book information in a card format with a link to details page

                // echo "<div class='w3-center w3-padding-small'><div class='w3-card w3-round-large'>
                //     <div class='w3-padding-small'><img class='w3-container w3-image' 
                //     src='images/$bookid.jpg' onerror='this.onerror=null; this.src='../images/books/default.jpg';'></div>
                //     <b><a href='bookdetails.php?bookid=$bookid'>$book_title</a></b><br>$book_author<br>RM $book_price / $book_qty avail<br>
                //     </div></div>";

                // Displaying book information in a card format with a link to details page
                echo "<div class='w3-center w3-padding-small'>
                <div class='w3-card w3-round-large'>
                    <div class='w3-padding-small'>
                    <img class='w3-container w3-image' src='images/$bookid.jpg' onerror='this.onerror=null; this.src='../images/books/default.jpg';'>
                    </div>
                    <div class='w3-description'>
                    <b><a href='bookdetails.php?bookid=$bookid'>$book_title</a></b>
                    RM $book_price / $book_qty avail<br>
                    </div></div></div>";
            }
            ?>
        </div>
    </div>
</body>
<!-- HTML closing tags -->

</html>