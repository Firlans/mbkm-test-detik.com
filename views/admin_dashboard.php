<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Admin Dashboard - Digital Library</title>
</head>

<body>
    <nav class="sidebar">
        <div class="sidebar-header">
            <h1>Digital Library</h1>
        </div>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="#books" class="nav-link">
                    <i class="fas fa-book"></i>
                    <span>Manage Books</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#categories" class="nav-link">
                    <i class="fas fa-tags"></i>
                    <span>Manage Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#users" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
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
            <p class='message'><?= $message ?></p>
        <?php endif ?>
        <section id="books" class="card">
            <div class="header">
                <h2>Book Management</h2>
                <button class="add-btn" data-type="book">Add New Book</button>
            </div>
            <div class="book-list">
                <?php if (isset($books)): ?>
                    <?php foreach ($books as $book): ?>
                        <div class="book-item">
                            <img src="<?= $book['cover_image_path'] ?>" alt="Cover">
                            <h3><?= $book['title'] ?></h3>
                            <p><?= $book['description'] ?></p>
                            <button class="edit-btn" data-type="book" data-id="<?= $book['id'] ?>"
                                data-title="<?= $book['title'] ?>" data-category="<?= $book['category_id'] ?>"
                                data-description="<?= $book['description'] ?>">Edit</button>
                            <button class="delete-btn" data-type="book" data-id="<?= $book['id'] ?>">Delete</button>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </section>

        <section id="categories" class="card">
            <div class="header">
                <h2>Category Management</h2>
                <button class="add-btn" data-type="category">Add New Category</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= $category['name'] ?></td>
                                <td><?= $category['created_at'] ?></td>
                                <td><?= $category['updated_at'] ?></td>
                                <td>
                                    <button class="edit-btn" data-type="category" data-id="<?= $category['id'] ?>"
                                        data-category-name="<?= $category['name'] ?>">Edit</button>
                                    <button class="delete-btn" data-type="category"
                                        data-id="<?= $category['id'] ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </section>

        <section id="users" class="card">
            <div class="header">
                <h2>User Management</h2>
                <button class="add-btn" data-type="user">Add New User</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td><?= $user['created_at'] ?></td>
                                <td><?= $user['updated_at'] ?></td>
                                <td>
                                    <button class="edit-btn" data-type="user" data-id="<?= $user['id'] ?>"
                                        data-username="<?= $user['username'] ?>" data-email="<?= $user['email'] ?>"
                                        data-role="<?= $user['role'] ?>" data-password="<?= $user['password'] ?>">Edit</button>
                                    <button class="delete-btn" data-type="user" data-id="<?= $user['id'] ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="../assets/javascript/dashboard.js"></script>
</body>

</html>