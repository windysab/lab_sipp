<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Prodeo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_Prodeo");
	}

	public function index()
	{
		$data = [];

		// Define month names for display
		$data['months'] = [
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

		// Check if form was submitted
		if ($this->input->post('btn')) {
			$jenis_perkara = $this->input->post('jenis_perkara', TRUE);
			$lap_bulan = $this->input->post('lap_bulan', TRUE);
			$lap_tahun = $this->input->post('lap_tahun', TRUE);

			// Store parameters in data array
			$data['jenis_perkara'] = $jenis_perkara;
			$data['lap_bulan'] = $lap_bulan;
			$data['lap_tahun'] = $lap_tahun;

			// Get data from model
			$data['datafilter'] = $this->M_Prodeo->prodeo($jenis_perkara, $lap_bulan, $lap_tahun);
			$data['stats'] = $this->M_Prodeo->get_statistics($jenis_perkara, $lap_bulan, $lap_tahun);
		} else {
			// Default values if not submitted (current month/year)
			$data['jenis_perkara'] = 'Pdt.G';
			$data['lap_bulan'] = date('m');
			$data['lap_tahun'] = date('Y');
			$data['datafilter'] = [];
		}

		$this->load->view('template/new_header');
		$this->load->view('template/new_sidebar');
		$this->load->view('v_prodeo', $data);
		$this->load->view('template/new_footer');
	}

	/**
	 * Export Prodeo case data to Excel
	 * 
	 * @return void
	 */
	public function export_excel()
	{
		// Get parameters from POST or GET
		$jenis_perkara = $this->input->post('jenis_perkara');
		if (empty($jenis_perkara)) {
			$jenis_perkara = $this->input->get('jenis_perkara');
		}

		$lap_bulan = $this->input->post('lap_bulan');
		if (empty($lap_bulan)) {
			$lap_bulan = $this->input->get('lap_bulan');
		}

		$lap_tahun = $this->input->post('lap_tahun');
		if (empty($lap_tahun)) {
			$lap_tahun = $this->input->get('lap_tahun');
		}

		// Default to current month/year if not specified
		if (empty($lap_bulan)) $lap_bulan = date('m');
		if (empty($lap_tahun)) $lap_tahun = date('Y');
		if (empty($jenis_perkara)) $jenis_perkara = 'Pdt.G';

		// Define month names for display
		$months = [
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

		// Get data from model
		$data = $this->M_Prodeo->export_data($jenis_perkara, $lap_bulan, $lap_tahun);
		$stats = $this->M_Prodeo->get_statistics($jenis_perkara, $lap_bulan, $lap_tahun);

		// Set filename
		$filename = "Data_Perkara_Prodeo_{$jenis_perkara}_{$months[$lap_bulan]}_{$lap_tahun}_" . date('Ymd_His') . ".xls";

		// Set header for Excel download
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Cache-Control: max-age=0");

		// Create Excel content (HTML table with Excel compatibility)
		echo "
        <html xmlns:o='urn:schemas-microsoft-com:office:office' 
              xmlns:x='urn:schemas-microsoft-com:office:excel' 
              xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th, td {
                    border: 1px solid #000000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #4CAF50;
                    color: white;
                    font-weight: bold;
                }
                .center {
                    text-align: center;
                }
                h3, h4 {
                    text-align: center;
                }
                .header-section {
                    background-color: #E0E0E0;
                    font-weight: bold;
                    padding: 5px;
                }
                .stats-table {
                    width: 50%;
                    margin: 20px 0;
                }
            </style>
        </head>
        <body>
            <h3>Data Perkara Prodeo (Cuma-Cuma) {$jenis_perkara}</h3>
            <h4>Periode: {$months[$lap_bulan]} {$lap_tahun}</h4>
            <p>Tanggal Export: " . date('d-m-Y H:i:s') . "</p>
            
            <div class='header-section'>Statistik Perkara Prodeo</div>
            <table class='stats-table'>
                <tr>
                    <td>Total Perkara Prodeo</td>
                    <td>" . count($data) . "</td>
                </tr>
                <tr>
                    <td>Perkara Selesai</td>
                    <td>" . (isset($stats->completed_cases) ? $stats->completed_cases : '0') . "</td>
                </tr>
                <tr>
                    <td>Perkara Dalam Proses</td>
                    <td>" . (isset($stats->ongoing_cases) ? $stats->ongoing_cases : '0') . "</td>
                </tr>
                <tr>
                    <td>Rata-rata Durasi Perkara (hari)</td>
                    <td>" . (isset($stats->avg_duration) ? round($stats->avg_duration) : '0') . "</td>
                </tr>
                <tr>
                    <td>Persentase dari Total Perkara</td>
                    <td>" . (isset($stats->percent_of_total) ? round($stats->percent_of_total, 1) . '%' : '0%') . "</td>
                </tr>
            </table>
            
            <div class='header-section'>Data Perkara Prodeo</div>
            <table>
                <thead>
                    <tr>
                        <th class='center'>No</th>
                        <th>Nomor Perkara</th>
                        <th>Jenis Perkara</th>
                        <th>Penggugat/Pemohon</th>
                        <th>Tergugat/Termohon</th>
                        <th>Tanggal Daftar</th>
                        <th>Tanggal PMH</th>
                        <th>Tanggal PHS</th>
                        <th>Sidang Pertama</th>
                        <th>Tanggal Putusan</th>
                        <th>Durasi (hari)</th>
                        <th>Status Putusan</th>
                        <th>Status Prodeo</th>
                        <th>Majelis Hakim</th>
                        <th>Panitera Pengganti</th>
                    </tr>
                </thead>
                <tbody>";

		// Add data rows
		$no = 1;
		foreach ($data as $row) {
			echo "<tr>
                    <td class='center'>{$no}</td>
                    <td>{$row->nomor_perkara}</td>
                    <td>{$row->jenis_perkara_nama}</td>
                    <td>{$row->nama_penggugat}</td>
                    <td>{$row->nama_tergugat}</td>
                    <td>" . date('d-m-Y', strtotime($row->tanggal_pendaftaran)) . "</td>
                    <td>" . (!empty($row->penetapan_majelis_hakim) ? date('d-m-Y', strtotime($row->penetapan_majelis_hakim)) : '-') . "</td>
                    <td>" . (!empty($row->penetapan_hari_sidang) ? date('d-m-Y', strtotime($row->penetapan_hari_sidang)) : '-') . "</td>
                    <td>" . (!empty($row->sidang_pertama) ? date('d-m-Y', strtotime($row->sidang_pertama)) : '-') . "</td>
                    <td>" . (!empty($row->tanggal_putusan) ? date('d-m-Y', strtotime($row->tanggal_putusan)) : 'Dalam Proses') . "</td>
                    <td class='center'>{$row->durasi_perkara}</td>
                    <td>" . (!empty($row->status_putusan_nama) ? $row->status_putusan_nama : 'Dalam Proses') . "</td>
                    <td>{$row->status_prodeo}</td>
                    <td>{$row->majelis_hakim_nama}</td>
                    <td>{$row->panitera_pengganti_text}</td>
                </tr>";
			$no++;
		}

		echo "
                </tbody>
            </table>
            
            <p><strong>Keterangan:</strong></p>
            <ul>
                <li>Perkara Prodeo adalah perkara yang dibebaskan dari biaya perkara</li>
                <li>Berdasarkan pasal 237 HIR/273 RBg dan SEMA Nomor 10 Tahun 2010</li>
                <li>Durasi perkara dihitung dari tanggal pendaftaran sampai dengan tanggal putusan atau tanggal hari ini untuk perkara yang masih berjalan</li>
            </ul>
        </body>
        </html>";
		exit;
	}
}
