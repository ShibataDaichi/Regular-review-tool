document.addEventListener('DOMContentLoaded', () => {
    const editForms = document.querySelectorAll('.edit-form');

    editForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const newComment = form.querySelector('textarea').value.trim();
            if (newComment === '') {
                e.preventDefault();
                alert('コメントを入力してください。');
            }
        });
    });
});
