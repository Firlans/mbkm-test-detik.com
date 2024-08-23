CREATE DATABASE perpustakaan_digital;

USE perpustakaan_digital;

CREATE TABLE
    users (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

CREATE TABLE
    categories (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

CREATE TABLE
    books (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        category_id INT NOT NULL,
        description VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        cover_image_path VARCHAR(255) NOT NULL,
        user_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        CONSTRAINT fk_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
        INDEX idx_category (category_id),
        INDEX idx_user (user_id)
    );

-- Contoh INSERT Data (Jika ingin menambahkan data)
INSERT INTO
    users (email, username, password, role)
VALUES
    ('admin@gmail.com', 'Admin', 'admin', 'admin'),
    ('user@example.com', 'User', 'user123', 'user');

INSERT INTO
    categories (name)
VALUES
    ('Science Fiction'),
    ('Fantasy'),
    ('Non-Fiction');

INSERT INTO
    books (title, category_id, description, file_path, cover_image_path, user_id)
VALUES
    ('Dune', 1, 'A science fiction novel by Frank Herbert.', '/files/dune.pdf', '/covers/dune.jpg', 1),
    ('The Hobbit', 2, 'A fantasy novel by J.R.R. Tolkien.', '/files/hobbit.pdf', '/covers/hobbit.jpg', 2);
