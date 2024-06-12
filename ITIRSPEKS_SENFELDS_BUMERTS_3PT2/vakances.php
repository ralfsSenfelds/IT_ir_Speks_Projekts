<?php require('assets/header.php'); ?>
<?php require('assets/crud_vakances.php'); ?>
<main>
    <div class="atdalisana">
        <hr>
    </div>
    <div class="filter-container">
        <h1>Ar mums tu atradīsi savu sapņu darbu!</h1>
        <div>
            <label for="region-filter">Meklēt pēc atrašanās vietas:</label>
            <select id="region-filter">
                <option value="all">All</option>
                <?php
                // Query to fetch unique regions from the database
                $servers = "localhost";
                $lietotajs = "grobina1_bumerts";
                $parole = "2miFCXDR!";
                $db_nosaukums = "grobina1_bumerts";

                $savienojums = mysqli_connect($servers, $lietotajs, $parole, $db_nosaukums);
                $regionQuery = "SELECT DISTINCT Atrasanas FROM itspeks_vakances";
                $regionResult = mysqli_query($savienojums, $regionQuery);

                // Check if there are any results
                if ($regionResult && mysqli_num_rows($regionResult) > 0) {
                    // Loop through the results and populate the select element
                    while ($row = mysqli_fetch_assoc($regionResult)) {
                        echo "<option value='" . $row['Atrasanas'] . "'>" . $row['Atrasanas'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div>
            <label for="job-filter">Meklēt pēc vakances:</label>
            <input type="text" id="job-filter" class="search-bar" placeholder="Type a job title...">
        </div>
        <div>
            <label for="keyword-filter">Meklēt pēc atslēgvārdiem:</label>
            <input type="text" id="keyword-filter" class="search-bar" placeholder="Type keywords...">
        </div>
        <button class="filter-button" onclick="filterTable()">Search</button>
    </div>

    <table class="vacancies-table" id="vacancies-table">
        <thead>
            <tr>
                <th>Kompānija</th>
                <th>Apraksts</th>
                <th>Alga</th>
                <th>Novads, Pilsēta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Define pagination variables
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $vacanciesPerPage = 5;
            $offset = ($currentPage - 1) * $vacanciesPerPage;

            // Query to fetch paginated vacancies from the database
            $vacanciesQuery = "SELECT Vakances_ID, Kompanija, Vakance, Apraksts, Alga, Atrasanas, Attels FROM itspeks_vakances LIMIT $offset, $vacanciesPerPage";
            $vacanciesResult = mysqli_query($savienojums, $vacanciesQuery);

            // Check if there are any results
            if ($vacanciesResult && mysqli_num_rows($vacanciesResult) > 0) {
                // Loop through the results and display each vacancy
                while ($row = mysqli_fetch_assoc($vacanciesResult)) {
                    echo "<tr id='vacancy-" . $row['Vakances_ID'] . "'>";
                    echo "<td>";
                    echo "<div class='vacancy-row'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row['Attels']) . "' alt='Profile Picture'>";
                    echo "<span>" . $row['Kompanija'] . "</span>"; // Display company name
                    echo "</div>";
                    echo "</td>";
                    echo "<td>";
                    echo "<strong>" . $row['Vakance'] . "</strong>";
                    echo "<p>" . $row['Apraksts'] . "</p>";
                    echo "<button class='apply-button' onclick='applyForJob(\"" . $row['Kompanija'] . "\", \"" . $row['Vakance'] . "\")'>Pieteikties</button>"; // Pass company name and vacancy name to applyForJob function
                    echo "</td>";
                    echo "<td>" . $row['Alga'] . "/mēnesi</td>";
                    echo "<td>" . $row['Atrasanas'] . "</td>";
                    echo "</tr>";

                    // Debug statement to log job title
                    error_log("Job Title: " . $row['Vakance']);
                }
            } else {
                echo "<tr><td colspan='4'>No vacancies found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    // Query to count total vacancies
    $countQuery = "SELECT COUNT(*) AS total FROM itspeks_vakances";
    $countResult = mysqli_query($savienojums, $countQuery);
    $rowCount = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($rowCount / $vacanciesPerPage);

    // Display pagination
    echo "<div class='pages' id='pages'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='?page=$i'>$i</a>";
    }
    echo "</div>";
    ?>
</main>

<div id="apply-popup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePopup()"></span>
        <h2>Pieteikties pie <span id="company_name"></span></h2>
        <div id="error-message" class="error-message"></div> <!-- Placeholder for error message -->
        <form id="application-form" enctype="multipart/form-data">
            <!-- Hidden input fields for company name and vacancy -->
            <input type="hidden" id="company_name_hidden" name="company_name">
            <input type="hidden" id="vacancy_name_hidden" name="vacancy_name">
            <label for="name">Vards:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="surname">Uzvards:</label>
            <input type="text" id="surname" name="surname" required><br>
            <label for="phone">Talrunis:</label>
            <input type="text" id="phone" name="phone" required><br>
            <label for="email">Epasts:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="cv">CV:</label>
            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required><br>
            <input type="hidden" id="job_id" name="job_id" value="">
            <input type="submit" value="Nosūtīt">
        </form>
    </div>
</div>



<?php require ('assets/footer.php'); ?>


<script>
    function applyForJob(companyName, vacancyName) {
        document.getElementById("company_name").textContent = companyName;
        document.getElementById("company_name_hidden").value = companyName; // Set company name value
        document.getElementById("vacancy_name_hidden").value = vacancyName; // Set vacancy name value
        document.getElementById('apply-popup').style.display = 'block';
    }
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("application-form").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            // Serialize form data
            var formData = new FormData(this);

            // Send form data asynchronously to crud_operations.php
            fetch("assets/crud_vakances.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Display submission status
                    // Close the popup after submission
                    document.getElementById('apply-popup').style.display = 'none';
                    // Clear the form fields
                    document.getElementById("application-form").reset();
                })
                .catch(error => console.error('Error:', error));
        });
    });

    function closePopup() {
        document.getElementById('apply-popup').style.display = 'none';
    }

    function filterTable() {
    var jobFilter = document.getElementById("job-filter").value.trim().toLowerCase();
    var keywordFilter = document.getElementById("keyword-filter").value.trim().toLowerCase();
    var table = document.getElementById("vacancies-table");
    var rows = table.getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) { // Start from 1 to exclude the header row
        var jobTitleCell = rows[i].getElementsByTagName("td")[1]; // Adjust index to match the column containing job titles
        var descriptionCell = rows[i].getElementsByTagName("td")[2]; // Adjust index to match the column containing descriptions

        if (jobTitleCell && descriptionCell) {
            var jobTitle = jobTitleCell.textContent.trim().toLowerCase();
            var jobDescription = descriptionCell.textContent.trim().toLowerCase();

            var jobTitleMatch = jobTitle.includes(jobFilter) || jobTitle === jobFilter;
            var jobDescriptionMatch = jobDescription.includes(keywordFilter) || keywordFilter === '';

            if (jobTitleMatch && jobDescriptionMatch) {
                rows[i].style.display = rows[i].originalDisplay || ""; // Show the row if it matches the filter
            } else {
                // Hide the row if it doesn't match the filter, but remember its original display style
                rows[i].originalDisplay = rows[i].style.display;
                rows[i].style.display = "none";
            }
        }
    }
}
</script>


