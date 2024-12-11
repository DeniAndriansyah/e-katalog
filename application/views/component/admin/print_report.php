<script>
$('#cetakLaporanBtn').on('click', function() {
    var dateRange = $('.daterange-cus').val(); // Ambil nilai daterange
    window.location.href = "<?=base_url('report/print')?>?date_range=" + dateRange;
});
</script>