<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cerai_kua extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_cerai_kua");
    }

   public function index()
    {
		$lap_bulan = $this->input->post('lap_bulan');
        $lap_tahun = $this->input->post('lap_tahun');
		$data['datafilter'] = $this->M_cerai_kua->cerai_kua($lap_bulan, $lap_tahun);
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_cerai_kua', $data);
		$this->load->view('template/new_footer');	
    }
}
