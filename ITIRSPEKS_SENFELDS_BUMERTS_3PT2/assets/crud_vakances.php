<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $name = mysqli_real_escape_string($savienojums, $_POST['name']);
    $surname = mysqli_real_escape_string($savienojums, $_POST['surname']);
    $phone = mysqli_real_escape_string($savienojums, $_POST['phone']);
    $email = mysqli_real_escape_string($savienojums, $_POST['email']);
    $companyName = mysqli_real_escape_string($savienojums, $_POST['company_name']); // Extract company name
    $vacancyName = mysqli_real_escape_string($savienojums, $_POST['vacancy_name']); // Extract vacancy name

    // Check if the file is uploaded and not empty
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $cvContent = file_get_contents($_FILES['cv']['tmp_name']);
        $cvContent = mysqli_real_escape_string($savienojums, $cvContent);
    } else {
        echo "Error: Please select a file to upload.";
        exit();
    }

    // Insert data into the database table
    $insertQuery = "INSERT INTO itspeks_pieteikumi (Vards, Uzvards, Talrunis, Epasts, Kompanija, Vakance, CV, Pieteiksanas_laiks) VALUES ('$name', '$surname', '$phone', '$email', '$companyName', '$vacancyName', '$cvContent', NOW())";
    $result = mysqli_query($savienojums, $insertQuery);

    // Check if the query was successful
    if ($result) {
        echo "Pieteikums nosūtīts!";
    } else {
        echo "Error: " . mysqli_error($savienojums);
    }
}

// Close the database connection
mysqli_close($savienojums);
?>
<?php

?> 