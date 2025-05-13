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
		$debug_info = [];
		$debug_info['raw_post'] = $_POST;

		// Perbaikan kondisi cek form submit - periksa adanya data jenis_laporan
		// atau adanya data lap_tahun sebagai indikator form sudah disubmit
		if ($this->input->post('jenis_laporan') || $this->input->post('lap_tahun')) {
			$data['jenis_laporan'] = $this->input->post('jenis_laporan', TRUE);
			$data['lap_tahun'] = $this->input->post('lap_tahun', TRUE);
			$debug_info['source'] = 'form_submit';

			// If annual report is selected, set month to null or use all months
			if ($data['jenis_laporan'] === 'tahunan') {
				$data['lap_bulan'] = null;
				$debug_info['jenis'] = 'tahunan';
				// Meskipun tahunan, simpan lap_bulan_raw untuk debug
				$debug_info['lap_bulan_raw'] = $this->input->post('lap_bulan', TRUE);
			} else {
				$data['lap_bulan'] = $this->input->post('lap_bulan', TRUE);
				$debug_info['jenis'] = 'bulanan';
				$debug_info['lap_bulan_raw'] = $this->input->post('lap_bulan', TRUE);
			}

			// Ambil data hanya jika form sudah disubmit dan ada tahun yang dipilih
			if (!empty($data['lap_tahun'])) {
				// Tambahkan log untuk melihat parameter yang digunakan
				log_message('debug', 'QUERYING WITH: Bulan=' .
					(isset($data['lap_bulan']) ? $data['lap_bulan'] : 'NULL') .
					', Tahun=' . $data['lap_tahun']);

				$data['datafilter'] = $this->M_Usia_cerai->usia_cerai($data['lap_bulan'], $data['lap_tahun']);
				$data['stats'] = $this->M_Usia_cerai->get_statistics($data['lap_bulan'], $data['lap_tahun']);
				$data['usia_ranges'] = $this->M_Usia_cerai->get_usia_ranges($data['lap_bulan'], $data['lap_tahun']);
			} else {
				$data['datafilter'] = [];
				log_message('debug', 'NO YEAR SELECTED, NOT QUERYING');
			}
		} else {
			// Set data kosong jika belum submit
			$debug_info['source'] = 'new_form';
			$data['jenis_laporan'] = 'bulanan'; // Tetap set default jenis laporan
			$data['datafilter'] = [];
		}

		// Tambahkan debug untuk melihat nilai akhir
		$debug_info['final_lap_bulan'] = isset($data['lap_bulan']) ? $data['lap_bulan'] : 'tidak diset';
		$debug_info['final_lap_tahun'] = isset($data['lap_tahun']) ? $data['lap_tahun'] : 'tidak diset';
		$data['debug_info'] = $debug_info;

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
