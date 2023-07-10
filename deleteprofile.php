<?php
    require 'dbconnect.php';

    if(isset($_GET['addressid']) && $_GET['userid']){
        $userid = $_GET['userid'];
        $addressid = $_GET['addressid'];

        $query = "SELECT * FROM tbl_address WHERE user_id = $userid AND address_id = $addressid";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$entry) {
            header('Location: profile.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the user has confirmed the deletion
            if (isset($_POST['delete']) && $_POST['delete'] === 'deleteaddress') {
                // Delete diary entry by ID
                $delete = "DELETE FROM tbl_address WHERE user_id = $userid AND address_id = $addressid";
                $stmt = $conn->prepare($delete);
                $stmt->execute();
        
                echo "<script>alert('Delete address successful!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            } else {
                echo "<script>alert('Delete address failed!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            }
        }

    }

    if (isset($_GET['wishlist_id']) && isset($_GET['user_email'])) {
        $userEmail = $_GET['user_email'];
        $wishlistId = $_GET['wishlist_id'];
    
        $query = "SELECT * FROM tbl_wishlist WHERE user_email = :userEmail AND wishlist_id = :wishlistId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->bindParam(':wishlistId', $wishlistId);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$entry) {
            header('Location: profile.php');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the user has confirmed the deletion
            if (isset($_POST['delete']) && $_POST['delete'] === 'deleteWishlist') {
                // Delete wishlist entry by ID
                $delete = "DELETE FROM tbl_wishlist WHERE user_email = :userEmail AND wishlist_id = :wishlistId";
                $stmt = $conn->prepare($delete);
                $stmt->bindParam(':userEmail', $userEmail);
                $stmt->bindParam(':wishlistId', $wishlistId);
                $stmt->execute();
    
                echo "<script>alert('Delete successful!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            } else {
                echo "<script>alert('Delete failed!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            }
        }
    }
?>