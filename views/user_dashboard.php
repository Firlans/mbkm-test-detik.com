<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/user_dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>User Dashboard - Digital Library</title>
</head>

<body>
    <nav class="sidebar">
        <div class="sidebar-header">
            <h1>Digital Library</h1>
        </div>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="#browse-books" class="nav-link">
                    <i class="fas fa-book"></i>
                    <span>Browse Books</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#my-books" class="nav-link">
                    <i class="fas fa-bookmark"></i>
                    <span>My Books</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#reading-history" class="nav-link">
                    <i class="fas fa-history"></i>
                    <span>Reading History</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#profile" class="nav-link">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/logout" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <main class="main-content">
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <section id="browse-books" class="card">
            <div class="header">
                <h2>Browse Books</h2>
                <input type="text" id="search-books" placeholder="Search books...">
            </div>
            <div class="book-list">
                <?php if (isset($books)): ?>
                    <?php foreach ($books as $book): ?>
                        <div class="book-item"
                            data-search="<?= htmlspecialchars(strtolower($book['title'] . ' ' . $book['author'] . ' ' . $book['category'])) ?>">
                            <img src="<?= htmlspecialchars($book['cover_image_path']) ?>" alt="Cover">
                            <h3><?= htmlspecialchars($book['title']) ?></h3>
                            <p>Author: <?= htmlspecialchars($book['author']) ?></p>
                            <p>Category: <?= htmlspecialchars($book['category']) ?></p>
                            <form action="/dashboard" method="post">
                                <input type="hidden" name="action" value="add_reading_list">
                                <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['id']) ?>">
                                <button type="submit" class="borrow-btn">Borrow</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section id="my-books" class="card">
            <div class="header">
                <h2>My Books</h2>
            </div>
            <div class="book-list">
                <?php if (isset($borrowed)): ?>
                    <?php foreach ($borrowed as $book): ?>
                        <?php if ($book['status'] === 'borrowed'): ?>
                            <div class="book-item">
                                <img src="<?= htmlspecialchars($book['cover_image_path']) ?>" alt="Cover">
                                <h3><?= htmlspecialchars($book['title']) ?></h3>
                                <p>Due date: <?= htmlspecialchars($book['due_date']) ?></p>
                                <form action="/dashboard" method="post">
                                    <input type="hidden" name="action" value="return_book">
                                    <input type="hidden" name="borrow_id" value="<?= htmlspecialchars($book['borrow_id']) ?>">
                                    <button type="submit" class="return-btn">Return</button>
                                </form>
                            </div>
                        <?php endif ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section id="reading-history" class="card">
            <div class="header">
                <h2>Reading History</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($borrowed)): ?>
                        <?php foreach ($borrowed as $entry): ?>
                            <tr>
                                <td><?= htmlspecialchars($entry['title']) ?></td>
                                <td><?= htmlspecialchars($entry['borrow_date']) ?></td>
                                <td><?= $entry['return_date'] ?  htmlspecialchars($entry['return_date']) : "belum dikembalikan"?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section id="profile" class="card">
            <div class="header">
                <h2>My Profile</h2>
            </div>
            <form id="updateProfileForm" action="/dashboard" method="post">
                <input type="hidden" name="action" value="update_profile">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit" class="submit-btn">Update Profile</button>
            </form>
        </section>
    </main>

    <script src="../assets/javascript/user_dashboard.js"></script>
</body>

</html>