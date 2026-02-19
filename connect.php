<?php
// Database connection details
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "pinemill_registration";

// Create connection
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LOGIC FOR FEEDBACK FORM ---
    if (isset($_POST['feedback'])) {
        $feedbackText = $_POST['feedback'];

        // 'feedback_table' matches the table name in your image
$stmt = $conn->prepare("INSERT INTO feedback (feedback) VALUES (?)");        $stmt->bind_param("s", $feedbackText);

        if ($stmt->execute()) {
    // Redirect to homepage
    header("Location: homepage.html");
    exit(); 
        } else {
            echo "Database error: " . $stmt->error;
        }
        $stmt->close();
    } 
    
    // --- LOGIC FOR ORIGINAL REGISTRATION FORM ---
    else {
        // Retrieve registration form data
        $firstName = $_POST['firstName'] ?? '';
        $lastName  = $_POST['lastName'] ?? '';
        $email     = $_POST['email'] ?? '';
        $imageTitle = $_POST['imageTitle'] ?? '';
        $imageDescription = $_POST['imageDescription'] ?? '';
        $number = '';

        /* ---------- FILE UPLOAD ---------- */
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $image_path = "";
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
            $filename = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . time() . "_" . $filename;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                }
            }
        }

        /* ---------- DATABASE INSERT ---------- */
        $stmt = $conn->prepare("
            INSERT INTO users 
            (firstName, lastName, email, number, imageTitle, image_path, imageDescription)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("sssssss", $firstName, $lastName, $email, $number, $imageTitle, $image_path, $imageDescription);

        if ($stmt->execute()) {
    // Redirect to homepage
    header("Location: gallery.php");
    exit(); 
} else {
            echo "Database error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();

} else {
    echo "Access denied.";
}
?>