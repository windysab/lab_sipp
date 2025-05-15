<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_odm extends CI_Model
{
	/**
	 * Mendapatkan data One Day Minute dengan optimasi
	 * 
	 * @param string $lap_bulan Bulan (01-12)
	 * @param string $lap_tahun Tahun
	 * @return array Data OD Minute
	 */
	function get_odm_data($lap_bulan, $lap_tahun)
	{
		// Sanitasi input untuk keamanan
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		// Gunakan prepared statement dan pilih kolom yang dibutuhkan saja
		$sql = "SELECT 
                p.perkara_id,
                p.nomor_perkara,
                p.jenis_perkara_nama,
                pp.tanggal_putusan,
                pp.tanggal_minutasi,
                DATEDIFF(pp.tanggal_minutasi, pp.tanggal_putusan) AS selisih_hari,
                CASE 
                    WHEN DATE(pp.tanggal_minutasi) = DATE(pp.tanggal_putusan) THEN 'Ya' 
                    ELSE 'Tidak' 
                END AS is_odm
            FROM 
                perkara p
                INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id 
            WHERE 
                YEAR(pp.tanggal_minutasi) = ? 
                AND MONTH(pp.tanggal_minutasi) = ?
                AND pp.tanggal_minutasi IS NOT NULL
            ORDER BY 
                pp.tanggal_minutasi DESC";

		// Gunakan query binding untuk keamanan
		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
		return $query->result();
	}

	/**
	 * Mendapatkan statistik One Day Minute
	 * 
	 * @param string $lap_bulan Bulan (01-12)
	 * @param string $lap_tahun Tahun
	 * @return object Data statistik
	 */
	function get_statistics($lap_bulan, $lap_tahun)
	{
		// Sanitasi input
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		// Query untuk statistik dasar dengan satu query (lebih efisien)
		$sql = "SELECT 
                COUNT(*) AS total_count,
                SUM(CASE WHEN DATE(pp.tanggal_minutasi) = DATE(pp.tanggal_putusan) THEN 1 ELSE 0 END) AS odm_count,
                AVG(DATEDIFF(pp.tanggal_minutasi, pp.tanggal_putusan)) AS avg_days,
                COUNT(CASE WHEN DATEDIFF(pp.tanggal_minutasi, pp.tanggal_putusan) > 0 THEN 1 END) AS delay_count,
                MAX(DATEDIFF(pp.tanggal_minutasi, pp.tanggal_putusan)) AS max_delay
            FROM 
                perkara p
                INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id 
            WHERE 
                YEAR(pp.tanggal_minutasi) = ? 
                AND MONTH(pp.tanggal_minutasi) = ?
                AND pp.tanggal_minutasi IS NOT NULL";

		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
		return $query->row();
	}

	/**
	 * Mendapatkan distribusi jenis perkara untuk ODM
	 * 
	 * @param string $lap_bulan Bulan (01-12)
	 * @param string $lap_tahun Tahun
	 * @return array Distribusi jenis perkara
	 */
	function get_jenis_perkara_distribution($lap_bulan, $lap_tahun)
	{
		// Sanitasi input
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		// Query untuk distribusi jenis perkara dengan agregasi di database
		$sql = "SELECT 
                p.jenis_perkara_nama,
                COUNT(*) AS total,
                SUM(CASE WHEN DATE(pp.tanggal_minutasi) = DATE(pp.tanggal_putusan) THEN 1 ELSE 0 END) AS odm_count
            FROM 
                perkara p
                INNER JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id 
            WHERE 
                YEAR(pp.tanggal_minutasi) = ? 
                AND MONTH(pp.tanggal_minutasi) = ?
                AND pp.tanggal_minutasi IS NOT NULL
            GROUP BY 
                p.jenis_perkara_nama
            ORDER BY 
                total DESC
            LIMIT 10"; // Batasi hanya 10 jenis perkara teratas

		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
		return $query->result();
	}
}
