// users.js
// Dynamically load the user edit form into a single modal via AJAX

(function () {
    $(document).on('click', '.open-user-edit-btn', function (e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        if (!userId) return;

        var modalEl = document.getElementById('userEditModal');
        if (!modalEl) return;

        var bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);

        // Fetch the edit form HTML
        $.get('/users/' + userId + '/edit-modal')
            .done(function (response) {
                if (response && response.success && response.html) {
                    $(modalEl).find('.modal-content').html(response.html);
                    bsModal.show();
                } else {
                    $(modalEl).find('.modal-content').html('<div class="modal-body"><p class="text-danger">Could not load form. Please try again.</p></div>');
                    bsModal.show();
                }
            })
            .fail(function () {
                $(modalEl).find('.modal-content').html('<div class="modal-body"><p class="text-danger">An error occurred while loading. Please try again.</p></div>');
                bsModal.show();
            });
    });
})();
