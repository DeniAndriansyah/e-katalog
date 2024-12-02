<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
            <!-- <div class= "section-header-button">
                <a href="<?= base_url('category/add')?>" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah</a>
            </div> -->
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!-- <div class="alert alert-danger">asas</div> -->
                    <div class="card">
                        <div class="card-body">
                          <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Table Number</th>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                 foreach ($orders as $order) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $order->table_number ?></td>
                                        <td><?= $order->customer_name ?></td>
                                        <td><?= $order->order_date ?></td>
                                        <td><?= $order->status ?></td>
                                        <td>
                                            <a href="<?= base_url('order/delete/'. $order->id)?>" class="btn btn-sm btn-warning btn-hapus"><span class="fa fa-trash"></span> Del</a>
                                            <a href="<?= base_url('order/delete/'. $order->id)?>" class="btn btn-sm btn-danger btn-hapus"><span class="fa fa-trash"></span> Del</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>