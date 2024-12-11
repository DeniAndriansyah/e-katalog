<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Base_m');
    }

    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        $this->load->view('pages/auth/login', $data);

    }
    public function login()
    {
        $username = htmlspecialchars($this->input->post('username'));
        $password = htmlspecialchars($this->input->post('password'));
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data = [
                'title' => 'Login',
            ];
            $this->load->view('pages/auth/login', $data);
        } else {
            // cek username
            $user = $this->Base_m->find_where('user', ['username' => $username]);
            if ($user) {
                // cek password
                if (password_verify($password, $user->password)) {
                    $data = [
                        'id' => $user->id,
                        'username' => $user->username,
                        'login' => true,
                    ];
                    $this->session->set_userdata($data);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Salah!</div>');
                    // redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username Tidak Ditemukan!</div>');
                // redirect('auth');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
