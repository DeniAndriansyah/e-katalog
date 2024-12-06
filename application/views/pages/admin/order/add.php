<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?=$title?></h1>
        </div>

        <div class="section-body">
            <div class="row">
                <!-- Bagian kiri untuk produk -->
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="row">
                        <!-- Looping Produk -->
                        <?php foreach ($products as $product): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <img src="<?=base_url('assets/uploads/product/' . $product->image)?>"
                                    class="card-img-top" alt="<?=$product->name?>"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?=$product->name?></h5>
                                    <p class="card-text">Rp <?=number_format($product->price, 0, ',', '.')?></p>
                                    <button class="btn btn-primary btn-add-to-cart" data-id="<?=$product->id?>"
                                        data-name="<?=$product->name?>" data-price="<?=$product->price?>">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>

                <!-- Bagian kanan untuk receipt -->
                <div class="col-lg-4 col-md-4 col-sm-4 d-flex justify-content-center">
                    <div class="receipt">
                        <div class="receipt-header">
                            <h4>Struk Belanja</h4>
                            <p>Nomor Meja: <span id="table-number">-</span></p>
                            <p>Nama: <span id="customer-name">-</span></p>
                            <p>Tanggal: <span id="order-date"><?=date('Y-m-d H:i:s')?></span></p>
                        </div>

                        <div class="receipt-body" id="cart-body">
                            <!-- Keranjang akan ditampilkan di sini -->
                        </div>

                        <div class="receipt-footer">
                            <p><strong>Total: <span id="total-price">Rp 0</span></strong></p>
                            <button type="button" id="place-order" class="btn btn-success mt-3">Simpan Pesanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>