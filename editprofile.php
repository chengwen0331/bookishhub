<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Assuming you have a database connection established
    require 'dbconnect.php';

    if (isset($_POST['addressId']) && isset($_POST['userId'])) {
        // Get the address ID from the request
        $addressId = $_POST['addressId'];
        $userId = $_POST['userId'];

        // Prepare the query to fetch the address details by the address ID
        $query = "SELECT * FROM tbl_address WHERE address_id = :addressId AND user_id = :userId";
        $stmt = $conn->prepare($query);

        // Bind the parameter values
        $stmt->bindParam(':addressId', $addressId);
        $stmt->bindParam(':userId', $userId);

        // Execute the query
        if ($stmt->execute()) {
            // Fetch the address details as an associative array
            $addressDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            // Return the address details as JSON response
            echo json_encode($addressDetails);
        } else {
            // Handle query error case if necessary
            echo json_encode(['error' => 'Failed to retrieve address details.']);
        }
    }

    if (isset($_POST['editaddress'])) {
        // Retrieve form values
        $addid = $_POST['addid1'];
        $uid = $_POST['id1'];
        $fullname = $_POST['addname1'];
        $addphone = $_POST['addphone1'];
        $address1 = $_POST['add1i'];
        $address2 = $_POST['add2i'];
        $address3 = $_POST['add3i'];
        $city = $_POST['city1'];
        $code = $_POST['postalcode1'];
        $state = $_POST['state1'];
        $country = $_POST['country1'];
        $labelas = $_POST['label1'];

        // Update SQL statement with placeholders
        $sqledit = "UPDATE tbl_address SET address1=:address1, address2=:address2, address3=:address3, city=:city, state=:state, country=:country, postalcode=:postalcode, label=:labelas, address_name=:fullname, address_phone=:addphone WHERE address_id=:addid AND user_id=:uid";

        // Prepare the update query
        $stmt = $conn->prepare($sqledit);

        // Bind the parameter values
        $stmt->bindParam(':address1', $address1);
        $stmt->bindParam(':address2', $address2);
        $stmt->bindParam(':address3', $address3);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':postalcode', $code);
        $stmt->bindParam(':labelas', $labelas);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':addphone', $addphone);
        $stmt->bindParam(':addid', $addid);
        $stmt->bindParam(':uid', $uid);

        // Execute the update query
        if ($stmt->execute()) {
            // Check if any rows were affected by the update
            $number_of_rows = $stmt->rowCount();
            if ($number_of_rows > 0) {
                echo "<script>alert('Update address successful!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            } else {
                echo "<script>alert('Update address Failed!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            }
        } else {
            // Handle update query error case if necessary
            $errorInfo = $stmt->errorInfo();
            echo "<script>alert('Update failed! Error: " . $errorInfo[2] . "')</script>";
            echo "<script>window.location.replace('profile.php')</script>";
        }
    }
    if (isset($_POST['cardId']) && isset($_POST['userId'])) {
        // Get the address ID from the request
        $cardId = $_POST['cardId'];
        $userId = $_POST['userId'];
    
        // Prepare the query to fetch the address details by the address ID
        $query = "SELECT * FROM tbl_card WHERE card_id = :cardId AND user_id = :userId";
        $stmt = $conn->prepare($query);
    
        // Bind the parameter values
        $stmt->bindParam(':cardId', $cardId);
        $stmt->bindParam(':userId', $userId);
    
        // Execute the query
        if ($stmt->execute()) {
            // Fetch the address details as an associative array
            $cardDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Return the address details as JSON response
            echo json_encode($cardDetails);
        } else {
            // Handle query error case if necessary
            echo json_encode(['error' => 'Failed to retrieve address details.']);
        }
    }
    if (isset($_POST['editcard'])) {
        // Retrieve form values
        $cardId = $_POST['cardid'];
        $userId = $_POST['uid'];
        $bank = $_POST['bank1'];
        $cardNumber = $_POST['cardno1'];
        $expiryDate = $_POST['expires1'];
        $ccv = $_POST['ccv1'];
        $nameOnCard = $_POST['cardname1'];
    
        // Update SQL statement with placeholders
        $sqledit = "UPDATE tbl_card SET card_bank=:bank, card_no=:cardNumber, card_expires=:expiryDate, ccv=:ccv, card_name=:nameOnCard WHERE card_id=:cardId AND user_id=:userId";
    
        // Prepare the update query
        $stmt = $conn->prepare($sqledit);
    
        // Bind the parameter values
        $stmt->bindParam(':bank', $bank);
        $stmt->bindParam(':cardNumber', $cardNumber);
        $stmt->bindParam(':expiryDate', $expiryDate);
        $stmt->bindParam(':ccv', $ccv);
        $stmt->bindParam(':nameOnCard', $nameOnCard);
        $stmt->bindParam(':cardId', $cardId);
        $stmt->bindParam(':userId', $userId);
    
        // Execute the update query
        if ($stmt->execute()) {
            // Check if any rows were affected by the update
            $number_of_rows = $stmt->rowCount();
            if ($number_of_rows > 0) {
                echo "<script>alert('Update card successful!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            } else {
                echo "<script>alert('Update card Failed!')</script>";
                echo "<script>window.location.replace('profile.php')</script>";
            }
        } else {
            // Handle update query error case if necessary
            $errorInfo = $stmt->errorInfo();
            echo "<script>alert('Update failed! Error: " . $errorInfo[2] . "')</script>";
            echo "<script>window.location.replace('profile.php')</script>";
        }
    }
?>