<?php require('assets/header.php'); ?>
<?php require('assets/crud_operations.php'); ?>
<link rel="stylesheet" href="aktualitatesstyle.css">
<section id="jaunumu_saraksts" class="container">
    <div>
        <h1 class="nodalas_virsraksts">Aktualitātes</h1>
    </div>
    <div class="boxes">
        <?php
        // Establish database connection
        $connection = mysqli_connect($servers, $lietotajs, $parole, $db_nosaukums);
        
        // Check if connection was successful
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Query to fetch news from the database
        $query = "SELECT Aktualitates_ID, Attels, Virsraksts, Teksts FROM itspeks_aktualitates ORDER BY Pievienosanas_laiks DESC LIMIT 6";
        $result = mysqli_query($connection, $query);

        // Check if there are any results
        if (mysqli_num_rows($result) > 0) {
            // Loop through the results and display each one
            while ($row = mysqli_fetch_assoc($result)) {
                $imageData = base64_encode($row['Attels']);
                // Determine image type based on the magic number (first bytes of the file)
                $imageType = 'image/jpeg';
                if (strpos($imageData, '/9j/') === 0) { // JPEG magic number
                    $imageType = 'image/jpeg';
                } elseif (strpos($imageData, 'iVBORw0KGgoAAAANSUhEUgAAAB') === 0) { // PNG magic number
                    $imageType = 'image/png';
                }
                echo '<div class="box">';
                echo '<div class="image-container">';
                echo '<img src="data:' . $imageType . ';base64,' . $imageData . '" alt="Image">';
                echo '</div>';
                echo '<div class="text-container">';
                echo '<h3>' . htmlspecialchars($row['Virsraksts']) . '</h3>';
                // Truncate the news text to a certain number of characters
                $text = htmlspecialchars($row['Teksts']);
                $max_length = 150; // Maximum number of characters to display
                if (strlen($text) > $max_length) {
                    $text = substr($text, 0, $max_length) . '...';
                }
                echo '<p>' . $text . '</p>';
                echo '<button class="read-more-btn" data-title="' . htmlspecialchars($row['Virsraksts']) . '" data-text="' . htmlspecialchars($row['Teksts']) . '" data-image="data:' . $imageType . ';base64,' . $imageData . '">Lasīt vairāk</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Nav pieejamu aktualitāšu.</p>';
        }

        mysqli_close($connection);
        ?>
    </div>
</section>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h3 id="modal-title"></h3>
        <img id="modal-image" alt="Image">
        <p id="modal-text"></p>
    </div>
</div>

<?php require('assets/footer.php'); ?>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById("modal");
    var modalTitle = document.getElementById("modal-title");
    var modalImage = document.getElementById("modal-image");
    var modalText = document.getElementById("modal-text");
    var closeBtn = document.getElementsByClassName("close-btn")[0];

    document.querySelectorAll('.read-more-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var title = this.getAttribute('data-title');
            var text = this.getAttribute('data-text');
            var image = this.getAttribute('data-image');

            modalTitle.textContent = title;
            modalImage.src = image;
            modalText.textContent = text;
            modal.style.display = "block";
            document.body.style.overflow = "hidden"; // Prevent scrolling
        });
    });
    closeBtn.onclick = function () {
        modal.style.display = "none";
        document.body.style.overflow = "auto"; // Enable scrolling
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
            document.body.style.overflow = "auto"; // Enable scrolling
        }
    }
});
</script>

<style>

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.6);
    padding: 20px; /* Padding for some spacing around the modal */
    overflow-y: hidden; /* Prevent scrolling */
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* Auto margin for centering vertically */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Set a specific width */
    max-width: 600px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    max-height: 80%; /* Ensure modal does not exceed viewport height */
    overflow-y: auto; /* Allow scrolling within the modal */
    text-align: center; /* Center text within the modal */
}

.read-more-btn {
    display: block; /* Change to block element */
    margin: 0 auto; /* Center horizontally */
    background-color: var(--maincolor);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
}

.close-btn {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-btn:hover,
.close-btn:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-content img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

h3 {
    font-size: 24px; /* Reduced font size for the modal title */
    margin-bottom: 10px;
}

p {
    font-size: 16px; /* Reduced font size for the modal text */
    line-height: 1.4; /* Adjusted line height for better readability */
}
.read-more-btn:hover {
    background-color: var(--maincolor-light);
}

</style>
