<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2024. <div class="bullet"></div>INZOMNIA<a href="#"></a>
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="<?=base_url('assets/')?>modules/jquery.min.js"></script>
<script src="<?=base_url('assets/')?>modules/popper.js"></script>
<script src="<?=base_url('assets/')?>modules/tooltip.js"></script>
<script src="<?=base_url('assets/')?>modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=base_url('assets/')?>modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?=base_url('assets/')?>modules/moment.min.js"></script>
<script src="<?=base_url('assets/')?>js/stisla.js"></script>

<!-- JS Libraies -->
<script src="<?=base_url('assets/')?>modules/sweetalert/sweetalert2.all.js"></script>
<script src="<?=base_url('assets/')?>modules/chart.min.js"></script>
<script src="<?=base_url('assets/')?>modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url('assets/')?>modules/datatables/datatables.min.js"></script>
<script src="<?=base_url('assets/')?>modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets/')?>modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?=base_url('assets/')?>modules/jquery-ui/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script src="<?=base_url('assets/')?>modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>



<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="<?=base_url('assets/')?>js/scripts.js"></script>
<script src="<?=base_url('assets/')?>js/custom.js"></script>

<!-- Confirm Delete -->
<script>
$(document).ready(function() {
    // Menghentikan tautan dari navigasi langsung
    $('.btn-hapus').on('click', function(event) {
        event.preventDefault(); // Mencegah aksi default tautan
        var href = $(this).attr('href'); // Ambil URL dari atribut href
        console.log(href);


        // Menampilkan dialog konfirmasi SweetAlert
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL jika dikonfirmasi
                window.location.href = href;
            }
        });
    });
});
</script>


<!-- ALERT -->
<?php
$alertType = '';
$alertTitle = '';
$alertMessage = '';

if ($this->session->flashdata('success')) {
    $alertType = 'success';
    $alertTitle = 'Good Job!';
    $alertMessage = $this->session->flashdata('success');
} elseif ($this->session->flashdata('warning')) {
    $alertType = 'warning';
    $alertTitle = 'Oops!';
    $alertMessage = $this->session->flashdata('warning');
} elseif ($this->session->flashdata('error')) {
    $alertType = 'error';
    $alertTitle = 'Error!';
    $alertMessage = $this->session->flashdata('error');
}

if ($alertType): ?>
<script>
$(document).ready(function() {
    Swal.fire("<?=$alertTitle;?>", <?=json_encode($alertMessage);?>, "<?=$alertType;?>");
});
</script>
<?php endif;?>


<!-- Data Tables -->
<script>
$(".table-normal").DataTable();


$('.daterange-cus').daterangepicker({
    locale: {
        format: 'YYYY-MM-DD'
    },
    drops: 'down',
    opens: 'right',
});

let table = $(".table-report").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: 'report/data',
        type: 'POST',
        data: function(d) {
            d.date_range = $('.daterange-cus').val()
        }
    },
    columns: [{
            data: 'no'
        },
        {
            data: 'product_name'
        },
        {
            data: 'quantity_sold'
        },
        {
            data: 'total',
            render: function(data, type, row) {
                // Format data menjadi currency
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0
                }).format(data);
            }
        }
    ]
});

$('.daterange-cus').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    table.ajax.reload(); // Reload DataTable when date is selected
});

$('.daterange-cus').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
    table.ajax.reload(); // Reload DataTable when date is cleared
});
</script>

<!-- SLUG AUTO -->
<script>
$(document).ready(function() {
    $('#title-slug').on('keyup', function() {
        var title = $(this).val();
        var slug = title.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        $('#slug').val(slug);
    });
});
</script>

<!-- FANCYBOX -->
<script>
$(document).ready(function() {
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

    $(".zoom").hover(function() {

        $(this).addClass('transition');
    }, function() {

        $(this).removeClass('transition');
    });
});

$.uploadPreview({
    input_field: "#image-upload", // Default: .image-upload
    preview_box: "#image-preview", // Default: .image-preview
    label_field: "#image-label", // Default: .image-label
    label_default: "Choose File", // Default: Choose File
    label_selected: "Change File", // Default: Change File
    no_label: false, // Default: false
    success_callback: null // Default: null
});
</script>
<!-- Add to cart -->
<?php $this->load->view('component/admin/cart');?>
<!-- Script modal detail -->
<?php $this->load->view('component/admin/script_modal_detail');?>
<!-- Script print report -->
<?php $this->load->view('component/admin/print_report');?>
<!-- Chart -->
<?php $this->load->view('component/admin/chart');?>
<!-- Price input -->
<?php $this->load->view('component/admin/price_input');?>
</body>

</html>