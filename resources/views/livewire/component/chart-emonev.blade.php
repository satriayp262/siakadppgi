<div wire:ignore>
    <h2 class="text-lg font-semibold mb-4 text-center">Record Nilai Dosen</h2>
    <canvas id="myChart" width="400" height="200"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let myChart; // Store chart instance globally to destroy it later

    document.addEventListener('livewire:init', () => {
        Livewire.on('renderChart', (event) => {
            const chartData = event[0].chartData; // Access the chart data from event

            const canvas = document.getElementById('myChart');

            if (canvas) {
                const ctx = canvas.getContext('2d');

                // Destroy existing chart if it exists
                if (myChart) {
                    myChart.destroy();
                }

                // Create new chart
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: chartData.datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    });
</script>
