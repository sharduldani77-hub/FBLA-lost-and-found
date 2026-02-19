<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pinemill_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemID = $_POST['itemID'];
    $firstName = $_POST['claimantFirst'];
    $lastName = $_POST['claimantLast'];
    $email = $_POST['claimantEmail'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // STEP 1: Copy item data from 'users' to 'claimed_items'
        $moveSql = "INSERT INTO claimed_items (id, imageTitle, image_path, imageDescription) 
                    SELECT id, imageTitle, image_path, imageDescription 
                    FROM users WHERE id = ?";
        $stmt1 = $conn->prepare($moveSql);
        $stmt1->bind_param("i", $itemID);
        $stmt1->execute();

        // STEP 2: Register the claimant's info in 'claim_logs'
        $logSql = "INSERT INTO claim_logs (item_id, claimantFirst, claimantLast, claimantEmail) 
                   VALUES (?, ?, ?, ?)";
        $stmt2 = $conn->prepare($logSql);
        $stmt2->bind_param("isss", $itemID, $firstName, $lastName, $email);
        $stmt2->execute();

        // STEP 3: Remove the item from the active 'users' table
        $deleteSql = "DELETE FROM users WHERE id = ?";
        $stmt3 = $conn->prepare($deleteSql);
        $stmt3->bind_param("i", $itemID);
        $stmt3->execute();

        // If we got here, commit the changes
        $conn->commit();
        header("Location: gallery.php?status=success");
        exit();

    } catch (Exception $e) {
        // If anything fails, undo everything
        $conn->rollback();
        echo "Error processing claim: " . $e->getMessage();
    }
}

$conn->close();
?>