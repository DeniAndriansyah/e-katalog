<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class= "section-header-back">
                <a href="<?= base_url('category')?>" class="btn btn-icon"> <i class="fas fa-arrow-left"></i></a>
            </div>
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!-- <div class="alert alert-danger">asas</div> -->
                    <div class="card">
                        <div class="card-body">
                          <form action="" method="POST">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" name="name" id="name" class="form-control <?= form_error('name') ? "is-invalid" :""?>" value="<?= $category->name ?>">
                                <?= form_error('name', '<div class="invalid-feedback">', '</div>')?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> Update</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>