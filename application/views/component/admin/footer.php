<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2024. <div class="bullet"></div> by <a href="#"></a>
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
$(".table").dataTable();
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

<!-- Add To Cart -->
<script>
$(document).ready(function() {
    // Fungsi untuk memuat data keranjang
    function loadCart() {
        $.ajax({
            url: "<?=base_url('order/load_cart')?>",
            method: "GET",
            dataType: "json",
            success: function(response) {
                let cartHtml = '';
                let total = 0;

                response.cart.forEach(item => {
                    cartHtml += `
                        <div class="receipt-item">
    <p><strong>${item.name}</strong></p>
    <p>Rp ${item.price.toLocaleString()} x
        <button class="btn btn-sm btn-secondary btn-decrease" data-id="${item.product_id}">-</button>
        <span id="quantity-${item.product_id}">${item.quantity}</span>
        <button class="btn btn-sm btn-secondary btn-increase" data-id="${item.product_id}">+</button>
        = Rp ${(item.subtotal).toLocaleString()}</p>
</div>
`;
                    total += item.subtotal;
                });

                $('#cart-body').html(cartHtml);
                $('#total-price').text(`Rp ${total.toLocaleString()}`);
            }
        });
    }

    // Tambahkan produk ke keranjang saat tombol "Tambah" diklik
    $(document).on('click', '.btn-add-to-cart', function() {
        const product_id = $(this).data('id');
        const product_name = $(this).data('name');
        const product_price = $(this).data('price');

        $.ajax({
            url: "<?=base_url('order/add_to_cart')?>",
            method: "POST",
            data: {
                product_id,
                product_name,
                product_price,
                quantity: 1
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    // alert('Produk berhasil ditambahkan ke keranjang!');
                    loadCart();
                }
            }
        });
    });

    // Ketika tombol + diklik
    $(document).on('click', '.btn-increase', function() {
        // $('.btn-increase').on('click', function() {
        console.log("test");

        var productId = $(this).data('id');
        var quantityElement = $('#quantity-' + productId);
        var quantity = parseInt(quantityElement.text());

        // Meningkatkan jumlah
        quantity++;
        quantityElement.text(quantity);

        // Update subtotal
        var price = parseFloat($(this).closest('.receipt-item').find('p').first().text().replace('Rp ',
            '').replace(' x', '').trim());
        var subtotal = price * quantity;
        $(this).closest('.receipt-item').find('p').last().text('Rp ' + subtotal.toLocaleString());

        // Update session cart dengan jumlah baru
        updateCart(productId, quantity);
    });

    $(document).on('click', '.btn-decrease', function() {
        console.log("Tombol - diklik");

        var productId = $(this).data('id');
        var quantityElement = $('#quantity-' + productId);
        var quantity = parseInt(quantityElement.text());

        // Mengurangi jumlah jika lebih dari 1
        if (quantity > 1) {
            quantity--;
            quantityElement.text(quantity);

            // Update subtotal
            var price = parseFloat($(this).closest('.receipt-item').find('p').first().text().replace(
                'Rp ', '').replace(' x', '').trim());
            var subtotal = price * quantity;
            $(this).closest('.receipt-item').find('p').last().text('Rp ' + subtotal.toLocaleString());

            // Update session cart dengan jumlah baru
            updateCart(productId, quantity);
        } else {
            // Jika quantity sudah 1 dan tombol - ditekan, gunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin ingin menghapus produk ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Hapus produk dari keranjang di session
                    removeFromCart(productId);
                    // Hapus elemen produk di struk
                    $(this).closest('.receipt-item').remove();
                    Swal.fire('Dihapus!', 'Produk berhasil dihapus.', 'success');
                }
            });
        }
    });

    // Simpan pesanan
    $('#place-order').on('click', function() {
        let table_number, customer_name;

        // SweetAlert untuk input nomor meja
        Swal.fire({
            title: 'Enter Table Number',
            input: 'text',
            inputPlaceholder: 'Table Number',
            showCancelButton: true,
            confirmButtonText: 'Next',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'Table number cannot be empty!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                table_number = result.value; // Simpan nomor meja

                // SweetAlert untuk input nama pelanggan
                Swal.fire({
                    title: 'Enter Customer Name',
                    input: 'text',
                    inputPlaceholder: 'Customer Name',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Customer name cannot be empty!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        customer_name = result.value; // Simpan nama pelanggan

                        // Jalankan AJAX hanya setelah kedua input valid
                        $.ajax({
                            url: "<?=base_url('order/place_order')?>",
                            method: "POST",
                            data: {
                                table_number,
                                customer_name
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    // Tampilkan pesan sukses
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Order has been placed successfully!',
                                        icon: 'success',
                                        timer: 2000, // Timer 2 detik
                                        showConfirmButton: false
                                    }).then(() => {
                                        location
                                            .reload(); // Reload halaman setelah SweetAlert selesai
                                    });
                                } else {
                                    // Tampilkan pesan error
                                    Swal.fire({
                                        title: 'Error',
                                        text: response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Failed to place the order. Please try again later.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            }
        });
    });

    // Fungsi untuk mengupdate cart di server
    function updateCart(productId, quantity) {
        $.ajax({
            url: '<?=base_url("order/update_cart")?>',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                // Handle response jika perlu
                loadCart();
            }
        });
    }

    // Fungsi untuk menghapus produk dari cart
    function removeFromCart(productId) {
        $.ajax({
            url: '<?=base_url("order/remove_from_cart")?>',
            type: 'POST',
            data: {
                product_id: productId
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error removing product:', error);
            }
        });
    }

    // Muat keranjang saat halaman dimuat
    loadCart();
});
</script>

<!-- Detail Order -->
<script>
function loadOrderDetail(orderId) {
    // Gunakan AJAX untuk mengambil detail pesanan
    $.ajax({
        url: "<?=base_url('order/detail/')?>" + orderId,
        method: "GET",
        success: function(response) {
            // Masukkan konten ke dalam modal
            $('#modalOrderContent').html(response);

        },
        error: function() {
            $('#modalOrderContent').html(
                '<p class="text-danger">Failed to load order details. Please try again later.</p>');
        }
    });
}
</script>
</body>

</html>