<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?=$title?></h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Order Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                <?=$orders_today?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Order Belum Selesai</h4>
                            </div>
                            <div class="card-body">
                                <?=$orders_unfinished?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                <?='Rp. ' . number_format($income_today, 0, ',', '.')?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan bulan ini</h4>
                            </div>
                            <div class="card-body">
                                <?='Rp. ' . number_format($income_this_month, 0, ',', '.')?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4>Order Yang Belum Selesai</h4>
                        </div>
                        <!-- Tambahkan kelas overflow-horizontal pada elemen pembungkus -->
                        <div class="card-body overflow-horizontal">
                            <?php if (!empty($orders)): ?>
                            <div class="row flex-nowrap">
                                <?php foreach ($orders as $order): ?>
                                <div class="col-lg-12">
                                    <div class="card border border-gray-dark">
                                        <div class="card-header">
                                            <h4>Order #<?=$order['id']?></h4>
                                            <hr>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                                                    <p><strong>Customer Name:</strong> <?=$order['customer_name']?></p>
                                                    <p><strong>Table Number:</strong> <?=$order['table_number']?></p>
                                                    <p><strong>Order Date:</strong> <?=$order['created_at']?></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                                                    <p><strong>Total:</strong> Rp.<?=number_format($order['total'], 0)?>
                                                    </p>
                                                    <p><strong>Amount Paid:</strong>
                                                        Rp.<?=number_format($order['amount_paid'], 0)?></p>
                                                    <p><strong>Change:</strong>
                                                        Rp.<?=number_format($order['change'], 0)?></p>
                                                </div>
                                            </div>
                                            <!-- Bagian untuk menampilkan detail produk -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5>Products Ordered</h5>
                                                    <ul>
                                                        <?php foreach ($order['products'] as $product): ?>
                                                        <li>
                                                            <?=$product['name']?> (Qty: <?=$product['quantity']?>) -
                                                            Rp.<?=number_format($product['price'], 0)?>
                                                        </li>
                                                        <?php endforeach;?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-end">
                                            <a href="<?=site_url('dashboard/update_status/' . $order['id'])?>"
                                                class="btn btn-primary">Selesai</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <?php else: ?>
                            <div class="text-center">
                                <p>Belum ada order lagi</p>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4>Statistik Penjualan 10 Hari Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>