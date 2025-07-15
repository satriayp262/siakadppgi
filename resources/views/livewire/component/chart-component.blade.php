<div>
    <h2 class="text-lg font-semibold mb-4 text-center">Jumlah Mahasiswa per Program Studi</h2>
    <canvas id="myBarChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            var ctx = document.getElementById('myBarChart').getContext('2d');
            var chartData = @json($chartData);

            new Chart(ctx, {
                type: 'bar', // Menggunakan bar chart
                data: {
                    labels: chartData.labels,
                    datasets: chartData.datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true // Memulai sumbu y dari 0
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                            position: 'top',
                        },
                    }
                }
            });
        });
    </script>
</div>
