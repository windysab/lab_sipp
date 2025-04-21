<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usia_cerai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_Usia_cerai");
    }

   public function index()
    {
		$lap_bulan = $this->input->post('lap_bulan');
        $lap_tahun = $this->input->post('lap_tahun');
		$data['datafilter'] = $this->M_Usia_cerai->usia_cerai($lap_bulan, $lap_tahun);
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_usia_cerai', $data);
		$this->load->view('template/new_footer');	
    }
}
