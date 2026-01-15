// recipe-show.js
(function () {
    if (window.recipeShowScriptLoaded) return;
    window.recipeShowScriptLoaded = true;

    function init() {
        const btn = document.getElementById('favoriBtn');
        if (!btn) return;

        btn.addEventListener('click', async () => {
            const recetteId = btn.dataset.recetteId;
            const icon = document.getElementById('favoriIcon');
            const text = document.getElementById('favoriText');

            btn.disabled = true;

            try {
                const response = await fetch(`/api/favori/toggle/${recetteId}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    const isFav = data.isFavorite;
                    icon.classList.toggle('bi-heart-fill', isFav);
                    icon.classList.toggle('bi-heart', !isFav);
                    text.textContent = isFav
                        ? 'Retirer des favoris'
                        : 'Ajouter aux favoris';
                    btn.setAttribute('aria-label', text.textContent);
                }
            } catch (e) {
                console.error(e);
            } finally {
                btn.disabled = false;
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
