document.addEventListener('DOMContentLoaded', function () {
    const modals = document.querySelectorAll('.modal');
    const addButtons = document.querySelectorAll('.add-btn');
    const editButtons = document.querySelectorAll('.edit-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const closeBtns = document.querySelectorAll('.close');
    const cancelBtns = document.querySelectorAll('.cancel-btn');

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modal) {
        modal.style.display = 'none';
    }

    addButtons.forEach(btn => {
        btn.addEventListener('click', () => openModal(btn.dataset.modal));
    });

    editButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            openModal(btn.dataset.modal);
            // Here you would typically fetch the data for the item being edited
            // and populate the form fields
        });
    });

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            openModal(btn.dataset.modal);
            const confirmDeleteBtn = document.getElementById(`confirmDelete${btn.dataset.modal.replace('delete', '').replace('Modal', '')}`);
            confirmDeleteBtn.dataset.id = btn.dataset.id;
        });
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
    });

    cancelBtns.forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
    });

    window.addEventListener('click', (event) => {
        modals.forEach(modal => {
            if (event.target == modal) {
                closeModal(modal);
            }
        });
    });

    // // Handling form submissions
    // const forms = document.querySelectorAll('form');
    // forms.forEach(form => {
    //     form.addEventListener('submit', (e) => {
    //         // e.preventDefault();
    //         // Here you would typically send the form data to the server
    //         // and handle the response
    //         // console.log('Form submitted:', form.id);
    //         closeModal(form.closest('.modal'));
    //     });
    // });

    // Handling delete confirmations
    const confirmDeleteBtns = document.querySelectorAll('[id^="confirmDelete"]');
    confirmDeleteBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const itemType = btn.id.replace('confirmDelete', '');
            const itemId = btn.dataset.id;
            // Here you would typically send a delete request to the server
            console.log(`Deleting ${itemType} with id: ${itemId}`);
            closeModal(btn.closest('.modal'));
        });
    });
});