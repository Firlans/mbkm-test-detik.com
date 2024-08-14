<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Admin Dashboard - Digital Library</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Digital Library Admin Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="#books">Manage Books</a></li>
                    <li><a href="#categories">Manage Categories</a></li>
                    <li><a href="#users">Manage Users</a></li>
                    <li><a href="/logout">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section id="books">
                <h2>Book Management</h2>
                <button class="add-btn" data-modal="bookModal">Add New Book</button>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Cover Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <?php if (isset($message)) : ?>
                        <p class='message'><?= $message ?></p>
                    <?php endif ?>

                    <tbody>
                        <?php if (isset($books)) : ?>
                            <?php foreach ($books as $book) : ?>
                                <tr>
                                    <td><?= $book['title'] ?></td>
                                    <td><?= $book['category_name'] ?></td>
                                    <td><?= $book['description'] ?></td>
                                    <td><?= $book['quantity'] ?></td>
                                    <td><img src="<?= $book['cover_image'] ?>" alt="Cover" width="50"></td>
                                    <td>
                                        <button class="edit-btn" data-modal="editBookModal" data-id="<?= $book['id'] ?>">Edit</button>
                                        <button class="delete-btn" data-modal="deleteBookModal" data-id="<?= $book['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </section>
            <section id="categories">
                <h2>Category Management</h2>
                <button class="add-btn" data-modal="categoryModal">Add New Category</button>
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
                        <?php if (isset($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <tr>
                                    <td><?= $category['category_name'] ?></td>
                                    <td><?= $category['created_at'] ?></td>
                                    <td><?= $category['updated_at'] ?></td>
                                    <td>
                                        <button class="edit-btn" data-modal="editCategoryModal" data-id="<?= $category['id'] ?>">Edit</button>
                                        <button class="delete-btn" data-modal="deleteCategoryModal" data-id="<?= $category['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </section>

            <section id="users">
                <h2>User Management</h2>
                <button class="add-btn" data-modal="userModal">Add New User</button>
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
                        <?php if (isset($users)) : ?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['role'] ?></td>
                                    <td><?= $user['created_at'] ?></td>
                                    <td><?= $user['updated_at'] ?></td>
                                    <td>
                                        <button class="edit-btn" data-modal="editUserModal" data-id="<?= $user['id'] ?>">Edit</button>
                                        <button class="delete-btn" data-modal="deleteUserModal" data-id="<?= $user['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </section>

            <!-- Modal forms -->
            <div id="bookModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add New Book</h2>
                    <form id="addBookForm" action="/dashboard" method="post" enctype="multipart/form-data"">
                        <div class="form-group">
                            <label for="book_title">Title:</label>
                            <input type="text" id="book_title" name="book_title" required>
                        </div>
                        <div class="form-group">
                            <label for="book_category">Category:</label>
                            <select id="book_category" name="book_category" required>
                                <?php if (isset($categories)) : ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
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

        </main>
    </div>

    <script src="../assets/javascript/dashboard.js"></script>
</body>

</html>