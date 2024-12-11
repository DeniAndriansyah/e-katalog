<script>
function formatCurrency(input) {
    // Mendapatkan nilai input dan menghapus semua karakter kecuali angka
    let value = input.value.replace(/[^,\d]/g, '');
    // Format ke dalam bentuk angka dengan koma sebagai pemisah ribuan
    let formatted = new Intl.NumberFormat('id-ID').format(value);
    input.value = 'Rp ' + formatted;
}
</script>
