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
    $bookprice = $_GET['bookprice'];

    $sqlqty = "SELECT * FROM tbl_carts WHERE user_email = :useremail AND book_id = :bookid";
    $stmtsqlqty = $conn->prepare($sqlqty);
    $stmtsqlqty->bindParam(':useremail', $useremail);
    $stmtsqlqty->bindParam(':bookid', $bookid);
    $stmtsqlqty->execute();
    $rowsqlqty = $stmtsqlqty->fetchAll();
    $bookcurqty = 0;

    foreach ($rowsqlqty as $books) {
        $bookcurqty += $books['cart_qty'];
    }

    if ($_GET['submit'] == "add") {
        $cartqty = $bookcurqty + 1;
    
        // Check if the added quantity exceeds the available stock
        $sqlStock = "SELECT book_qty FROM tbl_books WHERE book_id = :bookid";
        $stmtStock = $conn->prepare($sqlStock);
        $stmtStock->bindParam(':bookid', $bookid);
        $stmtStock->execute();
        $stock = $stmtStock->fetchColumn();
    
        if ($cartqty > $stock) {
            $response = array('status' => 'failed', 'data' => null);
            sendJsonResponse($response);
            return;
        }
    
        $updatecart = "UPDATE tbl_carts SET cart_qty = :cartqty WHERE user_email = :useremail AND book_id = :bookid";
        $stmtupdatecart = $conn->prepare($updatecart);
        $stmtupdatecart->bindParam(':cartqty', $cartqty);
        $stmtupdatecart->bindParam(':useremail', $useremail);
        $stmtupdatecart->bindParam(':bookid', $bookid);
        $stmtupdatecart->execute();
    }

    if ($_GET['submit'] == "remove") {
        if ($bookcurqty == 1) {
            $deletecart = "DELETE FROM tbl_carts WHERE user_email = :useremail AND book_id = :bookid";
            $stmtdeletecart = $conn->prepare($deletecart);
            $stmtdeletecart->bindParam(':useremail', $useremail);
            $stmtdeletecart->bindParam(':bookid', $bookid);
            $stmtdeletecart->execute();
        } else {
            $cartqty = $bookcurqty - 1;
            $updatecart = "UPDATE tbl_carts SET cart_qty = :cartqty WHERE user_email = :useremail AND book_id = :bookid";
            $stmtupdatecart = $conn->prepare($updatecart);
            $stmtupdatecart->bindParam(':cartqty', $cartqty);
            $stmtupdatecart->bindParam(':useremail', $useremail);
            $stmtupdatecart->bindParam(':bookid', $bookid);
            $stmtupdatecart->execute();
        }
    }
    if ($_GET['submit'] == "delete") {
        $deletecart = "DELETE FROM tbl_carts WHERE user_email = :useremail AND book_id = :bookid";
        $stmtdeletecart = $conn->prepare($deletecart);
        $stmtdeletecart->bindParam(':useremail', $useremail);
        $stmtdeletecart->bindParam(':bookid', $bookid);
        $stmtdeletecart->execute();
    }
}

$stmtqty = $conn->prepare("SELECT * FROM tbl_carts INNER JOIN tbl_books ON tbl_carts.book_id = tbl_books.book_id WHERE tbl_carts.user_email = :useremail");
$stmtqty->bindParam(':useremail', $useremail);
$stmtqty->execute();
$rowsqty = $stmtqty->fetchAll();
$totalpayable = 0;
$carttotal = 0;
$booktotals = array();
$quantityAvailable = array();

foreach ($rowsqty as $carts) {
    $carttotal += $carts['cart_qty'];
    $bookprice = $carts['book_price'] * $carts['cart_qty'];
    $totalpayable += $bookprice;
    $booktotals[$carts['book_id']] = bcdiv($bookprice, 1, 2);
    $quantityAvailable[$carts['book_id']] = $carts['book_qty'];
}

$mycart = array(
    'carttotal' => $carttotal,
    'totalpayable' => bcdiv($totalpayable, 1, 2),
    'booktotal' => $booktotals,
    'quantityAvailable' => $quantityAvailable,
);

$response = array('status' => 'success', 'data' => $mycart);
sendJsonResponse($response);

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>