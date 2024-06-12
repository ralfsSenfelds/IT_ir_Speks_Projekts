<?php
require "./adminassets/adminheader.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define the number of aktualitates per page
$aktualitatesPerPage = 4;
// Determine the current page
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = intval($_GET['page']);
} else {
    $currentPage = 1;
}

// Calculate the offset for the SQL query
$offset = ($currentPage - 1) * $aktualitatesPerPage;

// Fetch aktualitates from the database
$sql = "SELECT COUNT(*) as total FROM itspeks_aktualitates";
$result = mysqli_query($savienojums, $sql);
$row = mysqli_fetch_assoc($result);
$totalAktualitates = $row['total'];
$totalPages = ceil($totalAktualitates / $aktualitatesPerPage);

// Modify SQL query to retrieve aktualitates for the current page
$sql = "SELECT * FROM itspeks_aktualitates ORDER BY Aktualitates_ID DESC LIMIT $offset, $aktualitatesPerPage";
$result = mysqli_query($savienojums, $sql);

// Check if any aktualitates are found
if (mysqli_num_rows($result) > 0) {
    $aktualitates = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $aktualitates = array();
}

// Delete aktualitates
if (isset($_POST['delete_news'])) {
    $id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM itspeks_aktualitates WHERE Aktualitates_ID = ?";
    $delete_stmt = $savienojums->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id);
    $delete_stmt->execute();
    header("Location: aktualitates.php");
    exit();
}

// Edit aktualitates
if (isset($_POST['edit_news'])) {
    $id = $_POST['edit_id'];
    $virsraksts = $_POST['edit_virsraksts'];
    $teksts = $_POST['edit_teksts'];
    $attels = isset($_FILES['edit_attels']) ? $_FILES['edit_attels'] : null;

    // Fetch existing image data
    $existing_aktualitate_query = "SELECT Attels FROM itspeks_aktualitates WHERE Aktualitates_ID = ?";
    $stmt = $savienojums->prepare($existing_aktualitate_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $existing_aktualitate_result = $stmt->get_result();
    $existing_aktualitate_data = $existing_aktualitate_result->fetch_assoc();

    // Extract existing image data
    $existing_attels_data = $existing_aktualitate_data['Attels'];

    if ($attels && $attels['size'] > 0) {
        // If a new image is uploaded, update the image data
        $attels_data = file_get_contents($attels['tmp_name']);
    } else {
        // Otherwise, keep the existing image data
        $attels_data = $existing_attels_data;
    }

    $sql = "UPDATE itspeks_aktualitates SET Virsraksts = ?, Teksts = ?, Attels = ? WHERE Aktualitates_ID = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("sssi", $virsraksts, $teksts, $attels_data, $id);
    $stmt->execute();
    header("Location: aktualitates.php");
    exit();
}

// Add aktualitates
if (isset($_POST['add_news'])) {
    $virsraksts = $_POST['virsraksts'];
    $teksts = $_POST['teksts'];
    $attels = $_FILES['attels'];

    $attels_data = file_get_contents($attels['tmp_name']);
    $sql = "INSERT INTO itspeks_aktualitates (Virsraksts, Teksts, Attels, Pievienosanas_laiks) VALUES (?, ?, ?, NOW())";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("sss", $virsraksts, $teksts, $attels_data);
    $stmt->execute();
    header("Location: aktualitates.php");
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
            <div class="news-panel">
                <h2>Aktualitātes</h2>
                <button id="addNewsBtn" class="btn">Pievienot aktualitāti</button>
                <div class="news-list">
                    <?php foreach ($aktualitates as $aktualitate): ?>
                        <div class="news-item">
                            <h3><?php echo htmlspecialchars($aktualitate['Virsraksts']); ?></h3>
                            <p><?php echo htmlspecialchars($aktualitate['Teksts']); ?></p>
                            <button class="edit-btn" 
                                data-id="<?php echo $aktualitate['Aktualitates_ID']; ?>"
                                data-virsraksts="<?php echo htmlspecialchars($aktualitate['Virsraksts']); ?>"
                                data-teksts="<?php echo htmlspecialchars($aktualitate['Teksts']); ?>"
                                data-existing-image="data:image/jpeg;base64,<?php echo base64_encode($aktualitate['Attels']); ?>">Rediģēt</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $aktualitate['Aktualitates_ID']; ?>">
                                <button type="submit" name="delete_news" class="delete-btn">Dzēst</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="btn <?php if ($i == $currentPage) echo 'active'; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop up pievienošana -->
    <div id="addNewsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Pievienot aktualitāti</h2>
            <form method="POST" action="aktualitates.php" enctype="multipart/form-data">
            <label for="virsraksts">Virsraksts:</label>
            <input type="text" id="virsraksts" name="virsraksts" required>
            <label for="teksts">Teksts:</label>
            <textarea id="teksts" name="teksts" required></textarea>
            <label for="attels">Attēls:</label>
            <input type="file" id="attels" name="attels" accept="image/*" required>
            <button type="submit" name="add_news" class="btn">Pievienot</button>
            </form>
        </div>
    </div>
    <!-- Pop up rediģēšana -->
    <div id="editNewsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Rediģēt aktualitāti</h2>
            <form id="editForm" method="POST" action="aktualitates.php" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="edit_id">
                <label for="edit_virsraksts">Virsraksts:</label>
                <input type="text" id="edit_virsraksts" name="edit_virsraksts" required>
                <label for="edit_teksts">Teksts:</label>
                <textarea id="edit_teksts" name="edit_teksts" required></textarea>
                <label for="edit_attels">Esošais Attēls:</label>
                <img id="existingImage" src="" alt="Attēls" style="max-width: 200px; height: auto;">
                <label for="edit_attels">Jauns Attēls:</label>
                <input type="file" id="edit_attels" name="edit_attels" accept="image/*">
                <button type="submit" name="edit_news" class="btn">Saglabāt</button>
            </form>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const addNewsBtn = document.getElementById('addNewsBtn');
    const addNewsModal = document.getElementById('addNewsModal');
    const editNewsModal = document.getElementById('editNewsModal');
    const closeBtns = document.querySelectorAll('.close');

    // Function to close modals
    function closeModals() {
        addNewsModal.style.display = 'none';
        editNewsModal.style.display = 'none';
    }

    // Open add news pop-up
    addNewsBtn.addEventListener('click', function() {
        addNewsModal.style.display = 'block';
    });

    // Open edit news pop-up and populate form fields with existing data
    document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
        editBtn.addEventListener('click', function() {
            const id = editBtn.getAttribute('data-id');
            const virsraksts = editBtn.getAttribute('data-virsraksts');
            const teksts = editBtn.getAttribute('data-teksts');
            const existingImage = editBtn.getAttribute('data-existing-image');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_virsraksts').value = virsraksts;
            document.getElementById('edit_teksts').value = teksts;
            document.getElementById('existingImage').src = existingImage;

            editNewsModal.style.display = 'block';
        });
    });

    // Close pop-up
    closeBtns.forEach(function(btn) {
        btn.addEventListener('click', closeModals);
    });

    // Close pop-up when clicked outside
    window.addEventListener('click', function(event) {
        if (event.target === addNewsModal || event.target === editNewsModal) {
            closeModals();
        }
    });
});
</script>
</body>
</html>