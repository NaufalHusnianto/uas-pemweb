<!-- resources/views/profile/dashboard-admin.blade.php -->
<x-admin-layout>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">Order Tracking Overview by Hour</h1>
        <canvas id="orderChart" class="w-full h-64"></canvas>
    </div>

    <!-- Tambahkan script untuk grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data yang dikirimkan dari controller (orderTimes dan orderCounts)
        const orderTimes = @json($orderTimes); // Format: ['01:00', '02:00', ...]
        const orderCounts = @json($orderCounts); // Format: [5, 8, 3, ...]

        const ctx = document.getElementById('orderChart').getContext('2d');

        const orderChart = new Chart(ctx, {
            type: 'line', // Tipe grafik garis
            data: {
                labels: orderTimes, // Menampilkan jam sebagai label sumbu X
                datasets: [
                    {
                        label: 'Orders per Hour', // Judul dataset
                        data: orderCounts, // Data jumlah order per jam
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna area di bawah garis
                        borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                        borderWidth: 2,
                        fill: true, // Menambahkan area fill di bawah garis
                        tension: 0.4, // Membuat garis melengkung
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
                            text: 'Time (Hour)', // Label sumbu X
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Order Count', // Label sumbu Y
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // Menampilkan langkah nilai 1
                        },
                    },
                },
            },
        });
    </script>
</x-admin-layout>
