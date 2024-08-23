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
                <button class="add-btn" data-modal="bookModal">Add New Book</button>
            </div>
            <div class="book-list">
                <?php if (isset($books)): ?>
                    <?php foreach ($books as $book): ?>
                        <div class="book-item">
                            <img src="<?= $book['cover_image_path'] ?>" alt="Cover">
                            <h3><?= $book['title'] ?></h3>
                            <p><?= $book['description'] ?></p>
                            <button class="edit-btn" data-modal="editBookModal" data-id="<?= $book['id'] ?>">Edit</button>
                            <button class="delete-btn" data-modal="deleteBookModal" data-id="<?= $book['id'] ?>">Delete</button>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </section>

        <section id="categories" class="card">
            <div class="header">
                <h2>Category Management</h2>
                <button class="add-btn" data-modal="categoryModal">Add New Category</button>
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
                                    <button class="edit-btn" data-modal="editCategoryModal"
                                        data-id="<?= $category['id'] ?>">Edit</button>
                                    <button class="delete-btn" data-modal="deleteCategoryModal"
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
                <button class="add-btn" data-modal="userModal">Add New User</button>
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
                                    <button class="edit-btn" data-modal="editUserModal"
                                        data-id="<?= $user['id'] ?>">Edit</button>
                                    <button class="delete-btn" data-modal="deleteUserModal"
                                        data-id="<?= $user['id'] ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </section>

        <!-- Book Modal -->
        <div id="bookModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Book</h2>
                <form id="addBookForm" action="/dashboard" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="book_title">Title:</label>
                        <input type="text" id="book_title" name="book_title" required>
                    </div>
                    <div class="form-group">
                        <label for="book_category">Category:</label>
                        <select id="book_category" name="book_category" required>
                            <?php if (isset($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="book_description">Description:</label>
                        <textarea id="book_description" name="book_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="book_file">File:</label>
                        <input type="file" id="book_file" name="book_file">
                    </div>
                    <div class="form-group">
                        <label for="book_cover">Cover Image:</label>
                        <input type="file" id="book_cover" name="book_cover">
                    </div>
                    <button type="submit" class="submit-btn">Add Book</button>
                </form>
            </div>
        </div>

        <!-- Category Modal -->
        <div id="categoryModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Category</h2>
                <form id="addCategoryForm" action="/dashboard" method="post">
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" id="category_name" name="category_name" required>
                    </div>
                    <button type="submit" class="submit-btn">Add Category</button>
                </form>
            </div>
        </div>

        <!-- User Modal -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New User</h2>
                <form id="addUserForm" action="/dashboard" method="post">
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

        <!-- Delete Book Modal -->
        <div id="deleteBookModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Delete Book</h2>
                <p>Are you sure you want to delete this book? This action cannot be undone.</p>
                <form id="deleteBookForm" action="/dashboard" method="post">
                    <input type="hidden" id="delete_book_id" name="delete_book_id">
                    <button type="submit" class="delete-btn">Delete Book</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('deleteBookModal')">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Delete Category Modal -->
        <div id="deleteCategoryModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Delete Category</h2>
                <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                <form id="deleteCategoryForm" action="/dashboard" method="post">
                    <input type="hidden" id="delete_category_id" name="delete_category_id">
                    <button type="submit" class="delete-btn">Delete Category</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('deleteCategoryModal')">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div id="deleteUserModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Delete User</h2>
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                <form id="deleteUserForm" action="/dashboard" method="post">
                    <input type="hidden" id="delete_user_id" name="delete_user_id">
                    <button type="submit" class="delete-btn">Delete User</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('deleteUserModal')">Cancel</button>
                </form>
            </div>
        </div>

    </main>

    <script src="../assets/javascript/dashboard.js"></script>
</body>

</html>