'use strict';

// Confirm-before-delete for any .btn-delete button
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!confirm('¿Estás seguro de que deseas eliminar este elemento? Esta acción no se puede deshacer.')) {
                return;
            }
            const form = document.createElement('form');
            form.method = 'post';
            form.action = btn.dataset.action;

            const csrf = document.querySelector('meta[name="csrf-token"]');
            if (csrf) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = csrf.dataset.name || 'csrf_test_name';
                input.value = csrf.content;
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
        });
    });

    // AJAX image delete
    document.querySelectorAll('.btn-del-img').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('¿Eliminar esta imagen?')) return;
            const csrf = document.querySelector('meta[name="csrf-token"]');
            const res = await fetch(btn.dataset.url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf ? csrf.getAttribute('content') : '',
                },
            });
            if (res.ok) {
                document.getElementById('imgwrap-' + btn.dataset.id)?.remove();
            }
        });
    });
});
