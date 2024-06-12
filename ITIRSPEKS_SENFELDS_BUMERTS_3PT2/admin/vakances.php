<?php
require "./adminassets/adminheader.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pagination setup
$vacanciesPerPage = 4;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}
$offset = ($currentPage - 1) * $vacanciesPerPage;

// Total number of vacancies query
$totalSQL = "SELECT COUNT(*) as total FROM itspeks_vakances";
$totalResult = mysqli_query($savienojums, $totalSQL);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalVacancies = $totalRow['total'];
$totalPages = ceil($totalVacancies / $vacanciesPerPage);

// Vacancies query for the current page
$piet_SQL = "SELECT * FROM itspeks_vakances
             ORDER BY Vakances_ID DESC
             LIMIT $vacanciesPerPage OFFSET $offset";
$atlasa_piet_SQL = mysqli_query($savienojums, $piet_SQL);

// Fetch vacancies
$vacancies = mysqli_fetch_all($atlasa_piet_SQL, MYSQLI_ASSOC);

// Delete vacancy
if (isset($_POST['delete_vacancy'])) {
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM itspeks_vakances WHERE Vakances_ID = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: vakances.php");
    exit();
}

// Edit vacancy
if (isset($_POST['edit_vacancy'])) {
    $id = $_POST['edit_id'];
    $kompanija = $_POST['edit_kompanija'];
    $apraksts = $_POST['edit_apraksts'];
    $vakance = $_POST['edit_vakance'];
    $alga = $_POST['edit_alga'];
    $atrasanas = $_POST['edit_atrasanas'];
    $attels = isset($_FILES['edit_attels']) ? $_FILES['edit_attels'] : null;

    // Fetch existing image data
    $existing_vacancy_query = "SELECT Attels FROM itspeks_vakances WHERE Vakances_ID = ?";
    $stmt = $savienojums->prepare($existing_vacancy_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $existing_vacancy_result = $stmt->get_result();
    $existing_vacancy_data = $existing_vacancy_result->fetch_assoc();

    // Extract existing image data
    $existing_attels_data = $existing_vacancy_data['Attels'];

    if ($attels && $attels['size'] > 0) {
        // If a new image is uploaded, update the image data
        $attels_data = file_get_contents($attels['tmp_name']);
    } else {
        // Otherwise, keep the existing image data
        $attels_data = $existing_attels_data;
    }

    $sql = "UPDATE itspeks_vakances SET Kompanija = ?, Apraksts = ?, Vakance = ?, Alga = ?, Atrasanas = ?, Attels = ? WHERE Vakances_ID = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("sssdssi", $kompanija, $apraksts, $vakance, $alga, $atrasanas, $attels_data, $id);

    $stmt->execute();
    header("Location: vakances.php");
    exit();
}

// Add vacancy
if (isset($_POST['add_vacancy'])) {
    $kompanija = $_POST['kompanija'];
    $apraksts = $_POST['apraksts'];
    $vakance = $_POST['vakance'];
    $alga = $_POST['alga'];
    $atrasanas = $_POST['atrasanas'];
    $attels = $_FILES['attels'];

    $attels_data = file_get_contents($attels['tmp_name']);
    $sql = "INSERT INTO itspeks_vakances (Kompanija, Apraksts, Vakance, Alga, Atrasanas, Attels, Pievienosanas_laiks) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("sssdss", $kompanija, $apraksts, $vakance, $alga, $atrasanas, $attels_data);
    $stmt->execute();
    header("Location: vakances.php");
    exit();
}
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
        <div class="vacancies-panel">
            <h2>Vakances</h2>
            <button id="addVacancyBtn" class="btn">Pievienot vakanci</button>
            <div class="vacancy-list">
                <?php foreach ($vacancies as $vacancy): ?>
                    <div class="vacancy-item">
                        <h3><?php echo htmlspecialchars($vacancy['Kompanija']); ?></h3>
                        <p>Apraksts: <?php echo htmlspecialchars($vacancy['Apraksts']); ?></p>
                        <p>Vakance: <?php echo htmlspecialchars($vacancy['Vakance']); ?></p>
                        <p>Alga: $<?php echo htmlspecialchars($vacancy['Alga']); ?></p>
                        <p>Atrašanās vieta: <?php echo htmlspecialchars($vacancy['Atrasanas']); ?></p>
                        <p>Pievienošanas laiks: <?php echo htmlspecialchars($vacancy['Pievienosanas_laiks']); ?></p>
                        <button class="edit-btn" 
                            data-id="<?php echo $vacancy['Vakances_ID']; ?>"
                            data-kompanija="<?php echo htmlspecialchars($vacancy['Kompanija']); ?>"
                            data-apraksts="<?php echo htmlspecialchars($vacancy['Apraksts']); ?>"
                            data-vakance="<?php echo htmlspecialchars($vacancy['Vakance']); ?>"
                            data-alga="<?php echo htmlspecialchars($vacancy['Alga']); ?>"
                            data-atrasanas="<?php echo htmlspecialchars($vacancy['Atrasanas']); ?>"
                            data-existing-image="data:image/jpeg;base64,<?php echo base64_encode($vacancy['Attels']); ?>">Rediģēt</button>
                        <form method="POST" action="vakances.php" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $vacancy['Vakances_ID']; ?>">
                            <button type="submit" name="delete_vacancy" class="delete-btn">Dzēst</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="btn <?php if ($i == $currentPage) echo 'active'; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

    <!-- Pop up pievienošana -->
    <div id="addVacancyModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Pievienot vakanci</h2>
            <form method="POST" action="vakances.php" enctype="multipart/form-data">
                <label for="kompanija">Kompanija:</label>
                <input type="text" id="kompanija" name="kompanija" required>
                <label for="apraksts">Apraksts:</label>
                <textarea id="apraksts" name="apraksts" required></textarea>
                <label for="vakance">Vakance:</label>
                <input type="text" id="vakance" name="vakance" required>
                <label for="alga">Alga:</label>
                <input type="number" id="alga" name="alga" required>
                <label for="atrasanas">Atrašanās vieta:</label>
                <input type="text" id="atrasanas" name="atrasanas" required>
                <label for="attels">Attēls:</label>
                <input type="file" id="attels" name="attels" accept="image/*" required>
                <button type="submit" name="add_vacancy" class="btn">Pievienot</button>
            </form>
        </div>
    </div>

    <!-- Pop up rediģēšana -->
    <div id="editVacancyModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Rediģēt vakanci</h2>
            <form id="editForm" method="POST" action="vakances.php" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="edit_id">
                <label for="edit_kompanija">Kompanija:</label>
                <input type="text" id="edit_kompanija" name="edit_kompanija" required>
                <label for="edit_apraksts">Apraksts:</label>
                <textarea id="edit_apraksts" name="edit_apraksts" required></textarea>
                <label for="edit_vakance">Vakance:</label>
                <input type="text" id="edit_vakance" name="edit_vakance" required>
                <label for="edit_alga">Alga:</label>
                <input type="number" id="edit_alga" name="edit_alga" required>
                <label for="edit_atrasanas">Atrašanās vieta:</label>
                <input type="text" id="edit_atrasanas" name="edit_atrasanas" required>
                
                <label for="edit_attels">Esošais Attēls:</label>
                <img id="existingImage" src="" alt="Attēls" style="max-width: 200px; height: auto;">
                
                <label for="edit_attels">Jauns Attēls:</label>
                <input type="file" id="edit_attels" name="edit_attels" accept="image/*">
                <button type="submit" name="edit_vacancy" class="btn">Saglabāt</button>
            </form>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addVacancyBtn = document.getElementById('addVacancyBtn');
        const addVacancyModal = document.getElementById('addVacancyModal');
        const editVacancyModal = document.getElementById('editVacancyModal');
        const closeBtns = document.querySelectorAll('.close');

        // Function to close modals
        function closeModals() {
            addVacancyModal.style.display = 'none';
            editVacancyModal.style.display = 'none';
        }

        // Open add vacancy pop-up
        addVacancyBtn.addEventListener('click', function() {
            addVacancyModal.style.display = 'block';
        });

        // Close pop-ups
        closeBtns.forEach(function(btn) {
            btn.addEventListener('click', closeModals);
        });

        // Open edit vacancy pop-up and populate form fields with existing data
        document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
            editBtn.addEventListener('click', function() {
                const id = editBtn.getAttribute('data-id');
                const kompanija = editBtn.getAttribute('data-kompanija');
                const apraksts = editBtn.getAttribute('data-apraksts');
                const vakance = editBtn.getAttribute('data-vakance');
                const alga = editBtn.getAttribute('data-alga');
                const atrasanas = editBtn.getAttribute('data-atrasanas');
                const existingImage = editBtn.getAttribute('data-existing-image');

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_kompanija').value = kompanija;
                document.getElementById('edit_apraksts').value = apraksts;
                document.getElementById('edit_vakance').value = vakance;
                document.getElementById('edit_alga').value = alga;
                document.getElementById('edit_atrasanas').value = atrasanas;
                document.getElementById('existingImage').src = existingImage;

                editVacancyModal.style.display = 'block';
            });
        });

        // Close pop-ups when clicked outside
        window.addEventListener('click', function(event) {
            if (event.target === addVacancyModal || event.target === editVacancyModal) {
                closeModals();
            }
        });
    });
</script>
