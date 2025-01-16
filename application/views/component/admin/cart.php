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
    $('#place-order').on('click', function () {
    // Tampilkan SweetAlert untuk input data pelanggan
    promptUserInput(
        'Enter Table Number',
        'Table Number',
        'Table number cannot be empty!'
    ).then((tableNumber) => {
        if (tableNumber) {
            // Validasi tableNumber tidak boleh mengandung huruf
            if (!/^\d+$/.test(tableNumber)) {
                Swal.fire('Error', 'Inputan harus berupa angka!', 'error');
                return;
            }

            promptUserInput(
                'Enter Customer Name',
                'Customer Name',
                'Customer name cannot be empty!'
            ).then((customerName) => {
                if (customerName) {
                    // Validasi customerName tidak boleh mengandung angka
                    if (!/^[a-zA-Z\s]+$/.test(customerName)) {
                        Swal.fire('Error', 'Inputan harus berupa huruf!', 'error');
                        return;
                    }

                    promptUserInput(
                        'Enter Amount Paid',
                        'Amount Paid',
                        'Amount paid cannot be empty!',
                        true // Aktifkan format currency
                    ).then((amountPaid) => {
                        if (amountPaid) {
                            // Kirim data pesanan ke server
                            placeOrder(
                                tableNumber,
                                customerName,
                                amountPaid.replace(/[^0-9]/g, '')
                            );
                        }
                    });
                }
            });
        }
    });
});


    // Fungsi untuk SweetAlert input
    function promptUserInput(title, placeholder, validationMessage, formatCurrency = false) {
        return Swal.fire({
            title: title,
            input: 'text',
            inputPlaceholder: placeholder,
            showCancelButton: true,
            confirmButtonText: 'Next',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return validationMessage;
                }
            },
            didOpen: (popup) => {
                const input = Swal.getInput();
                if (formatCurrency) {
                    input.addEventListener('input', function() {
                        // Ambil nilai mentah tanpa simbol
                        let rawValue = input.value.replace(/[^0-9]/g, '');

                        // Format angka menjadi mata uang
                        input.value = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            minimumFractionDigits: 0
                        }).format(rawValue);
                    });
                }
            }
        }).then((result) => {
            return result.isConfirmed ? result.value : null;
        });
    }


    // Fungsi untuk mengirim pesanan ke server
    function placeOrder(tableNumber, customerName, amountPaid) {
        $.ajax({
            url: "<?=base_url('order/place_order')?>",
            method: "POST",
            data: {
                table_number: tableNumber,
                customer_name: customerName,
                amount_paid: amountPaid
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    handleSuccess(response.order_id);
                } else {
                    handleError(response.message);
                }
            },
            error: function() {
                handleError('Failed to place the order. Please try again later.');
            }
        });
    }

    // Fungsi untuk menangani sukses
    function handleSuccess(orderId) {
        Swal.fire({
            title: 'Success',
            text: 'Order has been placed successfully!',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            const printUrl = "<?=base_url('order/print_receipt/')?>" + orderId;
            window.open(printUrl, '_blank');
            location.reload(); // Reload halaman utama (opsional)
        });
    }

    // Fungsi untuk menangani error
    function handleError(message) {
        Swal.fire({
            title: 'Error',
            text: message,
            icon: 'error'
        });
    }

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