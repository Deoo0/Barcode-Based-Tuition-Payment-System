// payment.js - handles AJAX submission for payment form

$(function () {
    var $form = $('#paymentForm');
    if (!$form.length) return;

    $form.on('submit', function (e) {
        e.preventDefault();

        var $submitBtn = $form.find('button[type="submit"]');
        var originalBtnHtml = $submitBtn.html();
        var url = $form.attr('action');
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            method: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': token
            },
            beforeSend: function () {
                $submitBtn.prop('disabled', true).text('Processing...');
            },
            success: function (response) {
                if (response.success) {
                    var balance = parseFloat(response.balance || 0);
                    var formatted = '₱' + balance.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    // Update balance summary
                    $('.balance-summary strong').text(formatted);

                    // Update detail-item Balance value and class (replace HTML atomically)
                    var $balanceItem = $('.student-details-grid .detail-item').filter(function () {
                        return $(this).find('.detail-label').text().trim() === 'Balance';
                    });
                    var $balanceValue = $balanceItem.find('.detail-value');
                    if ($balanceValue.length) {
                        // Build new HTML for the value (currency + optional badge)
                        var newHtml = formatted;
                        if (balance <= 0) {
                            newHtml += ' <span class="badge bg-success ms-2">Paid in Full</span>';
                        }
                        $balanceValue.removeClass('text-danger text-success').addClass(balance > 0 ? 'text-danger' : 'text-success').html(newHtml);
                    }

                    // Close modal using Bootstrap API
                    var modalEl = document.getElementById('paymentModal');
                    if (modalEl) {
                        var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        try { modal.hide(); } catch (e) { /* ignore */ }
                    }

                    // Show a non-blocking alert at top of container
                    var alertHtml = '<div class="alert alert-success alert-dismissible fade show d-flex align-items-center mt-3" role="alert">'
                        + '<i class="bi bi-check-circle-fill me-2 fs-4"></i>'
                        + '<div>' + (response.message || 'Payment recorded') + '</div>'
                        + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        + '</div>';
                    $('.payment-portal-container .container').prepend(alertHtml);

                        // If transactions table exists on the page, prepend the new row
                        if (response.row) {
                            var $tbody = $('#transactions-tbody');
                            if ($tbody.length) {
                                $tbody.prepend(response.row);
                            }
                        }

                } else {
                    alert(response.message || 'Payment failed');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var messages = [];
                    $.each(errors, function (k, v) { messages.push(v.join(', ')); });
                    alert(messages.join('\n'));
                } else {
                    console.error(xhr.responseText);
                    alert('Payment failed. Please check your console for details.');
                }
            },
            complete: function () {
                $submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });
});
