<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_odp extends CI_Model
{
	/**
	 * Get ODP cases based on filters with improved query performance
	 * 
	 * @param string $lap_bulan Month (optional)
	 * @param string $lap_tahun Year
	 * @return array List of ODP cases
	 */
	function odp($lap_bulan = null, $lap_tahun)
	{
		// Use query binding to prevent SQL injection
		$this->db->select('
            p.perkara_id,
            p.nomor_perkara,
            p.jenis_perkara_nama,
            pp.tanggal_putusan,
            pp.tanggal_minutasi,
            dd.created_date AS tanggal_publish,
            DATEDIFF(dd.created_date, pp.tanggal_putusan) AS selisih_hari,
            CASE 
                WHEN DATE(dd.created_date) = DATE(pp.tanggal_putusan) THEN "Ya"
                WHEN DATEDIFF(dd.created_date, pp.tanggal_putusan) <= 1 THEN "Ya (1 Hari)"
                ELSE "Tidak"
            END AS is_odp,
            dd.link_dirput,
            dd.filename
        ');

		$this->db->from('perkara p');
		$this->db->join('perkara_putusan pp', 'p.perkara_id = pp.perkara_id', 'inner');
		$this->db->join('dirput_dokumen dd', 'p.perkara_id = dd.perkara_id', 'inner');

		// Filter by year
		$this->db->where('YEAR(pp.tanggal_putusan)', $lap_tahun);

		// Filter by month if provided
		if (!empty($lap_bulan)) {
			$this->db->where('MONTH(pp.tanggal_putusan)', $lap_bulan);
		}

		// Filter only files that are anonymized decisions
		$this->db->where('dd.filename LIKE', '%anonimisasi%');

		// Order by decision date and case number
		$this->db->order_by('pp.tanggal_putusan', 'DESC');
		$this->db->order_by('p.nomor_perkara', 'ASC');

		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Get ODP statistics for display on dashboard
	 * 
	 * @param string $lap_bulan Month (optional)
	 * @param string $lap_tahun Year
	 * @return object Statistics data
	 */
	function get_odp_stats($lap_bulan = null, $lap_tahun)
	{
		// Build time filter condition
		if (!empty($lap_bulan)) {
			$time_condition = "YEAR(pp.tanggal_putusan) = ? AND MONTH(pp.tanggal_putusan) = ?";
			$params = array($lap_tahun, $lap_bulan);
		} else {
			$time_condition = "YEAR(pp.tanggal_putusan) = ?";
			$params = array($lap_tahun);
		}

		// Get ODP statistics using optimized query
		$sql = "SELECT 
                COUNT(DISTINCT p.perkara_id) AS total_putus,
                SUM(CASE WHEN dd.created_date IS NOT NULL THEN 1 ELSE 0 END) AS total_publish,
                SUM(CASE WHEN DATE(dd.created_date) = DATE(pp.tanggal_putusan) THEN 1 ELSE 0 END) AS total_odp_same_day,
                SUM(CASE WHEN DATEDIFF(dd.created_date, pp.tanggal_putusan) <= 1 THEN 1 ELSE 0 END) AS total_odp_one_day,
                ROUND(
                    SUM(CASE WHEN DATE(dd.created_date) = DATE(pp.tanggal_putusan) THEN 1 ELSE 0 END) / 
                    COUNT(DISTINCT p.perkara_id) * 100, 
                2) AS pct_odp_same_day,
                ROUND(
                    SUM(CASE WHEN DATEDIFF(dd.created_date, pp.tanggal_putusan) <= 1 THEN 1 ELSE 0 END) / 
                    COUNT(DISTINCT p.perkara_id) * 100, 
                2) AS pct_odp_one_day,
                AVG(DATEDIFF(dd.created_date, pp.tanggal_putusan)) AS avg_publish_days
            FROM 
                perkara p
                INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN dirput_dokumen dd ON p.perkara_id = dd.perkara_id AND dd.filename LIKE '%anonimisasi%'
            WHERE 
                $time_condition";

		$query = $this->db->query($sql, $params);
		return $query->row();
	}

	/**
	 * Get monthly ODP performance for charts
	 * 
	 * @param string $lap_tahun Year
	 * @return array Monthly performance data
	 */
	function get_monthly_performance($lap_tahun)
	{
		$sql = "SELECT 
                MONTH(pp.tanggal_putusan) AS month_num,
                COUNT(DISTINCT p.perkara_id) AS total_putus,
                SUM(CASE WHEN dd.created_date IS NOT NULL THEN 1 ELSE 0 END) AS total_publish,
                SUM(CASE WHEN DATE(dd.created_date) = DATE(pp.tanggal_putusan) THEN 1 ELSE 0 END) AS total_odp_same_day,
                SUM(CASE WHEN DATEDIFF(dd.created_date, pp.tanggal_putusan) <= 1 THEN 1 ELSE 0 END) AS total_odp_one_day
            FROM 
                perkara p
                INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN dirput_dokumen dd ON p.perkara_id = dd.perkara_id AND dd.filename LIKE '%anonimisasi%'
            WHERE 
                YEAR(pp.tanggal_putusan) = ?
            GROUP BY 
                MONTH(pp.tanggal_putusan)
            ORDER BY 
                MONTH(pp.tanggal_putusan)";

		$query = $this->db->query($sql, array($lap_tahun));
		return $query->result();
	}

	/**
	 * Get ODP cases by jenis_perkara for charts
	 * 
	 * @param string $lap_bulan Month (optional)
	 * @param string $lap_tahun Year
	 * @return array Cases grouped by case type
	 */
	function get_perkara_distribution($lap_bulan = null, $lap_tahun)
	{
		// Build time filter condition
		if (!empty($lap_bulan)) {
			$time_condition = "YEAR(pp.tanggal_putusan) = ? AND MONTH(pp.tanggal_putusan) = ?";
			$params = array($lap_tahun, $lap_bulan);
		} else {
			$time_condition = "YEAR(pp.tanggal_putusan) = ?";
			$params = array($lap_tahun);
		}

		$sql = "SELECT 
                p.jenis_perkara_nama,
                COUNT(DISTINCT p.perkara_id) AS total_cases,
                SUM(CASE WHEN DATE(dd.created_date) = DATE(pp.tanggal_putusan) THEN 1 ELSE 0 END) AS total_odp_same_day,
                ROUND(
                    SUM(CASE WHEN DATE(dd.created_date) = DATE(pp.tanggal_putusan) THEN 1 ELSE 0 END) / 
                    COUNT(DISTINCT p.perkara_id) * 100, 
                2) AS pct_odp
            FROM 
                perkara p
                INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
                LEFT JOIN dirput_dokumen dd ON p.perkara_id = dd.perkara_id AND dd.filename LIKE '%anonimisasi%'
            WHERE 
                $time_condition
            GROUP BY 
                p.jenis_perkara_nama
            ORDER BY
                total_cases DESC";

		$query = $this->db->query($sql, $params);
		return $query->result();
	}
}
