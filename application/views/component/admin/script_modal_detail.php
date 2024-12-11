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
            // Tambahkan URL print_receipt ke tombol cetak
            const printUrl = "<?=base_url('order/print_receipt/')?>" + orderId;
            $('#printBtn').attr('href', printUrl).attr('target', '_blank');

        },
        error: function() {
            $('#modalOrderContent').html(
                '<p class="text-danger">Failed to load order details. Please try again later.</p>');
        }
    });
}
</script>