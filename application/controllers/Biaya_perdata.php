<?php defined('BASEPATH') or exit('No direct script access allowed');

class Biaya_perdata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_Biaya_perdata");
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
            $data['biaya_data'] = $this->M_Biaya_perdata->get_biaya_perdata($jenis_perkara, $lap_bulan, $lap_tahun);
            $data['komponen_biaya'] = $this->M_Biaya_perdata->get_komponen_biaya($jenis_perkara, $lap_bulan, $lap_tahun);
            $data['stats'] = $this->M_Biaya_perdata->get_statistics($jenis_perkara, $lap_bulan, $lap_tahun);
            $data['yearly_trend'] = $this->M_Biaya_perdata->get_yearly_trend($jenis_perkara, $lap_tahun);
        } else {
            // Default values if not submitted (current month/year)
            $data['jenis_perkara'] = 'Pdt.G';
            $data['lap_bulan'] = date('m');
            $data['lap_tahun'] = date('Y');
        }

        $this->load->view('template/new_header');
        $this->load->view('template/new_sidebar');
        $this->load->view('v_biaya_perdata', $data);
        $this->load->view('template/new_footer');
    }

    /**
     * Export data to Excel
     * 
     * @return void
     */
    public function export_excel()
    {
        // Get parameters
        $jenis_perkara = $this->input->get('jenis_perkara');
        $lap_bulan = $this->input->get('lap_bulan');
        $lap_tahun = $this->input->get('lap_tahun');

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

        // Get data
        $biaya_data = $this->M_Biaya_perdata->get_biaya_perdata($jenis_perkara, $lap_bulan, $lap_tahun);
        $komponen_biaya = $this->M_Biaya_perdata->get_komponen_biaya($jenis_perkara, $lap_bulan, $lap_tahun);
        $stats = $this->M_Biaya_perdata->get_statistics($jenis_perkara, $lap_bulan, $lap_tahun);

        // Set filename
        $filename = "Biaya_Perdata_{$jenis_perkara}_{$months[$lap_bulan]}_{$lap_tahun}_" . date('Ymd_His') . ".xls";

        // Set header for Excel download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");

        echo "<html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #000; padding: 5px; }
                th { background-color: #f0f0f0; }
                .header { font-weight: bold; background-color: #d9d9d9; }
                .total { font-weight: bold; }
                h3 { text-align: center; }
            </style>
        </head>
        <body>
            <h3>Analisis Biaya Perkara Perdata - {$jenis_perkara} {$months[$lap_bulan]} {$lap_tahun}</h3>
            
            <table>
                <tr class='header'>
                    <th colspan='2'>Informasi Umum</th>
                </tr>
                <tr>
                    <td>Jumlah Perkara Non-Prodeo</td>
                    <td>" . (isset($stats->total_perkara) ? $stats->total_perkara : 0) . "</td>
                </tr>
                <tr>
                    <td>Jumlah Perkara Prodeo</td>
                    <td>" . (isset($stats->total_prodeo) ? $stats->total_prodeo : 0) . "</td>
                </tr>
                <tr>
                    <td>Biaya Rata-rata per Perkara</td>
                    <td>Rp. " . number_format(isset($stats->avg_biaya) ? $stats->avg_biaya : 0, 0, ',', '.') . "</td>
                </tr>
                <tr>
                    <td>Biaya Terendah</td>
                    <td>Rp. " . number_format(isset($stats->min_biaya) ? $stats->min_biaya : 0, 0, ',', '.') . "</td>
                </tr>
                <tr>
                    <td>Biaya Tertinggi</td>
                    <td>Rp. " . number_format(isset($stats->max_biaya) ? $stats->max_biaya : 0, 0, ',', '.') . "</td>
                </tr>
                <tr class='total'>
                    <td>Potensi Penghematan dari Prodeo</td>
                    <td>Rp. " . number_format(isset($stats->potential_savings) ? $stats->potential_savings : 0, 0, ',', '.') . "</td>
                </tr>
            </table>
            
            <br/>
            
            <table>
                <tr class='header'>
                    <th colspan='5'>Rincian Komponen Biaya</th>
                </tr>
                <tr>
                    <th>Jenis Biaya</th>
                    <th>Jumlah Kasus</th>
                    <th>Rata-rata (Rp)</th>
                    <th>Minimum (Rp)</th>
                    <th>Maksimum (Rp)</th>
                </tr>";

        if (!empty($komponen_biaya)) {
            foreach ($komponen_biaya as $comp) {
                echo "<tr>
                        <td>{$comp->jenis_biaya}</td>
                        <td align='center'>{$comp->jumlah_kasus}</td>
                        <td align='right'>" . number_format($comp->rata_rata, 0, ',', '.') . "</td>
                        <td align='right'>" . number_format($comp->minimum, 0, ',', '.') . "</td>
                        <td align='right'>" . number_format($comp->maksimum, 0, ',', '.') . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5' align='center'>Tidak ada data komponen biaya</td></tr>";
        }

        echo "
            </table>
            
            <br/>
            
            <table>
                <tr class='header'>
                    <th colspan='4'>Data Biaya per Perkara</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Nomor Perkara</th>
                    <th>Tanggal Daftar</th>
                    <th>Total Biaya (Rp)</th>
                </tr>";

        if (!empty($biaya_data)) {
            $no = 1;
            foreach ($biaya_data as $row) {
                echo "<tr>
                        <td align='center'>{$no}</td>
                        <td>{$row->nomor_perkara}</td>
                        <td>" . date('d-m-Y', strtotime($row->tanggal_pendaftaran)) . "</td>
                        <td align='right'>" . number_format($row->total_biaya, 0, ',', '.') . "</td>
                    </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='4' align='center'>Tidak ada data perkara</td></tr>";
        }

        echo "
            </table>
            
            <p><i>Analisis ini menunjukkan perkiraan biaya perkara perdata jenis {$jenis_perkara}.</i></p>
            <p><i>Laporan dibuat tanggal: " . date('d-m-Y H:i:s') . "</i></p>
            
        </body>
        </html>";
        exit;
    }
}
