document.addEventListener('DOMContentLoaded', function () {
    const modalTemplates = {
        book: `
            <form id="addBookForm" action="/dashboard" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action">
                <div class="form-group">
                    <label for="book_title">Title:</label>
                    <input type="text" id="book_title" name="book_title" required>
                </div>
                <div class="form-group">
                    <label for="book_category">Category:</label>
                    <select id="book_category" name="book_category" required>
                        <!-- Categories will be populated dynamically -->
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
        `,
        category: `
            <form id="addCategoryForm" action="/dashboard" method="post">
                <input type="hidden" name="action" value="add_category">
                <div class="form-group">
                    <label for="category_name">Category Name:</label>
                    <input type="text" id="category_name" name="category_name" required>
                </div>
                <button type="submit" class="submit-btn">Add Category</button>
            </form>
        `,
        user: `
            <form id="addUserForm" action="/dashboard" method="post">
                <input type="hidden" name="action">
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
        `,
        delete: `
            <p>Are you sure you want to delete this item? This action cannot be undone.</p>
            <form id="deleteForm" action="/dashboard" method="post">
                <input type="hidden" name="action" id="delete_action">
                <input type="hidden" id="delete_item_id" name="delete_item_id">
                <button type="submit" class="delete-btn">Delete</button>
                <button type="button" class="cancel-btn">Cancel</button>
            </form>
        `
    };

    function createModal(type, title) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.id = `${type}Modal`;

        const modalContent = document.createElement('div');
        modalContent.className = 'modal-content';

        const closeBtn = document.createElement('span');
        closeBtn.className = 'close';
        closeBtn.innerHTML = '&times;';

        modalContent.innerHTML = `
            ${closeBtn.outerHTML}
            ${title ? `<h2>${title}</h2>` : ''}
            ${modalTemplates[type]}
        `;

        modal.appendChild(modalContent);
        document.body.appendChild(modal);

        return modal;
    }

    function openModal(modal, data = {}) {
        if (typeof modal === 'string') {
            modal = document.getElementById(modal);
        }

        // Populate form fields if data is provided
        for (let key in data) {
            const field = modal.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = data[key];
            }
        }

        // Tambahkan log untuk memeriksa nilai action
        console.log('Action value set:', modal.querySelector('[name="action"]').value);

        modal.style.display = 'block';
    }

    function closeModal(modal) {
        if (typeof modal === 'string') {
            modal = document.getElementById(modal);
        }
        modal.style.display = 'none';
    }

    // Create modals
    const addBookModal = createModal('book', 'Add Book');
    const addCategoryModal = createModal('category', 'Add Category');
    const addUserModal = createModal('user', 'Add User');
    const deleteModal = createModal('delete');

    // Add event listeners
    document.querySelectorAll('.add-btn, .edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalType = btn.dataset.type;
            const modalId = `${modalType}Modal`;
            const data = btn.dataset;
            openModal(modalId, data);
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const itemType = btn.dataset.type;
            const data = {
                delete_item_id: btn.dataset.id,
                action: `delete_${itemType}`
            };
            openModal(deleteModal, data);
        });
    });

    document.querySelectorAll('.modal .close, .modal .cancel-btn').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
    });

    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target);
        }
    });

    // Handle form submissions
    document.querySelectorAll('.modal form').forEach(form => {
        form.addEventListener('submit', (e) => {
            // Hapus e.preventDefault();
            console.log('Form submitted:', form.id);

            // Opsional: Jika Anda ingin menutup modal setelah submit
            setTimeout(() => {
                closeModal(form.closest('.modal'));
            }, 100);

            // Form akan dikirim secara normal
        });
    });

    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Hentikan pengiriman form sementara
        console.log('Delete form submitted. Action:', this.querySelector('[name="action"]').value);
        console.log('Delete item ID:', this.querySelector('[name="delete_item_id"]').value);
        
        // Jika nilai action benar, kirim form
        if (this.querySelector('[name="action"]').value.startsWith('delete_')) {
            this.submit();
        } else {
            console.error('Invalid action value');
        }
    });
});