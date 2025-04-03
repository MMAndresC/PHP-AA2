document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btn-reset');
    const form = document.getElementById('form-reset');
    form.addEventListener('submit', () => {
        btn.classList.add('is-loading');
        btn.disabled = true;
    });
});