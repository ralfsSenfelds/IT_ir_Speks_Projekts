<?php
session_start();
require('../assets/crud_operations.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    $lietotajvards = mysqli_real_escape_string($savienojums, $_POST["username"]);
    $parole = mysqli_real_escape_string($savienojums, $_POST["password"]);

    $sql = "SELECT * FROM itspeks_lietotaji WHERE Lietotajvards = '$lietotajvards'";
    $rezultats = mysqli_query($savienojums, $sql);

    if (mysqli_num_rows($rezultats) == 1) {
        $user = mysqli_fetch_assoc($rezultats);
        if (password_verify($parole, $user["Parole"])) {
            $_SESSION["username"] = $user["Lietotajvards"];
            $_SESSION["role"] = $user["Moderators"]; // Store the role in session
            exit();
        } else {
            $error_message = "Incorrect username or password!";
        }
    } else {
        $error_message = "Incorrect username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT ir Spēks</title>
    <link rel="stylesheet" href="adminassets/adminstyle.css">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="assets/script.js"></script>
</head>
<body>
    <div class="container">
        <form action="login.php" method="post" class="login-form">
            <h2><img src="../assets/images/logo.png" alt=""> Login</h2>
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input class="input-box" type="text" name="username" placeholder="Lietotājvārds" required>
            </div>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input class="input-box" type="password" name="password" placeholder="Parole" required>
            </div>
            <input class="btn" type="submit" value="Apstiprināt">
        </form>
        <?php if(isset($error_message)): ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>