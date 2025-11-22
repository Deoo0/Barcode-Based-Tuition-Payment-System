// students.js
// Handles dynamic loading of a single student detail modal

(function () {
    // Use jQuery event delegation so dynamically added buttons will work too
    $(document).on("click", ".view-student-btn", function (e) {
        e.preventDefault();
        var studentId = $(this).data("student-id");
        if (!studentId) return;

        var modalEl = document.getElementById("studentModal");
        if (!modalEl) return;

        var bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);

        // show loading spinner inside modal
        $(modalEl)
            .find(".modal-content")
            .html(
                '<div class="modal-body d-flex justify-content-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        bsModal.show();

        // fetch details
        $.get("/students/" + studentId + "/details")
            .done(function (response) {
                if (response && response.success && response.html) {
                    var content =
                        '\n                        <div class="modal-header bg-primary text-white">\n                            <h5 class="modal-title">Student Details </h5>\n                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>\n                        </div>\n                        <div class="modal-body">' +
                        response.html +
                        '</div>\n                        <div class="modal-footer">\n                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>\n                        </div>\n                    ';
                    $(modalEl).find(".modal-content").html(content);
                } else {
                    $(modalEl)
                        .find(".modal-content")
                        .html(
                            '<div class="modal-body"><p class="text-danger">Could not load student details.</p></div>'
                        );
                }
            })
            .fail(function () {
                $(modalEl)
                    .find(".modal-content")
                    .html(
                        '<div class="modal-body"><p class="text-danger">An error occurred while loading. Please try again.</p></div>'
                    );
            });
    });
})();

(function () {
    $(document).on("click", ".edit-student-btn", function (e) {
        e.preventDefault();
        var studentId = $(this).data("student-id");
        if (!studentId) return;

        var modalEl = document.getElementById("studentModal");
        if (!modalEl) return;

        var bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        $(modalEl)
            .find(".modal-content")
            .html(
                '<div class="modal-body d-flex justify-content-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        bsModal.show();

        $.get('/students/' + studentId + '/edit-modal')
            .done(function(response){
                if(response && response.success && response.html) {
                    $(modalEl).find('.modal-content').html(response.html);
                    bsModal.show();
                }else {
                    $(modalEl).find('.modal-content').html('<div class="modal-body"><p class="text-danger">Could not load form. Please try again.</p></div>');
                    bsModal.show();
                }
            })
            .fail(function(){
                $(modalEl).find('.modal-content').html('<div class="modal-body"><p class="text-danger">An error occurred while loading. Please try again.</p></div>');
                bsModal.show();
            })
    });
})();
