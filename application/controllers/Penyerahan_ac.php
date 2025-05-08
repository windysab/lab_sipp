<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penyerahan_ac extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_Penyerahan_ac");
	}

	public function index()
	{
		// Set default values
		$data = [
			'title' => 'Laporan Penyerahan Akta Cerai',
			'datafilter' => [],
		];

		// Current month and year as default
		$data['current_month'] = date('m');
		$data['current_year'] = date('Y');

		// Process form submission
		if ($this->input->post('btn')) {
			$jenis_laporan = $this->input->post('jenis_laporan', TRUE);
			$lap_tahun = $this->input->post('lap_tahun', TRUE);

			// If yearly report, set bulan to null
			$lap_bulan = ($jenis_laporan === 'tahunan') ? null : $this->input->post('lap_bulan', TRUE);

			// Get data from model
			$data['datafilter'] = $this->M_Penyerahan_ac->penyerahan_ac($lap_bulan, $lap_tahun);

			// Set for form persistence
			$data['selected_month'] = $lap_bulan;
			$data['selected_year'] = $lap_tahun;
			$data['jenis_laporan'] = $jenis_laporan;
		}

		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_penyerahan_ac', $data);
		$this->load->view('template/new_footer');
	}
}
