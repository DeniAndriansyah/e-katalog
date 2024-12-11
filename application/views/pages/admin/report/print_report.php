<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .header h1 {
        margin: 0;
    }

    .header p {
        margin: 0;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    .footer {
        text-align: center;
        margin-top: 30px;
    }

    .footer p {
        font-size: 12px;
        color: #555;
    }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div class="header">
        <h1>Laporan Penjualan Produk</h1>
        <p>Rentang Waktu: <?=$date_range?></p>
        <p>Printed on: <?=date('Y-m-d H:i:s')?></p>
    </div>

    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah Terjual</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            <?php
$no = 1;
$total_pendapatan = 0; // Variabel untuk menyimpan total pendapatan
?>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$order->name?></td>
                <td><?=$order->quantity_sold?></td>
                <td><?='Rp.' . number_format($order->total, 2, ',', '.')?></td>
            </tr>
            <?php
$total_pendapatan += $order->total; // Tambahkan total penjualan ke total pendapatan
?>
            <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total Pendapatan</strong></td>
                <td><strong><?='Rp.' . number_format($total_pendapatan, 2, ',', '.')?></strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; <?=date('Y')?> - Laporan Penjualan</p>
    </div>
</body>


</html>