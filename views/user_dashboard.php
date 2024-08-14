<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>User Dashboard - Digital Library</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to Digital Library of Pamulang University</h1>
            <nav>
                <ul>
                    <li><a href="#available-books">Available Books</a></li>
                    <li><a href="#my-books">My Books</a></li>
                    <li><a href="/logout">Logout</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section id="available-books">
                <h2>Available Books</h2>
                <div class="book-list">
                    <!-- Available books will be dynamically added here -->
                </div>
            </section>

            <section id="my-books">
                <h2>My Reading List</h2>
                <div class="book-list">
                    <!-- User's selected books will be dynamically added here -->
                </div>
            </section>
        </main>
    </div>

    <script src="../assets/js/user_dashboard.js"></script>
</body>
</html>