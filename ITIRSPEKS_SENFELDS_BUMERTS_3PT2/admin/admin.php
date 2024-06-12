<?php
require("./adminassets/adminheader.php");
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
        <div class="kopsavilkums">
            <div class="content-box">
                <span>
                    <?php 
                    // Total number of vacancies query
                    $totalSQL = "SELECT COUNT(*) as total FROM itspeks_vakances";
                    $totalResult = mysqli_query($savienojums, $totalSQL);
                    $totalRow = mysqli_fetch_assoc($totalResult);
                    $totalVacancies = $totalRow['total'];
                    $totalPages = ceil($totalVacancies / $vacanciesPerPage);
                    echo $totalVacancies;
                    ?>
                </span>
                <div>
                    <h3>Aktīvo vakanču skaits</h3>
                    <p>Kuras pieejamas lietotājiem</p>
                </div>
            </div>
            <div class="content-box">
                <span>
                    <?php 
                    // Count of applications without 'Gaida pārbaudi' status
                    $unprocessedSQL = "SELECT COUNT(*) as total FROM itspeks_pieteikumi WHERE statuss <> 'Gaida pārbaudi'";
                    $unprocessedResult = mysqli_query($savienojums, $unprocessedSQL);
                    $unprocessedRow = mysqli_fetch_assoc($unprocessedResult);
                    $unprocessedApplications = $unprocessedRow['total'];
                    echo $unprocessedApplications;
                    ?>
                </span>
                <div>
                    <h3>Pārbaudītas vakances</h3>
                    <p>Kopš darbības uzsākšanas</p>
                </div>
            </div>
            <div class="content-box">
                <span>
                    <?php 
                    // Fetch aktualitates from the database
                    $sql = "SELECT COUNT(*) as total FROM itspeks_aktualitates";
                    $result = mysqli_query($savienojums, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $totalAktualitates = $row['total'];
                    $totalPages = ceil($totalAktualitates / $aktualitatesPerPage);
                    echo $totalAktualitates;
                    ?>
                </span>
                <div>
                    <h3>Aktualitāšu skaits</h3>
                    <p>Kopš darbības uzsākšanas</p>
                </div>
            </div>
            <div class="content-box">
                <span>
                    <?php 
                    $sql_moderatoruskaits = "SELECT COUNT(LietotajsID) AS active_mods FROM itspeks_lietotaji";
                    $sql_moderatori_atlasa = mysqli_query($savienojums, $sql_moderatoruskaits);

                    if (!$sql_moderatori_atlasa) {
                        die("SQL query failed: " . mysqli_error($savienojums));
                    }

                    $row = mysqli_fetch_assoc($sql_moderatori_atlasa);
                    $active_mods_count = $row['active_mods'];
                    echo $active_mods_count;
                    ?>
                </span>
                <div>
                    <h3>Aktīvi moderatori/administratori</h3>
                    <p>Kuri darbojas uzņēmumā</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
