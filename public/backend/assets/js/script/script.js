
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.delete-form, .restore-form, .trash-form')
        .forEach(form => {

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                let text = 'Are you sure?';
                let confirm = 'Yes';

                if (this.classList.contains('delete-form')) {
                    text = 'This record will be permanently deleted.';
                    confirm = 'Yes, delete it!';
                }

                if (this.classList.contains('restore-form')) {
                    text = 'This record will be restored.';
                    confirm = 'Yes, restore it!';
                }

                if (this.classList.contains('trash-form')) {
                    text = 'This record will be moved to trash.';
                    confirm = 'Yes, move it!';
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: confirm,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

        });

});

