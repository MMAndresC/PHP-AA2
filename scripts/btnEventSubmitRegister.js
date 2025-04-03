document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btn-register');
    const form = document.getElementById('form-register');
    form.addEventListener('submit', () => {
        btn.classList.add('is-loading');
        btn.disabled = true;
    });
});