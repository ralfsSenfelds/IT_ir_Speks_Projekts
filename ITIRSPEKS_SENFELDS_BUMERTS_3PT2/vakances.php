<?php require('assets/header.php'); ?>
<main>
    <style>
        .vacancies-table {
            width: 100%;
            border-collapse: collapse;
            padding: 1.2rem;
        }
        .vacancies-table th, .vacancies-table td {
            border: 1px solid #ddd;
            padding: 12px 8px;
            text-align: left;
            vertical-align: top;
        }
        .vacancies-table th {
            background: var(--maincolor);
            color: var(--textcolor);
        }
        .vacancy-row {
            display: flex;
            align-items: center;
        }
        .vacancy-row img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            border-radius: 50%;
        }
        .filter-container {
            padding: 20px;
            background: var(--maincolor);
            color: #eee;
            margin-bottom: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .filter-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-container div {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
            width: 100%;
        }
        .filter-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .filter-container select, .filter-container input {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            transition: border 0.3s ease;
        }
        .filter-container select:focus, .filter-container input:focus {
            border-color: var(--maincolor);
            outline: none;
        }
        .filter-button {
            background-color: var(--textcolor);
            color: var(--maincolor);
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        .filter-button:hover {
            background-color: var(--maincolor-light);
        }
        .atdalisana {
            background: var(--maincolor);
            color: #333;
            padding: 20px;
        }
        .pages,.apply-button {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .pages a, .apply-button {
            background-color: var(--maincolor);
            color: #eee;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .pages a:hover, .apply-button:hover {
            background-color: #555;
        }

    </style>
    <div class="atdalisana">
        <hr>
    </div>
    <div class="filter-container">
        <h1>Ar mums tu atradīsi savu sapņu darbu!</h1>
        <div>
            <label for="region-filter">Meklēt pēc atrašanās vietas:</label>
            <select id="region-filter">
                <option value="all">All</option>
                <option value="Rīgas rajons, Rīga">Rīgas rajons, Rīga</option>
                <option value="Kurzeme, Liepāja">Kurzeme, Liepāja</option>
                <option value="Kuldīgas rajons, Alsunga">Kuldīgas rajons, Alsunga</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <div>
            <label for="job-search">Meklēt pēc vakances:</label>
            <input type="text" id="job-search" class="search-bar" placeholder="Type a job title...">
        </div>
        <div>
            <label for="keyword-search">Meklēt pēc atslēgvārdiem:</label>
            <input type="text" id="keyword-search" class="search-bar" placeholder="Type keywords...">
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
            <tr style="">
                <td>
                    <div class="vacancy-row">
                        <img src="path_to_image_1.jpg" alt="Profile Picture">
                        AE Partner
                    </div>
                </td>
                <td>
                    <strong>Software Engineer</strong>
                    <p>Develop and maintain software applications. Collaborate with cross-functional teams to define, design, and ship new features. Ensure the performance, quality, and responsiveness of applications.</p>
                    <button class="apply-button">Apply</button>
                </td>
                <td>$100,000/year</td>
                <td>Kurzeme, Liepāja</td>
            </tr>
            <tr style="">
                <td>
                    <div class="vacancy-row">
                        <img src="path_to_image_2.jpg" alt="Profile Picture">
                        Draugiem.lv
                    </div>
                </td>
                <td>
                    <strong>Data Scientist</strong>
                    <p>Analyze large sets of data to derive actionable insights. Develop predictive models and algorithms. Work closely with stakeholders to understand business needs and provide data-driven solutions.</p>
                    <button class="apply-button">Apply</button>
                </td>
                <td>$95,000/year</td>
                <td>Kurzeme, Liepāja</td>
            </tr>
            <tr style="">
                <td>
                    <div class="vacancy-row">
                        <img src="path_to_image_2.jpg" alt="Profile Picture">
                        TestdevLab
                    </div>
                </td>
                <td>
                    <strong>Data Scientist</strong>
                    <p>Conduct advanced data analysis and design complex algorithms. Collaborate with engineering teams to deploy models into production. Communicate findings to technical and non-technical audiences.</p>
                    <button class="apply-button">Apply</button>
                </td>
                <td>$95,000/year</td>
                <td>Rīgas rajons, Rīga</td>
            </tr>
            <tr style="">
                <td>
                    <div class="vacancy-row">
                        <img src="path_to_image_2.jpg" alt="Profile Picture">
                        Digitalais inovāciju parks
                    </div>
                </td>
                <td>
                    <strong>Data Scientist</strong>
                    <p>Use statistical techniques to interpret data sets. Develop data collection processes and analytic systems. Generate reports that effectively communicate trends, patterns, and predictions using relevant data.</p>
                    <button class="apply-button">Apply</button>
                </td>
                <td>$95,000/year</td>
                <td>Kuldīgas rajons, Alsunga</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    <div class="pages">
        <a href="">Pirmā</a>
        <a href="">Nākamā</a>
    </div>

    <script>
        function filterTable() {
            var regionFilter = document.getElementById("region-filter").value.toLowerCase();
            var jobFilter = document.getElementById("job-search").value.toLowerCase();
            var keywordFilter = document.getElementById("keyword-search").value.toLowerCase();
            var table = document.getElementById("vacancies-table");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                var descriptionCell = rows[i].getElementsByTagName("td")[1];
                var regionCell = rows[i].getElementsByTagName("td")[3];
                if (descriptionCell && regionCell) {
                    var jobTitle = descriptionCell.getElementsByTagName("strong")[0].textContent.toLowerCase();
                    var jobDescription = descriptionCell.getElementsByTagName("p")[0].textContent.toLowerCase();
                    var region = regionCell.textContent.toLowerCase();
                    if ((regionFilter === "all" || region.indexOf(regionFilter) > -1) && 
                        (jobTitle.indexOf(jobFilter) > -1) &&
                        (jobDescription.indexOf(keywordFilter) > -1)) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</main>
<?php require ('assets/footer.php'); ?>