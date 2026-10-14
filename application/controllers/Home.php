<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faculty_model');
        $this->load->model('Staff_model');
    }

    public function index()
    {
        $data['title'] = 'Staf Akademik - Universitas Sam Ratulangi';
        $data['faculties'] = $this->Faculty_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }
}
