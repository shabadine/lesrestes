document.addEventListener("DOMContentLoaded", () => {

    /* =========================
       INGREDIENTS
    ========================= */

    const ingredientsContainer = document.getElementById("ingredients-collection");
    const addIngredientBtn = document.getElementById("add-ingredient");

    if (ingredientsContainer && addIngredientBtn) {

        // 🔹 Prototype avec fallback Symfony
        let prototype = ingredientsContainer.dataset.prototype;
        if (!prototype) {
            const symfonyWidget = document.getElementById("recette_recetteIngredients");
            if (symfonyWidget) prototype = symfonyWidget.dataset.prototype;
        }

        let index = ingredientsContainer.querySelectorAll(".ingredient-row").length;
        if (!prototype) return;

        addIngredientBtn.addEventListener("click", () => {
            const temp = document.createElement("div");
            temp.innerHTML = prototype.replace(/__name__/g, index);

            const ingredient = temp.querySelector('select[id*="ingredient"]');
            const quantite = temp.querySelector('input[id*="quantite"]');
            const unite = temp.querySelector('select[id*="unite"]');
            if (!ingredient || !quantite || !unite) return;

            ingredient.className = "form-select";
            quantite.className = "form-control";
            unite.className = "form-select";

            const row = document.createElement("div");
            row.className = "ingredient-row mb-2";
            row.innerHTML = `
                <div class="row g-2 align-items-end">
                    <div class="col-md-5"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger w-100 remove-ingredient">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            `;

            const cols = row.querySelectorAll('[class^="col-md"]');
            cols[0].appendChild(ingredient);
            cols[1].appendChild(quantite);
            cols[2].appendChild(unite);

            ingredientsContainer.appendChild(row);
            index++;
        });

        ingredientsContainer.addEventListener("click", e => {
            if (e.target.closest(".remove-ingredient")) {
                e.target.closest(".ingredient-row").remove();
            }
        });
    }

    /* =========================
       ETAPES
    ========================= */

    const etapesContainer = document.getElementById("etapes-collection");
    const addEtapeBtn = document.getElementById("add-etape");
    const etapesHidden = document.getElementById("recette_etapes");
    if (!etapesContainer || !etapesHidden) return;

    let etapeIndex = 1;

    function updateHidden() {
        etapesHidden.value = [...etapesContainer.querySelectorAll(".etape-input")]
            .filter(i => i.value.trim())
            .map((i, idx) => `${idx + 1}. ${i.value.trim()}`)
            .join("\n");
    }

    function renumber() {
        etapesContainer.querySelectorAll(".etape-row").forEach((row, i) => {
            row.querySelector(".badge").textContent = i + 1;
        });
        etapeIndex = etapesContainer.children.length + 1;
    }

    function addEtape(value = "") {
        const row = document.createElement("div");
        row.className = "etape-row mb-2";
        row.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <span class="badge bg-success">${etapeIndex}</span>
                </div>
                <div class="col">
                    <input type="text" class="form-control etape-input"
                           placeholder="Décrivez l'étape"
                           value="${value}">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-etape">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        `;
        etapesContainer.appendChild(row);
        etapeIndex++;
        updateHidden();
    }

    if (etapesHidden.value) {
        etapesHidden.value
            .split("\n")
            .map(e => e.replace(/^\d+\.\s*/, ""))
            .forEach(addEtape);
    } else {
        addEtape();
        addEtape();
    }

    addEtapeBtn?.addEventListener("click", () => addEtape());

    etapesContainer.addEventListener("click", e => {
        if (e.target.closest(".remove-etape")) {
            e.target.closest(".etape-row").remove();
            renumber();
            updateHidden();
        }
    });

    etapesContainer.addEventListener("input", updateHidden);
});
