<script>
// Ambil data dari PHP (pastikan formatnya sesuai dengan format JavaScript)
var ordersData = <?php echo json_encode($orders_last_10_days ?? []); ?>;

// Siapkan label dan data untuk chart
var labels = [];
var data = [];

// Loop untuk mengisi data chart dari hasil query
ordersData.forEach(function(order) {
    labels.push(order.order_date); // Tanggal
    data.push(order.order_count); // Jumlah pesanan
});

// Mendapatkan konteks chart
var statistics_chart = document.getElementById("myChart").getContext('2d');

// Membuat chart
var myChart = new Chart(statistics_chart, {
    type: 'line',
    data: {
        labels: labels, // Tanggal yang didapat dari hasil query
        datasets: [{
            label: 'Statistics',
            data: data, // Jumlah pesanan per hari
            borderWidth: 5,
            borderColor: '#6777ef',
            backgroundColor: 'transparent',
            pointBackgroundColor: '#fff',
            pointBorderColor: '#6777ef',
            pointRadius: 4
        }]
    },
    options: {
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                ticks: {
                    stepSize: 50
                }
            }],
            xAxes: [{
                gridLines: {
                    color: '#fbfbfb',
                    lineWidth: 2
                }
            }]
        },
    }
});
</script>