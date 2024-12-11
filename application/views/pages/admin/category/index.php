<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?=$title?></h1>
            <div class="section-header-button">
                <a href="<?=base_url('category/add')?>" class="btn btn-primary"><span class="fa fa-plus"></span>
                    Tambah</a>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!-- <div class="alert alert-danger">asas</div> -->
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-normal table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
foreach ($categories as $category) {?>
                                    <tr>
                                        <td><?=$no++;?></td>
                                        <td><?=$category->name?></td>
                                        <td>
                                            <a href="<?=base_url('category/edit/' . $category->id)?>"
                                                class="btn btn-sm btn-warning"><span class="fa fa-edit"></span> Edit</a>
                                            <a href="<?=base_url('category/delete/' . $category->id)?>"
                                                class="btn btn-sm btn-danger btn-hapus"><span
                                                    class="fa fa-trash"></span> Del</a>
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