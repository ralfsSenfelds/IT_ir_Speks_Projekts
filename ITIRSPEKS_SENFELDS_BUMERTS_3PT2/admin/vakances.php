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

<style>
    :root {
    --maincolor: #107e4b;
    --radius: 0.7rem;
    --maincolor-light: #16c373;
    --bg: #ffffff;
    --textcolor: #fff;
    --textcolor2: #333;
    --textcolor3: #000;
    --hovercolor: #16c373;
    --border: 0.1rem solid rgba(0, 0, 0, 10%);
    --box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 10%);
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.admin-panel {
    display: flex;
    height: 100vh;
}

.sidebar {
    background-color: var(--maincolor);
    color: #fff;
    width: 250px;
    padding: 20px;
}

.sidebar h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar a {
    color: #fff;
    text-decoration: none;
}

.content {
    flex-grow: 1; /* Take remaining space */
}

.vacancies-panel {
    padding: 20px;
}

.vacancies-panel h2 {
    color: var(--textcolor3);
}

.vacancy-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjust as needed */
    grid-gap: 20px;
    margin-top: 20px;
}

.vacancy-item {
    background-color: var(--bg);
    border: var(--border);
    border-radius: var(--radius);
    box-shadow: var(--box-shadow);
    padding: 20px;
}

.vacancy-item h3 {
    margin-top: 0;
}

.edit-btn {
    background-color: var(--maincolor);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none; /* Ensure button looks like a button */
}

.edit-btn:hover {
    background-color: var(--hovercolor);
}

</style>
<body>
    <div class="admin-panel">
    <div class="sidebar">
            </h1><a href="admin.php"><h1>Admin panelis</h1></a>
            <ul>
                <li><a href="vakances.php">Vakances</a></li>
                <li><a href="aktualitates.php">Aktualitātes</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="vacancies-panel">
                <h2>Vakances</h2>
                <div class="vacancy-list">
                <div class="vacancy-item">
                    <h3>Kompanija A</h3>
                    <p>Apraksts: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <p>Alga: $5000</p>
                    <p>Novads: Riga</p>
                    <p>Pilsēta: Rīga</p>
                    <a href="edit_vacancy.html" class="edit-btn">Rediģēt</a>
                </div>
                <div class="vacancy-item">
                    <h3>Kompanija B</h3>
                    <p>Apraksts: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <p>Alga: $6000</p>
                    <p>Novads: Jelgava</p>
                    <p>Pilsēta: Jelgava</p>
                    <a href="edit_vacancy.html" class="edit-btn">Rediģēt</a>
                </div>
                <div class="vacancy-item">
                    <h3>Kompanija C</h3>
                    <p>Apraksts: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <p>Alga: $7000</p>
                    <p>Novads: Liepāja</p>
                    <p>Pilsēta: Liepāja</p>
                    <a href="edit_vacancy.html" class="edit-btn">Rediģēt</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>