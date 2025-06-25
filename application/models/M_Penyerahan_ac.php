<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Penyerahan_ac extends CI_Model
{
	/**
	 * Ambil data penyerahan akta cerai berdasarkan bulan dan tahun atau tahun saja
	 */
	function penyerahan_ac($lap_bulan, $lap_tahun)
	{
		$lap_tahun = $this->db->escape_str($lap_tahun);

		if (!empty($lap_bulan)) {
			$lap_bulan = $this->db->escape_str($lap_bulan);
			$date_filter = "(YEAR(pac.tgl_penyerahan_akta_cerai) = '$lap_tahun' AND MONTH(pac.tgl_penyerahan_akta_cerai) = '$lap_bulan')
				OR (YEAR(pac.tgl_penyerahan_akta_cerai_pihak2) = '$lap_tahun' AND MONTH(pac.tgl_penyerahan_akta_cerai_pihak2) = '$lap_bulan')";
		} else {
			$date_filter = "(YEAR(pac.tgl_penyerahan_akta_cerai) = '$lap_tahun' OR YEAR(pac.tgl_penyerahan_akta_cerai_pihak2) = '$lap_tahun')";
		}

		$sql = "SELECT 
			p.nomor_perkara,
			p.jenis_perkara_nama,
			pac.nomor_akta_cerai,
			pp.tanggal_putusan,
			pit.tgl_ikrar_talak,
			pp.tanggal_bht,
			pac.tgl_penyerahan_akta_cerai as tgl_AC_P,
			pac.tgl_penyerahan_akta_cerai_pihak2 as tgl_AC_T,
			pp1.nama as nama_p,
			pp2.nama as nama_t
		FROM perkara p
		LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
		LEFT JOIN perkara_ikrar_talak pit ON p.perkara_id = pit.perkara_id
		LEFT JOIN perkara_akta_cerai pac ON p.perkara_id = pac.perkara_id
		LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
		LEFT JOIN perkara_pihak2 pp2 ON p.perkara_id = pp2.perkara_id
		WHERE $date_filter
		ORDER BY p.perkara_id DESC";

		$query = $this->db->query($sql);
		return $query->result();
	}

	/**
	 * Statistik penyerahan akta cerai
	 */
	function getStatistics($lap_bulan, $lap_tahun)
	{
		$lap_tahun = $this->db->escape_str($lap_tahun);

		if (!empty($lap_bulan)) {
			$lap_bulan = $this->db->escape_str($lap_bulan);
			$date_filter = "(YEAR(tgl_penyerahan_akta_cerai) = '$lap_tahun' AND MONTH(tgl_penyerahan_akta_cerai) = '$lap_bulan')
				OR (YEAR(tgl_penyerahan_akta_cerai_pihak2) = '$lap_tahun' AND MONTH(tgl_penyerahan_akta_cerai_pihak2) = '$lap_bulan')";
		} else {
			$date_filter = "(YEAR(tgl_penyerahan_akta_cerai) = '$lap_tahun' OR YEAR(tgl_penyerahan_akta_cerai_pihak2) = '$lap_tahun')";
		}

		$sql = "SELECT
			COUNT(*) as total,
			SUM(CASE WHEN (jenis_perkara_nama = 'Cerai Talak' AND tgl_penyerahan_akta_cerai IS NOT NULL) OR (jenis_perkara_nama = 'Cerai Gugat' AND tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL) THEN 1 ELSE 0 END) as total_suami,
			SUM(CASE WHEN (jenis_perkara_nama = 'Cerai Talak' AND tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL) OR (jenis_perkara_nama = 'Cerai Gugat' AND tgl_penyerahan_akta_cerai IS NOT NULL) THEN 1 ELSE 0 END) as total_istri
			FROM perkara
			LEFT JOIN perkara_akta_cerai ON perkara.perkara_id = perkara_akta_cerai.perkara_id
			WHERE $date_filter";
		$query = $this->db->query($sql);
		return $query->row();
	}

	/**
	 * Export data to Excel format
	 * 
	 * @param string $lap_bulan Month (01-12)
	 * @param string $lap_tahun Year
	 * @return void Outputs Excel file for download
	 */
	public function export_excel($lap_bulan, $lap_tahun)
	{
		// Sanitize input
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		// Get data
		$data = $this->penyerahan_ac($lap_bulan, $lap_tahun);

		// Define month names for display
		$nama_bulan = array(
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
		);

		// Set filename
		$month_label = isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] : 'Semua_Bulan';
		$filename = "Data_Penyerahan_Akta_Cerai_{$month_label}_{$lap_tahun}_" . date('Ymd_His') . ".xls";

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
				.txt-center {
					text-align: center;
				}
				h3 {
					text-align: center;
				}
				.yes {
					background-color: #DFF0D8;
					color: #3c763d;
				}
				.no {
					background-color: #F2DEDE;
					color: #a94442;
				}
			</style>
		</head>
		<body>
			<h3>DATA PENYERAHAN AKTA CERAI " . (isset($nama_bulan[$lap_bulan]) ? $nama_bulan[$lap_bulan] . ' ' : '') . "$lap_tahun</h3>
			<p>Tanggal Export: " . date('d-m-Y H:i:s') . "</p>
			
			<table border='1'>
				<thead>
					<tr>
						<th class='txt-center'>No</th>
						<th>Nomor Perkara</th>
						<th>Jenis Perkara</th>
						<th>Nomor Akta Cerai</th>
						<th>Tanggal Putus</th>
						<th>Tanggal BHT</th>
						<th>Mantan Suami</th>
						<th>Tgl Serah ke Suami</th>
						<th>Mantan Istri</th>
						<th>Tgl Serah ke Istri</th>
					</tr>
				</thead>
				<tbody>";

		$no = 1;
		foreach ($data as $row) {
			// Determine suami and istri based on jenis perkara
			if ($row->jenis_perkara_nama == 'Cerai Talak') {
				$suami = $row->nama_p;
				$istri = $row->nama_t;
				$tgl_serah_suami = !empty($row->tgl_AC_P) ? date('d-m-Y', strtotime($row->tgl_AC_P)) : 'Belum';
				$tgl_serah_istri = !empty($row->tgl_AC_T) ? date('d-m-Y', strtotime($row->tgl_AC_T)) : 'Belum';
				$suami_class = !empty($row->tgl_AC_P) ? 'yes' : 'no';
				$istri_class = !empty($row->tgl_AC_T) ? 'yes' : 'no';
			} else {
				$suami = $row->nama_t;
				$istri = $row->nama_p;
				$tgl_serah_suami = !empty($row->tgl_AC_T) ? date('d-m-Y', strtotime($row->tgl_AC_T)) : 'Belum';
				$tgl_serah_istri = !empty($row->tgl_AC_P) ? date('d-m-Y', strtotime($row->tgl_AC_P)) : 'Belum';
				$suami_class = !empty($row->tgl_AC_T) ? 'yes' : 'no';
				$istri_class = !empty($row->tgl_AC_P) ? 'yes' : 'no';
			}

			echo "<tr>
					<td class='txt-center'>$no</td>
					<td>$row->nomor_perkara</td>
					<td>$row->jenis_perkara_nama</td>
					<td>$row->nomor_akta_cerai</td>
					<td>" . (!empty($row->tanggal_putusan) ? date('d-m-Y', strtotime($row->tanggal_putusan)) : '-') . "</td>
					<td>" . (!empty($row->tanggal_bht) ? date('d-m-Y', strtotime($row->tanggal_bht)) : '-') . "</td>
					<td>$suami</td>
					<td class='$suami_class'>$tgl_serah_suami</td>
					<td>$istri</td>
					<td class='$istri_class'>$tgl_serah_istri</td>
				</tr>";
			$no++;
		}

		echo "
				</tbody>
			</table>
			
			<p>Total data: " . count($data) . "</p>
		</body>
		</html>";
		exit;
	}
}
