<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_m extends CI_Model
{

    // Menambahkan pesanan baru ke tabel order
    public function insert_order($order_data)
    {
        $this->db->insert('order', $order_data);
        return $this->db->insert_id(); // Mengembalikan ID pesanan yang baru dimasukkan
    }

    // Menambahkan detail pesanan ke tabel order_detail
    public function insert_order_detail($order_detail)
    {
        $this->db->insert('order_detail', $order_detail);
    }

    // Mendapatkan daftar pesanan berdasarkan status
    public function get_orders_by_status($status = 'diproses')
    {

        $this->db->select('order.*, order_detail.id as detail_id,order_detail.quantity, product.id as product_id, product.name as product_name , product.price as product_price');
        $this->db->from('order');
        $this->db->join('order_detail', 'order.id = order_detail.order_id', 'left');
        $this->db->join('product', 'order_detail.product_id = product.id', 'left');
        $this->db->where('order.status', $status);
        $this->db->order_by('order.created_at', 'ASC');
        $query = $this->db->get();

        $results = $query->result();

        $orders = [];
        foreach ($results as $row) {
            $orderId = $row->id;

            // Jika order belum ada di array hasil, tambahkan
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'id' => $row->id,
                    'status' => $row->status,
                    'created_at' => $row->created_at,
                    'customer_name' => $row->customer_name, // Contoh field lain di tabel order
                    'table_number' => $row->table_number, // Contoh field lain di tabel order
                    'order_date' => $row->order_date, // Contoh field lain di tabel order
                    'total' => $row->total,
                    'amount_paid' => $row->amount_paid,
                    'change' => $row->change,
                    'products' => [], // Array untuk menampung produk terkait
                ];
            }

            // Tambahkan detail produk ke dalam array 'products'
            $orders[$orderId]['products'][] = [
                'product_id' => $row->product_id,
                'name' => $row->product_name,
                'quantity' => $row->quantity,
                'price' => $row->product_price,
                'detail_id' => $row->detail_id,
            ];
        }

        // Konversi hasil menjadi array numerik
        return array_values($orders);
    }

    // menghitung order 10 hari terakhir
    public function orders_per_day_last_10_days()
    {
        // Menghitung 10 hari terakhir
        $start_date = date('Y-m-d', strtotime('-10 days'));
        $end_date = date('Y-m-d');

        // Query untuk mendapatkan jumlah pesanan per hari
        $this->db->select('DATE(created_at) as order_date, COUNT(*) as order_count');
        $this->db->where('DATE(created_at) >=', $start_date);
        $this->db->where('DATE(created_at) <=', $end_date);
        $this->db->group_by('DATE(created_at)');
        $this->db->order_by('DATE(created_at)', 'ASC'); // Urutkan berdasarkan tanggal
        $query_result = $this->db->get('order')->result();

        // Membuat array default untuk 10 hari terakhir
        $dates = [];
        for ($i = 10; $i >= 0; $i--) {
            $dates[date('Y-m-d', strtotime("-$i days"))] = 0;
        }

        // Memasukkan hasil query ke dalam array default
        foreach ($query_result as $row) {
            $dates[$row->order_date] = $row->order_count;
        }

        // Mengembalikan data dalam format yang bisa digunakan
        $result = [];
        foreach ($dates as $date => $count) {
            $result[] = [
                'order_date' => $date,
                'order_count' => $count,
            ];
        }

        return $result;
    }

    // menghitung order hari ini
    public function count_orders_today()
    {
        $today = date('Y-m-d');
        $this->db->where('DATE(created_at) =', $today);
        return $this->db->count_all_results('order');
    }

    // menghitung penghasilan hari ini
    public function total_income_today()
    {
        $today = date('Y-m-d');
        $this->db->select_sum('total');
        $this->db->where('DATE(created_at) =', $today);
        $this->db->where('status', 'selesai');
        $query = $this->db->get('order');
        return $query->row()->total;
    }
    // menghitung penghasilan bulan ini
    public function total_income_month()
    {
        $this->db->select_sum('total');
        $this->db->where('MONTH(created_at) =', date('m'));
        $this->db->where('status', 'selesai');
        $query = $this->db->get('order');
        return $query->row()->total;
    }

    // Mendapatkan detail pesanan berdasarkan ID order
    public function get_order_details($order_id)
    {
        $this->db->select('od.*, p.name as product_name, p.price as product_price, o.customer_name, o.table_number, o.order_date');
        $this->db->from('order_detail od');
        $this->db->join('product p', 'p.id = od.product_id');
        $this->db->join('order o', 'o.id = od.order_id');
        $this->db->where('od.order_id', $order_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan semua produk untuk order
        } else {
            log_message('error', 'Order details not found for Order ID: ' . $order_id);
            return null; // Jika tidak ditemukan
        }
    }

    // Mengupdate status pesanan
    public function update_order_status($order_id, $status)
    {
        $this->db->where('id', $order_id);
        $this->db->update('order', ['status' => $status]);
    }

    // Mengambil pesanan berdasarkan ID
    public function get_order_by_id($order_id)
    {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('id', $order_id);
        return $this->db->get()->row();
    }

    public function get_filtered_data($start_date = null, $end_date = null)
    {
        $this->db->select('
        p.name,
        COALESCE(SUM(od.quantity), 0) as quantity_sold,
        COALESCE(SUM(od.subtotal), 0) as total
    ');
        $this->db->from('product p');
        $this->db->join('order_detail od', 'od.product_id = p.id', 'left'); // Left join to include products with no sales
        $this->db->join('order o', 'o.id = od.order_id', 'left'); // Join orders for date filtering

        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(o.created_at) >=', $start_date);
            $this->db->where('DATE(o.created_at) <=', $end_date);
        }

        $this->db->group_by('p.id'); // Group by product ID to calculate SUM for each product
        $this->db->order_by('p.name', 'ASC'); // Optional: Order by product name

        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data_table($start_date = null, $end_date = null, $search = null, $order_column = 'p.name', $order_dir = 'ASC', $length = null, $start = 0)
    {
        // Total records tanpa filter
        $totalRecords = $this->db->count_all('product');

        // Query utama
        $this->db->select('
            p.name AS product_name,
            COALESCE(SUM(od.quantity), 0) AS quantity_sold,
            COALESCE(SUM(od.subtotal), 0) AS total
        ');
        $this->db->from('product p');
        $this->db->join('order_detail od', 'od.product_id = p.id', 'left');
        $this->db->join('order o', 'o.id = od.order_id', 'left');

        // Filter tanggal
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(o.created_at) >=', $start_date);
            $this->db->where('DATE(o.created_at) <=', $end_date);
        }

        // Filter pencarian
        if (!empty($search)) {
            $this->db->group_start()
                ->like('p.name', $search)
                ->or_like('od.quantity', $search)
                ->or_like('od.subtotal', $search)
                ->group_end();
        }

        // Grouping dan sorting
        $this->db->group_by('p.id');
        $this->db->order_by($order_column, $order_dir);

        // Pagination
        if ($length != -1) {
            $this->db->limit($length, $start);
        }

        // Eksekusi query
        $query = $this->db->get();

        // Log query untuk debug
        // log_message('debug', $this->db->last_query());

        return [
            'totalRecords' => $totalRecords,
            'filteredRecords' => $query->num_rows(),
            'data' => $query->result(),
        ];

    }

}
