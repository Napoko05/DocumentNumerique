document.addEventListener("DOMContentLoaded", () => {

    const canvas = document.getElementById('viewsChart');

    if (!canvas) return;

    const labels = JSON.parse(canvas.dataset.labels || "[]");
    const data = JSON.parse(canvas.dataset.data || "[]");

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Vues',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

});