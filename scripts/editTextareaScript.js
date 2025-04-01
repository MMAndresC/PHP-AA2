
const changeEditionMode = (id) => {
    let textarea = document.getElementById(`edited-content-${id}`);
    let btnEdit = document.getElementById(`btn-edit-${id}`);
    let btnCancel = document.getElementById(`btn-cancel-${id}`);

    if (textarea.readOnly) {
        textarea.readOnly = false;
        btnEdit.hidden = false;
        btnCancel.hidden = false;
        textarea.focus();
    }
}

const cancelEditionMode = (id) => {
    let textarea = document.getElementById(`edited-content-${id}`);
    let btnEdit = document.getElementById(`btn-edit-${id}`);
    let btnCancel = document.getElementById(`btn-cancel-${id}`);

    if (!textarea.readOnly) {
        textarea.readOnly = true;
        btnEdit.hidden = true;
        btnCancel.hidden = true;
    }
}