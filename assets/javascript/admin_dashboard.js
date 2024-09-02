document.addEventListener("DOMContentLoaded", function () {
  const modals = document.querySelectorAll(".modal");
  const openButtons = document.querySelectorAll(
    ".add-btn, .edit-btn, .delete-btn"
  );
  const closeButtons = document.querySelectorAll(".close, .cancel-btn");

  openButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modalAction = this.dataset.action;
      const modalType = this.dataset.type;
      const modal = modalAction
        ? document.getElementById(`${modalAction}Modal`)
        : document.getElementById(`${modalType}Modal`);
      console.log(modal);
      modal.style.display = "block";

      const form = modal.querySelector("form");
      form.reset();
      // Populate form fields for edit actions
      if (this.classList.contains("edit-btn")) {
        const bookFilePath = this.getAttribute("data-file-path");
        const bookCoverPath = this.getAttribute("data-image-path");
        modal.querySelector("h2").innerText = `edit ${modalType}`;
        modal.querySelector(".action").value = `edit_${modalType}`;
        form.querySelector(".submit-btn").innerHTML = `edit ${modalType}`;
        for (let key in this.dataset) {
          const field = form.querySelector(`[name="${key}"]`);
          if (field) {
            if (key === "filePath" || key === "coverImagePath") {
              field.textContent = this.dataset[key];
            } else {
              field.value = this.dataset[key];
            }
          }
        }
        document.getElementById("current_file").textContent = bookFilePath
          ? `Current file: ${bookFilePath.split("/").pop()}`
          : "No file uploaded";
        document.getElementById("current_cover").textContent = bookCoverPath
          ? `Current cover: ${bookCoverPath.split("/").pop()}`
          : "No cover uploaded";
      }
      if (this.classList.contains("add-btn")) {
        modal.querySelector(".action").value = `add_${modalType}`;
      }
      // Set up delete form
      if (this.classList.contains("delete-btn")) {
        const deleteForm = document.getElementById("deleteForm");
        deleteForm.querySelector(
          "#delete_action"
        ).value = `delete_${modalType}`;
        deleteForm.querySelector("#delete_item_id").value = this.dataset.id;
      }
    });
  });

  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modal = this.closest(".modal");
      modal.style.display = "none";
    });
  });

  window.addEventListener("click", function (event) {
    if (event.target.classList.contains("modal")) {
      event.target.style.display = "none";
    }
  });
});
