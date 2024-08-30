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
                                data-description="<?= $book['description'] ?>" data-image-path="<?= $book['cover_image_path'] ?>" data-file-path="<?= $book['file_path'] ?>">Edit</button>
                            <button class="delete-btn" data-type="book" data-id="<?= $book['id'] ?>" data-action='delete'>Delete</button>
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
                                        data-id="<?= $category['id'] ?>" data-action='delete'>Delete</button>
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
                                    <button class="delete-btn" data-type="user" data-id="<?= $user['id'] ?>" data-action='delete'>Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </section>
    </main>
    
    <!-- Add Book Modal -->
    <div id="bookModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Book</h2>
            <form id="addBookForm" action="/dashboard" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" class="action">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label for="book_title">Title:</label>
                    <input type="text" id="book_title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="book_category">Category:</label>
                    <select id="book_category" name="category" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="book_description">Description:</label>
                    <textarea id="book_description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="book_file">File:</label>
                    <input type="file" id="book_file" name="filePath">
                    <span id="current_file"></span>
                    <input type="checkbox" id="keep_file" name="keep_file" value="1" checked>
                    <label for="keep_file">Keep current file</label>
                </div>
                <div class="form-group">
                    <label for="book_cover">Cover Image:</label>
                    <input type="file" id="book_cover" name="coverImagePath"><span id="current_cover"></span>
                    <input type="checkbox" id="keep_cover" name="keep_cover" value="1" checked>
                    <label for="keep_cover">Keep current cover</label>
                </div>
                <button type="submit" class="submit-btn">Add Book</button>
            </form>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Category</h2>
            <form id="addCategoryForm" action="/dashboard" method="post">
                <input type="hidden" name="action" class="action">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label for="category_name">Category Name:</label>
                    <input type="text" id="category_name" name="categoryName" required>
                </div>
                <button type="submit" class="submit-btn">Add Category</button>
            </form>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add User</h2>
            <form id="addUserForm" action="/dashboard" method="post">
                <input type="hidden" name="action" class="action">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Add User</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you sure you want to delete this item? This action cannot be undone.</p>
            <form id="deleteForm" action="/dashboard" method="post">
                <input type="hidden" name="action" id="delete_action">
                <input type="hidden" id="delete_item_id" name="delete_item_id">
                <button type="submit" class="delete-btn">Delete</button>
                <button type="button" class="cancel-btn">Cancel</button>
            </form>
        </div>
    </div>

    <script src="../assets/javascript/dashboard.js"></script>
</body>

</html>