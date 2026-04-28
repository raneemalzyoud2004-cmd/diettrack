document.addEventListener('DOMContentLoaded', function () {
    var host = document.querySelector('[data-include="navbar"]');
    if (!host) {
        return;
    }

    fetch('partials/navbar.html')
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Failed to load navbar');
            }
            return response.text();
        })
        .then(function (html) {
            host.innerHTML = html;
        })
        .catch(function () {
            host.innerHTML = '';
        });
});
