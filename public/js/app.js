/**
 * TaskFlow - Custom Vanilla JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
    // Auto-dismiss alerts after 4.5 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            if (window.bootstrap && bootstrap.Alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                if (bsAlert) {
                    bsAlert.close();
                }
            } else {
                alert.remove();
            }
        }, 4500);
    });

    // Provide enhanced confirmation prompt on delete forms
    const deleteForms = document.querySelectorAll('form.delete-form');
    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            // Already handled by inline onclick or fallback here
        });
    });
});

