<?php
require "./adminassets/adminheader.php";

// Fetch user details including Moderators value
$lietotajavards = $_SESSION['username'];
$userQuery = "SELECT Moderators FROM itspeks_lietotaji WHERE Lietotajvards = '$lietotajavards'";
$result = mysqli_query($savienojums, $userQuery);

if (!$result) {
    die("Database query failed."); // Handle database error as appropriate
}

$user = mysqli_fetch_assoc($result);
$moderators = $user['Moderators'];

// Check if the user is a moderator
if ($moderators == 1) {
    // Redirect to another page or display an error message
    header("Location: unauthorized.php");
    exit(); // Stop further execution
}

// Function to fetch all users
function getAllUsers() {
    global $savienojums;
    $users = array();
    $sql = "SELECT * FROM itspeks_lietotaji";
    $result = mysqli_query($savienojums, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

// Function to update moderator status
function updateModeratorStatus($lietotajs_id, $moderator_status) {
    global $savienojums;
    $sql = "UPDATE itspeks_lietotaji SET Moderators = $moderator_status WHERE LietotajsID = $lietotajs_id";
    mysqli_query($savienojums, $sql);
}

// Check form submission to update moderator status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lietotajs_id']) && isset($_POST['moderator_status'])) {
    $lietotajs_id = $_POST['lietotajs_id'];
    $moderator_status = $_POST['moderator_status'];
    updateModeratorStatus($lietotajs_id, $moderator_status);
}

// Fetch all users
$users = getAllUsers();
?>

<body class="admin-page">
    <div class="admin-panel">
        <div class="sidebar">
            <a href="admin.php"><h1>Admin panelis</h1></a>
            <ul>
                <li><a href="vakances.php">Vakances</a></li>
                <li><a href="aktualitates.php">Aktualitātes</a></li>
                <li><a href="pieteikumi.php">Pieteikumi</a></li>
                <li><a href="darbinieki.php">Darbinieki</a></li>
            </ul>
            <div class="bottom-link">
                <a href="../index.php">Sākumlapa</a>
            </div>
        </div>

        <div class="content">
            <h2>Darbinieki</h2>
            <table class="adminTable">
                <tr>
                    <th>Lietotāja ID</th>
                    <th>Lietotājvārds</th>
                    <th>Moderators</th>
                    <th>Darbība</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['LietotajsID'] ?></td>
                    <td><?= $user['Lietotajvards'] ?></td>
                    <td><?= $user['Moderators'] == 1 ? 'Jā' : 'Nē' ?></td>
                    <td>
                        <?php if ($user['Moderators'] == 1): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="lietotajs_id" value="<?= $user['LietotajsID'] ?>">
                                <input type="hidden" name="moderator_status" value="0">
                                <button type="submit">Noņemt moderatora tiesības</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="">
                                <input type="hidden" name="lietotajs_id" value="<?= $user['LietotajsID'] ?>">
                                <input type="hidden" name="moderator_status" value="1">
                                <button type="submit">Piešķirt moderatora tiesības</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
<style>
    .adminTable {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .adminTable th,
    .adminTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .adminTable th {
        background-color: #107e4b;
        text-align: left;
    }

    .adminTable th:first-child,
    .adminTable td:first-child {
        text-align: left;
    }

    .adminTable td button {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .adminTable td button:hover {
        background-color: #16c373;
        color: white;
    }

    .adminTable td button.accept {
        background-color: #28a745;
    }

    .adminTable td button.reject {
        background-color: #dc3545;
    }

    .adminTable td button.disabled {
        background-color: grey;
        cursor: not-allowed;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .page-counter {
        font-size: 13px;
    }

    .btn {
        text-decoration: none;
        padding: 5px 10px;
        margin: 2px;
        background-color: #107e4b;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn.disabled {
        background-color: grey;
        cursor: not-allowed;
    }

    .btn:hover {
        background-color: #16c373;
    }
</style>
</html>