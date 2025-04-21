<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Itsbat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_Itsbat");
    }

   public function index()
    {
		$lap_bulan = $this->input->post('lap_bulan');
        $lap_tahun = $this->input->post('lap_tahun');
		$data['datafilter'] = $this->M_Itsbat->itsbat($lap_bulan, $lap_tahun);
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_itsbat', $data);
		$this->load->view('template/new_footer');	
    }
}
