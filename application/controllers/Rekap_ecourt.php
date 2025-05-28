<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_ecourt extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_rekap_ecourt");
    }

    public function index()
    {
        $data = [];

        // Get filters from form submission
        $tahun = $this->input->post('tahun', TRUE);
        $jenis_perkara = $this->input->post('jenis_perkara', TRUE);

        // Default to current year if not provided
        if (empty($tahun)) {
            $tahun = date('Y');
        }

        // Get summary statistics
        $data['summary'] = $this->M_rekap_ecourt->get_summary($tahun, $jenis_perkara);

        // Get monthly statistics
        $data['monthly_stats'] = $this->M_rekap_ecourt->get_monthly_stats($tahun, $jenis_perkara);

        // Get case type distribution
        $data['case_types'] = $this->M_rekap_ecourt->get_case_type_distribution($tahun);

        // Get status distribution
        $data['status_distribution'] = $this->M_rekap_ecourt->get_status_distribution($tahun, $jenis_perkara);

        // Get detailed list of cases
        $data['ecourt_cases'] = $this->M_rekap_ecourt->get_ecourt_cases($tahun, $jenis_perkara);

        // Get list of case types for filter dropdown
        $data['jenis_perkara_list'] = $this->M_rekap_ecourt->get_jenis_perkara_list();

        // Set filter values for the view
        $data['selected_year'] = $tahun;
        $data['selected_jenis_perkara'] = $jenis_perkara;

        // Load views
        $this->load->view('template/new_header');
        $this->load->view('template/new_sidebar');
        $this->load->view('v_rekap_ecourt', $data);
        $this->load->view('template/new_footer');
    }

    /**
     * Export data to Excel
     */
    public function export_excel()
    {
        // Get filter parameters
        $tahun = $this->input->get('tahun', TRUE);
        $jenis_perkara = $this->input->get('jenis_perkara', TRUE);

        // Default to current year if not provided
        if (empty($tahun)) {
            $tahun = date('Y');
        }

        // Get data from model
        $ecourt_cases = $this->M_rekap_ecourt->get_ecourt_cases($tahun, $jenis_perkara);
        $summary = $this->M_rekap_ecourt->get_summary($tahun, $jenis_perkara);

        // Load Excel helper
        $this->load->helper('download');

        // Prepare filename
        $filename = "Rekap_Perkara_Ecourt_" . $tahun;
        if (!empty($jenis_perkara)) {
            $filename .= "_" . str_replace(" ", "_", $jenis_perkara);
        }
        $filename .= ".xls";

        // Set headers for Excel download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");

        // Create Excel content
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
                .text-center {
                    text-align: center;
                }
                h3 {
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <h3>Rekap Perkara E-Court Tahun $tahun</h3>";

        if (!empty($jenis_perkara)) {
            echo "<h4>Jenis Perkara: $jenis_perkara</h4>";
        }

        echo "<p>Tanggal Export: " . date('d-m-Y H:i:s') . "</p>
            
            <h4>Ringkasan Statistik</h4>
            <table>
                <tr>
                    <th>Total Perkara E-Court</th>
                    <td>" . $summary->total_perkara . "</td>
                </tr>
                <tr>
                    <th>Persentase dari Total Perkara</th>
                    <td>" . $summary->percentage_ecourt . "%</td>
                </tr>
                <tr>
                    <th>Sudah Diputus</th>
                    <td>" . $summary->total_decided . " (" . $summary->percentage_decided . "%)</td>
                </tr>
                <tr>
                    <th>Dalam Proses</th>
                    <td>" . $summary->total_ongoing . " (" . $summary->percentage_ongoing . "%)</td>
                </tr>
            </table>
            
            <h4>Daftar Perkara E-Court</h4>
            <table>
                <thead>
                    <tr>
                        <th class='text-center'>No</th>
                        <th>Nomor Perkara</th>
                        <th>Jenis Perkara</th>
                        <th>Tanggal Daftar</th>
                        <th>Tanggal Putus</th>
                        <th>Status</th>
                        <th>Advokat</th>
                    </tr>
                </thead>
                <tbody>";

        $no = 1;
        foreach ($ecourt_cases as $case) {
            echo "<tr>
                    <td class='text-center'>" . $no++ . "</td>
                    <td>" . $case->nomor_perkara . "</td>
                    <td>" . $case->jenis_perkara_nama . "</td>
                    <td>" . date('d-m-Y', strtotime($case->tanggal_pendaftaran)) . "</td>
                    <td>" . (!empty($case->tanggal_putusan) ? date('d-m-Y', strtotime($case->tanggal_putusan)) : '-') . "</td>
                    <td>" . $case->status_perkara . "</td>
                    <td>" . $case->nama_advokat . "</td>
                </tr>";
        }

        echo "
                </tbody>
            </table>
        </body>
        </html>";
        exit;
    }
}
