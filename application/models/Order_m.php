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
    public function get_orders_by_status($status = 'pending')
    {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('status', $status);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
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
}
