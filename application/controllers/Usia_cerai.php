<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usia_cerai extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_Usia_cerai");
	}

	public function index()
	{
		$data = [];

		// Set default values if not submitted
		if (!$this->input->post('btn')) {
			$data['lap_bulan'] = date('m');
			$data['lap_tahun'] = date('Y');
			$data['jenis_laporan'] = 'bulanan';
		} else {
			$data['jenis_laporan'] = $this->input->post('jenis_laporan', TRUE);
			$data['lap_tahun'] = $this->input->post('lap_tahun', TRUE);

			// If annual report is selected, set month to null or use all months
			if ($data['jenis_laporan'] === 'tahunan') {
				$data['lap_bulan'] = null;
			} else {
				$data['lap_bulan'] = $this->input->post('lap_bulan', TRUE);
			}
		}

		// Get data based on selected month/year or just year
		$data['datafilter'] = $this->M_Usia_cerai->usia_cerai($data['lap_bulan'], $data['lap_tahun']);
		$data['stats'] = $this->M_Usia_cerai->get_statistics($data['lap_bulan'], $data['lap_tahun']);
		$data['usia_ranges'] = $this->M_Usia_cerai->get_usia_ranges($data['lap_bulan'], $data['lap_tahun']);

		// Define month names for display
		$data['nama_bulan'] = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		];

		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_usia_cerai', $data);
		$this->load->view('template/new_footer');
	}
}
