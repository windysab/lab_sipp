<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ecourt extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_ecourt");
	}

	public function index()
	{
		$data = [];

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

		// Get filters from form submission
		$jenis_perkara = $this->input->post('jenis_perkara', TRUE);
		$lap_bulan = $this->input->post('lap_bulan', TRUE);
		$lap_tahun = $this->input->post('lap_tahun', TRUE);

		// If form submitted, load data
		if ($this->input->post('btn')) {
			// Default to current month/year if not provided
			if (empty($lap_bulan)) $lap_bulan = date('m');
			if (empty($lap_tahun)) $lap_tahun = date('Y');
			if (empty($jenis_perkara)) $jenis_perkara = 'all';

			// Get data
			$data['datafilter'] = $this->M_ecourt->ecourt($jenis_perkara, $lap_bulan, $lap_tahun);

			// Get statistics
			$data['stats'] = $this->M_ecourt->get_stats($jenis_perkara, $lap_bulan, $lap_tahun);
		}

		// Load views
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_ecourt', $data);
		$this->load->view('template/new_footer');
	}

	public function detail($perkara_id = NULL)
	{
		if (!$perkara_id) {
			show_404();
			return;
		}

		$data['case'] = $this->M_ecourt->get_case_detail($perkara_id);

		if (!$data['case']) {
			show_404();
			return;
		}

		// Load views
		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_ecourt_detail', $data);
		$this->load->view('template/new_footer');
	}

	/**
	 * Export data to Excel
	 * @param string $jenis_perkara
	 * @param string $bulan
	 * @param string $tahun
	 */
	public function export_excel($jenis_perkara = 'all', $bulan = null, $tahun = null)
	{
		// If parameters not provided via URL, try to get from POST
		if (empty($bulan)) {
			$bulan = $this->input->post('lap_bulan');
			if (empty($bulan)) {
				$bulan = date('m');
			}
		}

		if (empty($tahun)) {
			$tahun = $this->input->post('lap_tahun');
			if (empty($tahun)) {
				$tahun = date('Y');
			}
		}

		if ($jenis_perkara == null) {
			$jenis_perkara = $this->input->post('jenis_perkara');
			if (empty($jenis_perkara)) {
				$jenis_perkara = 'all';
			}
		}

		// Call model's export method
		$this->M_ecourt->export_excel($jenis_perkara, $bulan, $tahun);
	}
}
