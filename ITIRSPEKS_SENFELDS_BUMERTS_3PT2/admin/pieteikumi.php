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

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['statuss'])) {
    $id = (int)$_POST['id'];
    $statuss = $_POST['statuss'];
    
    // Ensure the status is one of the allowed values
    $allowed_statuses = ['Pieņemts', 'Nepieņemts', 'Gaida pārbaudi'];
    if (in_array($statuss, $allowed_statuses)) {
        $query = "UPDATE itspeks_pieteikumi SET statuss = '$statuss' WHERE Pieteikuma_id = $id";
        mysqli_query($savienojums, $query);
    }
}

// Handle CV download
if (isset($_GET['download_id']) && is_numeric($_GET['download_id'])) {
    $id = (int)$_GET['download_id'];
    $query = "SELECT CV, Vards, Uzvards FROM itspeks_pieteikumi WHERE Pieteikuma_id = $id";
    $result = mysqli_query($savienojums, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cv = $row['CV'];
        $filename = $row['Vards'] . '_' . $row['Uzvards'] . '_CV.pdf'; // Assuming the file is a PDF
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $cv;
        exit;
    }
    header("Location: pieteikumi.php");
    exit;
}

// Set the number of applications per page
$applicationsPerPage = 12;

// Get the current page number from the URL, default to 1 if not set
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $applicationsPerPage;

// Get the total number of applications in the database
$totalSQL = "SELECT COUNT(*) as total FROM itspeks_pieteikumi";
$totalResult = mysqli_query($savienojums, $totalSQL);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalApplications = $totalRow['total'];
$totalPages = ceil($totalApplications / $applicationsPerPage);

// Fetch the applications for the current page
$pieteikumiSQL = "SELECT * FROM itspeks_pieteikumi ORDER BY Pieteiksanas_laiks DESC LIMIT $applicationsPerPage OFFSET $offset";
$pieteikumiResult = mysqli_query($savienojums, $pieteikumiSQL);
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
            <h2>Pieteikumi</h2>
            <table class="adminTable">
                <tr>
                    <th>Vārds</th>
                    <th>Uzvārds</th>
                    <th>Tālrunis</th>
                    <th>E-pasts</th>
                    <th>Kompanija</th>
                    <th>Vakance</th>
                    <th>Pieteikšanās laiks</th>
                    <th>CV</th>
                    <th>Statuss</th>
                    <th>Pieņemt</th>
                    <th>Nepieņemt</th>
                    <th>Gaida pārbaudi</th>
                </tr>
                <?php
                while ($pieteikums = mysqli_fetch_assoc($pieteikumiResult)) {
                    echo "
                    <tr>
                        <td>{$pieteikums['Vards']}</td>
                        <td>{$pieteikums['Uzvards']}</td>
                        <td>{$pieteikums['Talrunis']}</td>
                        <td>{$pieteikums['Epasts']}</td>
                        <td>{$pieteikums['Kompanija']}</td>
                        <td>{$pieteikums['Vakance']}</td>
                        <td>".date("d.m.Y. H:i", strtotime($pieteikums['Pieteiksanas_laiks']))."</td>
                        <td><a href='pieteikumi.php?download_id={$pieteikums['Pieteikuma_id']}'>View CV</a></td>
                        <td>{$pieteikums['statuss']}</td>
                        <td>
                            <form method='POST' action='pieteikumi.php'>
                                <input type='hidden' name='id' value='{$pieteikums['Pieteikuma_id']}'>
                                <input type='hidden' name='statuss' value='Pieņemts'>
                                <button type='submit' class='btn'><i class='fas fa-check'></i></button>
                            </form>
                        </td>
                        <td>
                            <form method='POST' action='pieteikumi.php'>
                                <input type='hidden' name='id' value='{$pieteikums['Pieteikuma_id']}'>
                                <input type='hidden' name='statuss' value='Nepieņemts'>
                                <button type='submit' class='btn'><i class='fas fa-times'></i></button>
                            </form>
                        </td>
                        <td>
                            <form method='POST' action='pieteikumi.php'>
                                <input type='hidden' name='id' value='{$pieteikums['Pieteikuma_id']}'>
                                <input type='hidden' name='statuss' value='Gaida pārbaudi'>
                                <button type='submit' class='btn'><i class='fas fa-clock'></i></button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </table>
            <!-- Pagination controls -->
            <div class="pagination">
                <a href="?page=<?= max($currentPage - 1, 1) ?>" class="btn <?= $currentPage == 1 ? 'disabled' : '' ?>">Iepriekšējā lapa</a>
                <a href="?page=<?= min($currentPage + 1, $totalPages) ?>" class="btn <?= $currentPage == $totalPages ? 'disabled' : '' ?>">Nākošā lapa</a>
            </div>
        </div>
    </div>
</body>
</html>

<style>
    .pagination {
        display: flex;
        justify-content: space-between;
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
    }

    .btn.disabled {
        background-color: grey;
        cursor: not-allowed;
    }

    .adminTable {
        width: 100%;
        border-collapse: collapse;
    }
    .adminTable th, .adminTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    
    .adminTable th {
        background-color: #f2f2f2;
        text-align: left;
    }
    .content {
        margin: 0 auto;
        padding: 20px;
    }
</style>
