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
        <form action="./admin.php" method="post" class="login-form">
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
    </div>
</body>
</html>