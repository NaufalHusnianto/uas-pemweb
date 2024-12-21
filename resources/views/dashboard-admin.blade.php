<x-admin-layout>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">Sales Overview</h1>
        <canvas id="salesChart" class="w-full h-64"></canvas>
    </div>

    <!-- Tambahkan script untuk grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const salesChart = new Chart(ctx, {
            type: 'line', // Jenis grafik (line, bar, pie, dll.)
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Label bulan
                datasets: [
                    {
                        label: 'Sales Revenue',
                        data: [5000, 8000, 6000, 10000, 12000, 15000], // Data penjualan
                        borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna area bawah garis
                        borderWidth: 2,
                        tension: 0.4, // Membuat garis lebih melengkung
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // Posisi legenda
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Months',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Revenue ($)',
                        },
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
</x-admin-layout>
