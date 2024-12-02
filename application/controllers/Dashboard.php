<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
        $data = [
            'title' => 'Dashboard'
        ];

		$this->load->view('component/admin/header', $data);
		$this->load->view('component/admin/sidebar');
		$this->load->view('pages/admin/dashboard/index', $data);
		$this->load->view('component/admin/footer');
	}
}
