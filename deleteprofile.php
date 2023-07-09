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
?>