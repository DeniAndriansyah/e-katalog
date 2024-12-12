<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?=$title?></h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body pt-0">
                            <div class="row px-3 d-flex align-items-center">
                                <div class="col-sm-12 col-md-4 px-0 mt-2">
                                    <div class="form-group">
                                        <label>
                                            <h5>Rentang Waktu</h5>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control daterange-cus">
                                            <button id="cetakLaporanBtn" type="button"
                                                class="btn btn-sm btn-primary ml-2">Cetak
                                                Laporan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3">
                                <div class="table-responsive">
                                    <table class="table table-report table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Product Name</th>
                                                <th>Quantity Sold</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>