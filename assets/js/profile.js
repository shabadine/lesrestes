import { Modal } from 'bootstrap';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

window.confirmerSuppression = function(id, nom) {
    const nameElem = document.getElementById('recetteName');
    if (nameElem) nameElem.textContent = nom;
    
    const modalElem = document.getElementById('deleteModal');
    if (modalElem) {
        const confirmBtn = document.getElementById('confirmDelete');
        if (confirmBtn) {
            confirmBtn.onclick = () => {
                const form = document.getElementById('delete-form-' + id);
                if (form) form.submit();
            };
        }
        
        const modal = new Modal(modalElem);
        modal.show();
    }
};

const initChart = () => {
    const ctx = document.getElementById('statsChart');
    if (ctx) {
        const existingChart = Chart.getChart(ctx);
        if (existingChart) existingChart.destroy();
        new Chart(ctx, {
            
            type: 'doughnut',
            data: {
                labels: ['Publiées', 'Vues', 'Favoris'],
                datasets: [{
                    data: [ctx.dataset.published || 0, 0, ctx.dataset.favorites || 0],
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
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initChart);
} else {
    initChart();
}