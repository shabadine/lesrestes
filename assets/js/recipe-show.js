// recipe-show.js
(() => {
    
    if (window.recipeShowScriptLoaded) return;
    window.recipeShowScriptLoaded = true;

    const init = () => {
        const btn = document.getElementById("favoriBtn");
        if (!btn) return;

        const icon = document.getElementById("favoriIcon");
        const text = document.getElementById("favoriText");

        btn.addEventListener("click", async () => {
            const recetteId = btn.dataset.recetteId;
            if (!recetteId) return;

            btn.disabled = true;

            try {
                const res = await fetch(`/api/favori/toggle/${recetteId}`, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });

                if (!res.ok) {
                    throw new Error(`HTTP ${res.status}`);
                }

                const data = await res.json();
                if (!data.success) return;

                const isFavorite = data.isFavorite;

                
                icon.classList.toggle("bi-heart-fill", isFavorite);
                icon.classList.toggle("bi-heart", !isFavorite);

                text.textContent = isFavorite
                    ? "Retirer des favoris"
                    : "Ajouter aux favoris";

                btn.setAttribute("aria-label", text.textContent);

                
                icon.classList.add("scale");
                setTimeout(() => icon.classList.remove("scale"), 200);

            } catch (err) {
                console.error("Erreur favori :", err);
            } finally {
                btn.disabled = false;
            }
        });
    };

    
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
