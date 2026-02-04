document.addEventListener("DOMContentLoaded", () => {
    
    /* INGREDIENTS */
    const ingredientsContainer = document.getElementById("ingredients-collection");
    const addIngredientBtn = document.getElementById("add-ingredient");

    if (ingredientsContainer && addIngredientBtn) {
        let prototype = ingredientsContainer.dataset.prototype;
        if (!prototype) {
            const symfonyWidget = document.getElementById("recette_recetteIngredients");
            if (symfonyWidget) prototype = symfonyWidget.dataset.prototype;
        }

        let index = ingredientsContainer.querySelectorAll(".ingredient-row").length;

        if (prototype) {
            addIngredientBtn.addEventListener("click", () => {
                const temp = document.createElement("div");
                temp.innerHTML = prototype.replace(/__name__/g, index);

                const ingredient = temp.querySelector('select[id*="ingredient"]');
                const quantite = temp.querySelector('input[id*="quantite"]');
                const unite = temp.querySelector('select[id*="unite"]');
                
                if (!ingredient || !quantite || !unite) return;

                ingredient.setAttribute('aria-label', `Ingrédient n°${index + 1}`);
                quantite.setAttribute('aria-label', `Quantité pour l'ingrédient n°${index + 1}`);
                unite.setAttribute('aria-label', `Unité pour l'ingrédient n°${index + 1}`);

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
                            <button type="button" class="btn btn-outline-danger w-100 remove-ingredient" 
                                    aria-label="Supprimer l'ingrédient n°${index + 1}">
                                <i class="bi bi-x-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                `;

                const cols = row.querySelectorAll('[class^="col-md"]');
                cols[0].appendChild(ingredient);
                cols[1].appendChild(quantite);
                cols[2].appendChild(unite);

                ingredientsContainer.appendChild(row);
                ingredient.focus();
                index++;
            });

            ingredientsContainer.addEventListener("click", e => {
                if (e.target.closest(".remove-ingredient")) {
                    e.target.closest(".ingredient-row").remove();
                    addIngredientBtn.focus();
                }
            });
        }
    }

    /* ETAPES */
    const etapesContainer = document.getElementById("etapes-collection");
    const addEtapeBtn = document.getElementById("add-etape");
    const etapesHidden = document.getElementById("recette_etapes");

    if (etapesContainer && etapesHidden) {
        let etapeIndex = 1;

        const updateHidden = () => {
            etapesHidden.value = [...etapesContainer.querySelectorAll(".etape-input")]
                .filter(i => i.value.trim())
                .map((i, idx) => `${idx + 1}. ${i.value.trim()}`)
                .join("\n");
        };

        const renumber = () => {
            etapesContainer.querySelectorAll(".etape-row").forEach((row, i) => {
                const currentIdx = i + 1;
                row.querySelector(".badge").textContent = currentIdx;
                row.querySelector(".etape-input").setAttribute('aria-label', `Description de l'étape ${currentIdx}`);
                row.querySelector(".remove-etape").setAttribute('aria-label', `Supprimer l'étape ${currentIdx}`);
            });
            etapeIndex = etapesContainer.children.length + 1;
        };

        const addEtape = (value = "") => {
            const row = document.createElement("div");
            row.className = "etape-row mb-2";
            row.innerHTML = `
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <span class="badge bg-success" aria-hidden="true">${etapeIndex}</span>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control etape-input"
                               placeholder="Décrivez l'étape"
                               aria-label="Description de l'étape ${etapeIndex}"
                               value="${value}">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-etape" 
                                aria-label="Supprimer l'étape ${etapeIndex}">
                            <i class="bi bi-x-lg" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            `;
            etapesContainer.appendChild(row);
            const input = row.querySelector('input');
            if (value === "") input.focus();
            etapeIndex++;
            updateHidden();
        };

        if (etapesHidden.value) {
            etapesHidden.value.split("\n")
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
                addEtapeBtn.focus();
            }
        });

        etapesContainer.addEventListener("input", updateHidden);
    }
});