<style>
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #ffffff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    position: relative;
    animation: slideInUp 0.3s ease; /* Add animation for sliding in */
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 8px;
    background-color: transparent; /* Transparent background */
    color: #888888; /* Gray text */
    border: none;
    cursor: pointer;
    font-size: 20px;
    transition: color 0.3s ease; /* Smooth transition for color */
}

.close:hover {
    color: #333333; /* Darker gray on hover */
}

.close::before {
    content: "\00D7"; /* Unicode for close symbol (×) */
}

@keyframes slideInUp {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Modern Input Styles */
.modal-content form label {
    display: block;
    margin-bottom: 8px;
    color: #333333; /* Text color */
}

.modal-content form input[type="text"],
.modal-content form input[type="email"],
.modal-content form input[type="file"],
.modal-content form input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #cccccc; /* Border color */
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
    transition: border-color 0.3s ease; /* Smooth transition for border color */
}
.modal-content form input[type="submit"]{
    cursor: pointer;
    background-color: var(--maincolor);
    color: var(--textcolor);
}
.modal-content form input[type="submit"]:hover{
    cursor: pointer;
    background-color: var(--maincolor-light);
    color: var(--textcolor);
}
.modal-content form input[type="text"]:focus,
.modal-content form input[type="email"]:focus,
.modal-content form input[type="file"]:focus {
    border-color: #007bff; /* Focus border color */
    outline: none;
}

</style>