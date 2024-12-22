<!-- resources/views/profile/dashboard-admin.blade.php -->
<x-admin-layout>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">Order Tracking Overview</h1>
        <canvas id="orderChart" class="w-full h-64"></canvas>
    </div>

    <!-- Tambahkan script untuk grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data yang dikirimkan dari controller (orderIDs)
        const orderIDs = @json($orderIDs); // Menggunakan data orderIDs dari controller

        const ctx = document.getElementById('orderChart').getContext('2d');

        const orderChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik (bar chart)
            data: {
                labels: orderIDs, // Menampilkan order_id sebagai label
                datasets: [
                    {
                        label: 'Order IDs', // Judul dataset
                        data: orderIDs.map(() => 1), // Menampilkan nilai tetap (contoh: 1 untuk setiap order_id)
                        backgroundColor: 'rgba(75, 192, 192, 0.6)', // Warna batang
                        borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Order IDs', // Label sumbu X
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Count', // Label sumbu Y
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // Menampilkan nilai 1 untuk setiap order_id
                        },
                    },
                },
            },
        });
    </script>
</x-admin-layout>
