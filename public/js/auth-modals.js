(() => {
    if (window.authModalScriptLoaded) return;
    window.authModalScriptLoaded = true;

    window.switchModal = function (e, fromId, toId) {
        e.preventDefault();

        const fromEl = document.getElementById(fromId);
        const toEl = document.getElementById(toId);

        if (!fromEl || !toEl) return;

        bootstrap.Modal.getInstance(fromEl)?.hide();
        new bootstrap.Modal(toEl).show();
    };
})();
