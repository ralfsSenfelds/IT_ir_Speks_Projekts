<?php
require('../assets/crud_operations.php');
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$lietotajavards = $_SESSION['username'];
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