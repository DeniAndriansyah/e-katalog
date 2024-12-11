<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?=$title?></h1>

            <div class="section-header-button">
                <a href="<?=base_url('product/add')?>" class="btn btn-primary"><span class="fa fa-plus"></span>
                    Tambah</a>
            </div>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!-- <div class="alert alert-danger">asas</div> -->
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-normal table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
foreach ($products as $product) {?>
                                    <tr>
                                        <td><?=$no++;?></td>
                                        <td><?=$product->name?></td>
                                        <td><?='Rp. ' . number_format($product->price, 0, ',', '.')?></td>
                                        <td><?=$product->status == 1 ? "Tersedia" : "Tidak Tersedia"?></td>
                                        <td>
                                            <img src="<?=base_url('assets/uploads/product/' . $product->image)?>" alt=""
                                                style="width:100px">
                                        </td>
                                        <td><?=$product->category?></td>
                                        <td>
                                            <a href="<?=base_url('product/edit/' . $product->id)?>"
                                                class="btn btn-sm btn-warning">
                                                <span class="fa fa-edit"></span> Edit
                                            </a>
                                            <a href="<?=base_url('product/delete/' . $product->id)?>"
                                                class="btn btn-sm btn-danger btn-hapus">
                                                <span class="fa fa-trash"></span> Del
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>