<?php
include_once("dbconnect.php");
session_start();

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    return;
}

if (isset($_GET['submit'])) {
    $bookid = $_GET['bookid'];
    $sqlwishlist = "SELECT * FROM tbl_wishlist WHERE user_email = :useremail AND book_id = :bookid";
    $stmtsqlwishlist = $conn->prepare($sqlwishlist);
    $stmtsqlwishlist->bindParam(':useremail', $useremail);
    $stmtsqlwishlist->bindParam(':bookid', $bookid);
    $stmtsqlwishlist->execute();
    $rowsqlwishlist = $stmtsqlwishlist->fetchAll();

    if ($_GET['submit'] == "delete") {
        $deletewishlist = "DELETE FROM tbl_wishlist WHERE user_email = :useremail AND book_id = :bookid";
        $stmtdeletewishlist = $conn->prepare($deletewishlist);
        $stmtdeletewishlist->bindParam(':useremail', $useremail);
        $stmtdeletewishlist->bindParam(':bookid', $bookid);
        $stmtdeletewishlist->execute();
    }
}

$stmtwishlist = $conn->prepare("SELECT * FROM tbl_wishlist INNER JOIN tbl_books ON tbl_wishlist.book_id = tbl_books.book_id WHERE tbl_wishlist.user_email = :useremail");
$stmtwishlist->bindParam(':useremail', $useremail);
$stmtwishlist->execute();
$rowsqty = $stmtqty->fetchAll();



$response = array('status' => 'success', 'data' => null);
sendJsonResponse($response);

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>