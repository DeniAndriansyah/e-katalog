<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Base_m');
	}

    public function index()
    {
        $order = $this->Base_m->all('order');       
        $data = [
            'title' => 'Order',
            'orders'=> $order
        ];

        $this->load->view('component/admin/header', $data);
        $this->load->view('component/admin/sidebar');
        $this->load->view('pages/admin/order/index', $data);
        $this->load->view('component/admin/footer');
    }
}