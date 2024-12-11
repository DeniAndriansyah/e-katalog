<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $orders = $this->Order_m->get_orders_by_status('diproses');
        $orders_today = $this->Order_m->count_orders_today();
        $income_today = $this->Order_m->total_income_today();
        $income_this_month = $this->Order_m->total_income_month();
        $orders_last_10_days = $this->Order_m->orders_per_day_last_10_days();

        $data = [
            'title' => 'Dashboard',
            'orders' => $orders,
            'orders_today' => $orders_today,
            'orders_unfinished' => count($orders),
            'income_today' => $income_today,
            'income_this_month' => $income_this_month,
            'orders_last_10_days' => $orders_last_10_days,
        ];

        $this->load->view('component/admin/header', $data);
        $this->load->view('component/admin/sidebar');
        $this->load->view('pages/admin/dashboard/index', $data);
        $this->load->view('component/admin/footer', $data);
    }

    public function update_status($id)
    {
        $status = 'selesai';
        $this->Order_m->update_order_status($id, $status);
        $this->session->set_flashdata('success', 'Status pesanan berhasil diperbarui.');
        redirect('dashboard');
    }
}
