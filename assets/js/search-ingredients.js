(() => {
    const container = document.getElementById('search-page-container');
    if (!container) return;

    let selectedIds = JSON.parse(container.dataset.selected || "[]");
    const searchUrl = container.dataset.searchUrl;
    const input = document.getElementById('ingredientInput');
    const addButton = document.getElementById('add-ingredient-search');

    const updateURL = () => {
        const params = selectedIds.length > 0 ? `?ingredients=${selectedIds.join(',')}` : '';
        window.location.href = searchUrl + params;
    };

    const addFromInput = () => {
        const nom = input.value.trim();
        const option = Array.from(document.querySelectorAll('#ingredientsList option'))
            .find(opt => opt.value.toLowerCase() === nom.toLowerCase());
        
        if (option) {
            const id = parseInt(option.dataset.id);
            if (!selectedIds.includes(id)) {
                selectedIds.push(id);
                updateURL();
            }
        }
    };

    addButton?.addEventListener('click', addFromInput);

    input?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addFromInput();
        }
    });

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-ingredient-btn')) {
            const id = parseInt(e.target.dataset.id);
            selectedIds = selectedIds.filter(item => item != id);
            updateURL();
        }
    });
})();