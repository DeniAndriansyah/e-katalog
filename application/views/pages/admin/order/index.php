<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?=$title?></h1>
            <div class="section-header-button">
                <a href="<?=base_url('order/add')?>" class="btn btn-primary"><span class="fa fa-plus"></span>
                    Tambah</a>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!-- <div class="alert alert-danger">asas</div> -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-normal table-striped">
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
foreach ($orders as $order) {?>
                                        <tr>
                                            <td><?=$no++;?></td>
                                            <td><?=$order->table_number?></td>
                                            <td><?=$order->customer_name?></td>
                                            <td><?=$order->order_date?></td>
                                            <td><?=$order->status?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#orderDetailModal"
                                                    onclick="loadOrderDetail(<?=$order->id?>)">
                                                    <span class="fa fa-eye"></span> Detail
                                                </button>
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
        </div>
    </section>
</div>

<!-- Modal detail order -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten detail order akan dimuat di sini -->
                <div id="modalOrderContent" class="d-flex justify-content-center">Loading...</div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <a href="#" id="printBtn" class="btn btn-primary"><span class="fa fa-print"></span></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>