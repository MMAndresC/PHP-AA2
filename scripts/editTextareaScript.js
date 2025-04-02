
const changeEditionMode = (id) => {
    const textarea = document.getElementById(`edited-content-${id}`);
    const btnEdit = document.getElementById(`btn-edit-${id}`);
    const btnCancel = document.getElementById(`btn-cancel-${id}`);
    const btnMenuEdit = document.getElementById(`btn-menu-edit-${id}`);
    const btnMenuDelete = document.getElementById(`btn-menu-delete-${id}`);

    if (textarea.readOnly) {
        textarea.readOnly = false;
        btnEdit.classList.remove('is-hidden');
        btnCancel.classList.remove('is-hidden');
        btnMenuEdit.disabled = true;
        btnMenuDelete.disabled = true;
        textarea.textContent = textarea.textContent.trim();
        textarea.focus();
        //Colocar el cursor al final del texto
        textarea.setSelectionRange(textarea.value.length, textarea.value.length);
    }
}

const cancelEditionMode = (id) => {
    const textarea = document.getElementById(`edited-content-${id}`);
    const btnEdit = document.getElementById(`btn-edit-${id}`);
    const btnCancel = document.getElementById(`btn-cancel-${id}`);
    const btnMenuEdit = document.getElementById(`btn-menu-edit-${id}`);
    const btnMenuDelete = document.getElementById(`btn-menu-delete-${id}`);

    if (!textarea.readOnly) {
        textarea.readOnly = true;
        btnEdit.classList.add('is-hidden');
        btnCancel.classList.add('is-hidden');
        btnMenuEdit.disabled = false;
        btnMenuDelete.disabled = false;
    }
}