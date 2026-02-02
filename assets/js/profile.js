import '../styles/profile.css';
import Chart from 'chart.js/auto';

(() => {
    // 1. Gestion de la suppression Modale
    let currentRecetteId = null;

    window.confirmerSuppression = function(id, nom) {
        currentRecetteId = id;
        const nameElem = document.getElementById('recetteName');
        if (nameElem) nameElem.textContent = nom;
        
        const modalElem = document.getElementById('deleteModal');
        if (modalElem) {
            const modal = new bootstrap.Modal(modalElem);
            modal.show();
        }
    };

    document.getElementById('confirmDelete')?.addEventListener('click', () => {
        if (currentRecetteId) {
            document.getElementById('delete-form-' + currentRecetteId)?.submit();
        }
    });

    // 2. Gestion du Graphique
    const ctx = document.getElementById('statsChart');
    if (ctx) {
        const published = ctx.dataset.published || 0;
        const favorites = ctx.dataset.favorites || 0;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Publiées', 'Vues', 'Favoris'],
                datasets: [{
                    data: [published, 0, favorites],
                    backgroundColor: ['#198754', '#6c757d', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                cutout: '70%'
            }
        });
    }
})();