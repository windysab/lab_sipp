<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Prodeo extends CI_Model
{
	/**
	 * Get Prodeo cases with optimized query
	 * 
	 * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
	 * @param string $lap_bulan Month (01-12)
	 * @param string $lap_tahun Year
	 * @return array Array of Prodeo cases
	 */
	function prodeo($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT nomor_perkara, majelis_hakim_nama, panitera_pengganti_text, tanggal_pendaftaran, 
			penetapan_majelis_hakim, penetapan_hari_sidang, sidang_pertama, tanggal_putusan, status_putusan_nama, prodeo,
			jenis_perkara_nama,
			DATEDIFF(IFNULL(tanggal_putusan, CURDATE()), tanggal_pendaftaran) as durasi_perkara
			FROM perkara
			LEFT JOIN perkara_penetapan ON perkara.`perkara_id`=perkara_penetapan.`perkara_id`
			LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
			WHERE ((YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan') 
			OR (YEAR(penetapan_majelis_hakim)='$lap_tahun' AND MONTH(penetapan_majelis_hakim)='$lap_bulan')
			OR (YEAR(penetapan_hari_sidang)='$lap_tahun' AND MONTH(penetapan_hari_sidang)='$lap_bulan')
			OR (YEAR(sidang_pertama)='$lap_tahun' AND MONTH(sidang_pertama)='$lap_bulan')
			OR (YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan') or tanggal_putusan is null
			) 
			and perkara.nomor_perkara like '%$jenis_perkara%'
			AND prodeo = '1'
			ORDER BY perkara.`perkara_id`
			");
		return $query->result();
	}

	/**
	 * Get statistics for Prodeo cases
	 * 
	 * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
	 * @param string $lap_bulan Month (01-12)
	 * @param string $lap_tahun Year
	 * @return object Statistics for Prodeo cases
	 */
	function get_statistics($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		// Sanitize input parameters
		$jenis_perkara = $this->db->escape_str($jenis_perkara);
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		// Build date condition
		$date_condition = "(
			(YEAR(p.tanggal_pendaftaran) = ? AND MONTH(p.tanggal_pendaftaran) = ?) OR
			(YEAR(pp.penetapan_majelis_hakim) = ? AND MONTH(pp.penetapan_majelis_hakim) = ?) OR
			(YEAR(pp.penetapan_hari_sidang) = ? AND MONTH(pp.penetapan_hari_sidang) = ?) OR
			(YEAR(pp.sidang_pertama) = ? AND MONTH(pp.sidang_pertama) = ?) OR
			(YEAR(put.tanggal_putusan) = ? AND MONTH(put.tanggal_putusan) = ?) OR
			put.tanggal_putusan IS NULL
		)";

		// Get total cases for the period (for percentage calculation)
		$total_query = "SELECT 
				COUNT(*) as total_cases
			FROM 
				perkara p
				LEFT JOIN perkara_penetapan pp ON p.perkara_id = pp.perkara_id
				LEFT JOIN perkara_putusan put ON p.perkara_id = put.perkara_id
			WHERE 
				$date_condition
				AND p.nomor_perkara LIKE ?";

		$total_params = array(
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			'%' . $jenis_perkara . '%'
		);

		$total_result = $this->db->query($total_query, $total_params)->row();
		$total_cases = $total_result->total_cases;

		// Query for statistics
		$sql = "SELECT 
				COUNT(*) as total_prodeo,
				SUM(CASE WHEN put.tanggal_putusan IS NOT NULL THEN 1 ELSE 0 END) as completed_cases,
				SUM(CASE WHEN put.tanggal_putusan IS NULL THEN 1 ELSE 0 END) as ongoing_cases,
				AVG(DATEDIFF(IFNULL(put.tanggal_putusan, CURDATE()), p.tanggal_pendaftaran)) as avg_duration,
				MAX(DATEDIFF(IFNULL(put.tanggal_putusan, CURDATE()), p.tanggal_pendaftaran)) as max_duration,
				MIN(CASE WHEN put.tanggal_putusan IS NOT NULL THEN DATEDIFF(put.tanggal_putusan, p.tanggal_pendaftaran) ELSE NULL END) as min_duration,
				COUNT(DISTINCT pp.majelis_hakim_kode) as total_judges,
				COUNT(DISTINCT pp.panitera_pengganti_id) as total_clerks,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Gugat%' THEN 1 ELSE 0 END) as cerai_gugat_count,
				SUM(CASE WHEN p.jenis_perkara_nama LIKE '%Cerai Talak%' THEN 1 ELSE 0 END) as cerai_talak_count,
				SUM(CASE WHEN p.jenis_perkara_nama NOT LIKE '%Cerai%' THEN 1 ELSE 0 END) as other_case_count
			FROM 
				perkara p
				LEFT JOIN perkara_penetapan pp ON p.perkara_id = pp.perkara_id
				LEFT JOIN perkara_putusan put ON p.perkara_id = put.perkara_id
			WHERE 
				$date_condition
				AND p.nomor_perkara LIKE ?
				AND p.prodeo = 1";

		$params = array(
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			$lap_tahun,
			$lap_bulan,
			'%' . $jenis_perkara . '%'
		);

		$query = $this->db->query($sql, $params);
		$result = $query->row();

		// Calculate percentage of prodeo cases from total cases
		if ($total_cases > 0) {
			$result->percent_of_total = ($result->total_prodeo / $total_cases) * 100;
		} else {
			$result->percent_of_total = 0;
		}

		return $result;
	}

	/**
	 * Export Prodeo cases to Excel
	 * 
	 * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
	 * @param string $lap_bulan Month (01-12)
	 * @param string $lap_tahun Year
	 * @return array Array of Prodeo cases
	 */
	function export_data($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		// Get the same data as the prodeo function but with additional fields for export
		return $this->prodeo($jenis_perkara, $lap_bulan, $lap_tahun);
	}

	/**
	 * Get case fee information (biaya perkara)
	 * Shows what the fees would have been if the case wasn't prodeo
	 * 
	 * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
	 * @param string $lap_bulan Month (01-12)
	 * @param string $lap_tahun Year
	 * @return array Case fee data
	 */
	function get_biaya_perkara($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		// Get standard fee statistics for the specified period - fixed query to avoid nested aggregates
		$sql_standard = "SELECT 
				AVG(total_biaya) as avg_biaya,
				MIN(total_biaya) as min_biaya,
				MAX(total_biaya) as max_biaya,
				COUNT(DISTINCT perkara_id) as total_cases
			FROM (
				SELECT 
					p.perkara_id,
					SUM(pb.jumlah) as total_biaya
				FROM 
					perkara p
					INNER JOIN perkara_biaya pb ON p.perkara_id = pb.perkara_id
				WHERE 
					p.prodeo = 0
					AND p.nomor_perkara LIKE '%$jenis_perkara%'
					AND ((YEAR(p.tanggal_pendaftaran)='$lap_tahun' 
						AND MONTH(p.tanggal_pendaftaran)='$lap_bulan'))
				GROUP BY 
					p.perkara_id
			) as fee_totals";

		$query_standard = $this->db->query($sql_standard);

		// Get fee breakdown by components - fixed to use jenis_biaya_id instead of komponenID
		$sql_components = "SELECT 
				pb.jenis_biaya_id,
				jb.nama as jenis_biaya,  
				AVG(pb.jumlah) as avg_jumlah,
				COUNT(pb.id) as count
			FROM 
				perkara p
				INNER JOIN perkara_biaya pb ON p.perkara_id = pb.perkara_id
				LEFT JOIN jenis_biaya jb ON pb.jenis_biaya_id = jb.id
			WHERE 
				p.prodeo = 0
				AND p.nomor_perkara LIKE '%$jenis_perkara%'
				AND ((YEAR(p.tanggal_pendaftaran)='$lap_tahun' 
					AND MONTH(p.tanggal_pendaftaran)='$lap_bulan'))
			GROUP BY 
				pb.jenis_biaya_id, jb.nama
			ORDER BY 
				avg_jumlah DESC";

		$query_components = $this->db->query($sql_components);

		// Calculate projected savings
		$sql_prodeo_count = "SELECT 
				COUNT(*) as prodeo_count 
			FROM 
				perkara p
			WHERE 
				p.prodeo = 1
				AND p.nomor_perkara LIKE '%$jenis_perkara%'
				AND ((YEAR(p.tanggal_pendaftaran)='$lap_tahun' 
					AND MONTH(p.tanggal_pendaftaran)='$lap_bulan'))";

		$query_prodeo_count = $this->db->query($sql_prodeo_count);

		// Get year-to-date stats
		$sql_ytd = "SELECT 
				COUNT(*) as ytd_prodeo_count,
				YEAR(p.tanggal_pendaftaran) as tahun,
				MONTH(p.tanggal_pendaftaran) as bulan
			FROM 
				perkara p
			WHERE 
				p.prodeo = 1
				AND p.nomor_perkara LIKE '%$jenis_perkara%'
				AND YEAR(p.tanggal_pendaftaran)='$lap_tahun'
			GROUP BY
				YEAR(p.tanggal_pendaftaran),
				MONTH(p.tanggal_pendaftaran)
			ORDER BY
				MONTH(p.tanggal_pendaftaran)";

		$query_ytd = $this->db->query($sql_ytd);

		$result = new stdClass();
		$result->standard_fees = $query_standard->row();
		$result->components = $query_components->result();
		$result->prodeo_count = $query_prodeo_count->row() ? $query_prodeo_count->row()->prodeo_count : 0;
		$result->ytd_stats = $query_ytd->result();

		// Calculate projected savings
		if ($result->standard_fees && $result->prodeo_count > 0) {
			$result->projected_savings = $result->standard_fees->avg_biaya * $result->prodeo_count;
			$result->min_projected_savings = $result->standard_fees->min_biaya * $result->prodeo_count;
			$result->max_projected_savings = $result->standard_fees->max_biaya * $result->prodeo_count;
		} else {
			// If no data, use default estimates
			$default_fee = 850000; // Default average fee estimate
			$result->projected_savings = $default_fee * $result->prodeo_count;
			$result->min_projected_savings = ($default_fee - 250000) * $result->prodeo_count;
			$result->max_projected_savings = ($default_fee + 550000) * $result->prodeo_count;
		}

		return $result;
	}
}
