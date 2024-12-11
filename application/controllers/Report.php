<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login')) {
            redirect('auth');
        }
        $this->load->model('Base_m');
        $this->load->model('Order_m');
    }

    public function index()
    {
        $data = [
            'title' => 'Report',
        ];

        $this->load->view('component/admin/header', $data);
        $this->load->view('component/admin/sidebar');
        $this->load->view('pages/admin/report/index', $data);
        $this->load->view('component/admin/footer');
    }

    public function print()
    {
        $date_range = $this->input->get('date_range');
        // log_message('debug', 'Received date range: ' . $date_range);
        $start_date = null;
        $end_date = null;

        if (!empty($date_range)) {
            $dates = explode(' - ', $date_range);
            if (count($dates) == 2) {
                $start_date = trim($dates[0]);
                $end_date = trim($dates[1]);
            }
        }

        // Panggil model untuk mendapatkan data yang difilter
        $result = $this->Order_m->get_filtered_data($start_date, $end_date);

        // Pastikan model mengembalikan data dengan benar
        if ($result === null) {
            log_message('error', 'No data found for the selected date range');
            // Handle case jika tidak ada data yang ditemukan
            return;
        }

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'title' => 'Report | ' . $date_range,
            'date_range' => $date_range,
            'orders' => $result, // pastikan result memiliki field 'data'
        ];

        // Load view untuk menampilkan report
        $this->load->view('pages/admin/report/print_report', $data);
    }

    public function data()
    {
        $date_range = $this->input->post('date_range');
        $start_date = null;
        $end_date = null;

        if (!empty($date_range)) {
            $dates = explode(' - ', $date_range);
            $start_date = $dates[0];
            $end_date = $dates[1];
        }

        $search = $this->input->post('search')['value'];
        $order_column_index = $this->input->post('order')[0]['column']; // Index kolom untuk sorting
        $order_dir = $this->input->post('order')[0]['dir']; // Arah sorting (asc/desc)
        $length = $this->input->post('length'); // Jumlah data per halaman
        $start = $this->input->post('start'); // Data mulai dari index

        // Kolom untuk sorting berdasarkan index
        $columns = ['p.id', 'p.name', 'quantity_sold', 'total'];
        $order_column = $columns[$order_column_index];

        // Panggil model
        $result = $this->Order_m->get_filtered_data_table($start_date, $end_date, $search, $order_column, $order_dir, $length, $start);

        // Menambahkan nomor urut pada hasil data
        $no = $start + 1; // Nomor urut dimulai dari nilai $start + 1
        foreach ($result['data'] as $key => $value) {
            $result['data'][$key]->no = $no++; // Menambahkan kolom 'no' untuk nomor urut
        }

        // Log hasil query
        log_message('debug', 'Filtered Data Result: ' . print_r($result, true));
        // Kirim data dalam format JSON untuk DataTables
        $response = [
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $result['totalRecords'],
            "recordsFiltered" => $result['filteredRecords'],
            "data" => $result['data'],
        ];

        echo json_encode($response);
    }

}
