<?php
// Check if session is not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servers = "localhost";
$lietotajs = "grobina1_bumerts";
$parole = "2miFCXDR!";
$db_nosaukums = "grobina1_bumerts";

$savienojums = mysqli_connect($servers, $lietotajs, $parole, $db_nosaukums);

if (!$savienojums) {
    die("Kļūda ar datubāzi: " . mysqli_connect_error());
}

// User Authentication
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    $lietotajvards = mysqli_real_escape_string($savienojums, $_POST["username"]);
    $parole = mysqli_real_escape_string($savienojums, $_POST["password"]);
    $sql = "SELECT * FROM itspeks_lietotaji WHERE Lietotajvards = '$lietotajvards'";
    $rezultats = mysqli_query($savienojums, $sql);

    if (mysqli_num_rows($rezultats) == 1) {
        $user = mysqli_fetch_assoc($rezultats);
        if (password_verify($parole, $user["Parole"])) {
            $_SESSION["username"] = $user["Lietotajvards"];
            header("Location: ../admin/admin.php");
            exit(); 
        } else {
            $error_message = "Incorrect username or password!";
        }
    } else {
        $error_message = "Incorrect username or password!";
    }
}

// Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST["name"], $_POST["surname"], $_POST["phone"], $_POST["email"], $_FILES["cv"])) {
        // Check for file upload errors
        if ($_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
            echo "File upload failed with error code: " . $_FILES['cv']['error'];
            exit;
        }
        
        try {
            // Prepare SQL statement
            $stmt = $savienojums->prepare("INSERT INTO itspeks_lietotaji (Vards, Uzvards, Telefons, Epasts, CV) VALUES (?, ?, ?, ?, ?)");

            // Bind parameters
            $stmt->bind_param('sssss', $_POST["name"], $_POST["surname"], $_POST["phone"], $_POST["email"], $cv_data);
            
            // Read the file content
            $cv_data = file_get_contents($_FILES["cv"]["tmp_name"]);

            // Execute the statement
            $stmt->execute();

            echo "Application submitted successfully!";
        } catch (Exception $e) {
            echo "Error submitting application: " . $e->getMessage();
        }
    } else {
        echo "All fields are required!";
    }
}
?>