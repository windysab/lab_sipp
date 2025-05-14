<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Odp extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_odp");
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
		$lap_bulan = $this->input->post('lap_bulan', TRUE);
		$lap_tahun = $this->input->post('lap_tahun', TRUE);
		$jenis_filter = $this->input->post('jenis_filter', TRUE);

		// Default to current year if not provided
		if (empty($lap_tahun)) {
			$lap_tahun = date('Y');
		}

		// Default to yearly report if not specified
		if (empty($jenis_filter)) {
			$jenis_filter = 'tahunan';
		}

		// Get month value only for monthly report
		if ($jenis_filter === 'bulanan' && !empty($lap_bulan)) {
			$data['datafilter'] = $this->M_odp->odp($lap_bulan, $lap_tahun);
			$data['stats'] = $this->M_odp->get_odp_stats($lap_bulan, $lap_tahun);
			$data['perkara_distribution'] = $this->M_odp->get_perkara_distribution($lap_bulan, $lap_tahun);
		} else {
			// For yearly report, don't pass month parameter
			$data['datafilter'] = $this->M_odp->odp(null, $lap_tahun);
			$data['stats'] = $this->M_odp->get_odp_stats(null, $lap_tahun);
			$data['perkara_distribution'] = $this->M_odp->get_perkara_distribution(null, $lap_tahun);
			$data['monthly_performance'] = $this->M_odp->get_monthly_performance($lap_tahun);
			$lap_bulan = null; // Ensure it's null for yearly report
		}

		// Add filter parameters to view data
		$data['lap_bulan'] = $lap_bulan;
		$data['lap_tahun'] = $lap_tahun;
		$data['jenis_filter'] = $jenis_filter;

		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_odp', $data);
		$this->load->view('template/new_footer');
	}
}
