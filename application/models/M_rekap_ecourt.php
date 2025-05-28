<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_rekap_ecourt extends CI_Model
{
	/**
	 * Get summary statistics for E-Court cases
	 * 
	 * @param string $tahun Year to filter
	 * @param string $jenis_perkara Case type to filter (optional)
	 * @return object Summary statistics
	 */
	public function get_summary($tahun, $jenis_perkara = null)
	{
		// Get total E-Court cases
		$this->db->select('COUNT(*) as total_perkara');
		$this->db->from('perkara_efiling pe');
		$this->db->join('perkara p', 'pe.nomor_perkara = p.nomor_perkara', 'left');
		$this->db->where('YEAR(pe.tanggal_pendaftaran)', $tahun);

		if (!empty($jenis_perkara)) {
			$this->db->where('p.jenis_perkara_nama', $jenis_perkara);
		}

		$result = $this->db->get()->row();
		$summary = new stdClass();
		$summary->total_perkara = $result->total_perkara;

		// Get total decided cases
		$this->db->select('COUNT(*) as total_decided');
		$this->db->from('perkara_efiling pe');
		$this->db->join('perkara p', 'pe.nomor_perkara = p.nomor_perkara', 'left');
		$this->db->join('perkara_putusan pp', 'p.perkara_id = pp.perkara_id', 'left');
		$this->db->where('YEAR(pe.tanggal_pendaftaran)', $tahun);
		$this->db->where('pp.tanggal_putusan IS NOT NULL');

		if (!empty($jenis_perkara)) {
			$this->db->where('p.jenis_perkara_nama', $jenis_perkara);
		}

		$result = $this->db->get()->row();
		$summary->total_decided = $result->total_decided;

		// Calculate ongoing cases
		$summary->total_ongoing = $summary->total_perkara - $summary->total_decided;

		// Get total all cases for this year (not just E-Court)
		$this->db->select('COUNT(*) as total_all_cases');
		$this->db->from('perkara p');
		$this->db->where('YEAR(p.tanggal_pendaftaran)', $tahun);

		if (!empty($jenis_perkara)) {
			$this->db->where('p.jenis_perkara_nama', $jenis_perkara);
		}

		$result = $this->db->get()->row();
		$total_all_cases = $result->total_all_cases;

		// Calculate percentages
		$summary->percentage_ecourt = $total_all_cases > 0 ? round(($summary->total_perkara / $total_all_cases) * 100, 2) : 0;
		$summary->percentage_decided = $summary->total_perkara > 0 ? round(($summary->total_decided / $summary->total_perkara) * 100, 2) : 0;
		$summary->percentage_ongoing = $summary->total_perkara > 0 ? round(($summary->total_ongoing / $summary->total_perkara) * 100, 2) : 0;

		return $summary;
	}

	/**
	 * Get monthly statistics for E-Court cases
	 * 
	 * @param string $tahun Year to filter
	 * @param string $jenis_perkara Case type to filter (optional)
	 * @return array Monthly statistics
	 */
	public function get_monthly_stats($tahun, $jenis_perkara = null)
	{
		// Create array of month objects instead of associative array
		$monthly_stats = [];

		// Initialize month names in Indonesian
		$month_names = [
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		];

		// Initialize months with standard objects
		for ($month = 1; $month <= 12; $month++) {
			$month_obj = new stdClass();
			$month_obj->month_name = $month_names[$month - 1];
			$month_obj->month_num = $month;
			$month_obj->total_cases = 0;
			$month_obj->total_decided = 0;

			$monthly_stats[$month] = $month_obj;
		}

		try {
			// Get monthly case counts - with better SQL for performance
			$sql = "SELECT 
					MONTH(pe.tanggal_pendaftaran) as month, 
					COUNT(*) as total_count,
					SUM(CASE WHEN pput.tanggal_putusan IS NOT NULL THEN 1 ELSE 0 END) as decided_count
				FROM 
					perkara_efiling pe
					LEFT JOIN perkara p ON pe.nomor_perkara = p.nomor_perkara
					LEFT JOIN perkara_putusan pput ON p.perkara_id = pput.perkara_id
				WHERE 
					YEAR(pe.tanggal_pendaftaran) = ?";

			$params = [$tahun];

			if (!empty($jenis_perkara)) {
				$sql .= " AND p.jenis_perkara_nama = ?";
				$params[] = $jenis_perkara;
			}

			$sql .= " GROUP BY MONTH(pe.tanggal_pendaftaran)";

			$query = $this->db->query($sql, $params);
			$result = $query->result();

			// Update the initialized array with actual counts
			foreach ($result as $row) {
				if (isset($monthly_stats[$row->month])) {
					$monthly_stats[$row->month]->total_cases = (int)$row->total_count;
					$monthly_stats[$row->month]->total_decided = (int)$row->decided_count;
				}
			}

			// Convert to indexed array for easier consumption in JavaScript
			return array_values($monthly_stats);
		} catch (Exception $e) {
			log_message('error', 'Error in get_monthly_stats: ' . $e->getMessage());

			// Return empty initialized data on error
			return array_values($monthly_stats);
		}
	}

	/**
	 * Get case type distribution for E-Court cases
	 * 
	 * @param string $tahun Year to filter
	 * @return array Case type distribution
	 */
	public function get_case_type_distribution($tahun)
	{
		$this->db->select('p.jenis_perkara_nama, COUNT(*) as count');
		$this->db->from('perkara_efiling pe');
		$this->db->join('perkara p', 'pe.nomor_perkara = p.nomor_perkara', 'left');
		$this->db->where('YEAR(pe.tanggal_pendaftaran)', $tahun);
		$this->db->where('p.jenis_perkara_nama IS NOT NULL');
		$this->db->group_by('p.jenis_perkara_nama');
		$this->db->order_by('count', 'DESC');

		return $this->db->get()->result();
	}

	/**
	 * Get status distribution for E-Court cases
	 * 
	 * @param string $tahun Year to filter
	 * @param string $jenis_perkara Case type to filter (optional)
	 * @return array Status distribution
	 */
	public function get_status_distribution($tahun, $jenis_perkara = null)
	{
		$this->db->select('
            CASE
                WHEN pput.tanggal_putusan IS NOT NULL THEN "Putus"
                WHEN pp.penetapan_majelis_hakim IS NOT NULL THEN "Proses Persidangan"
                WHEN p.nomor_perkara IS NOT NULL THEN "Terdaftar"
                ELSE "Pendaftaran"
            END as status,
            COUNT(*) as count
        ', FALSE);

		$this->db->from('perkara_efiling pe');
		$this->db->join('perkara p', 'pe.nomor_perkara = p.nomor_perkara', 'left');
		$this->db->join('perkara_penetapan pp', 'p.perkara_id = pp.perkara_id', 'left');
		$this->db->join('perkara_putusan pput', 'p.perkara_id = pput.perkara_id', 'left');
		$this->db->where('YEAR(pe.tanggal_pendaftaran)', $tahun);

		if (!empty($jenis_perkara)) {
			$this->db->where('p.jenis_perkara_nama', $jenis_perkara);
		}

		$this->db->group_by('status');

		return $this->db->get()->result();
	}

	/**
	 * Get detailed list of E-Court cases
	 * 
	 * @param string $tahun Year to filter
	 * @param string $jenis_perkara Case type to filter (optional)
	 * @return array List of E-Court cases
	 */
	public function get_ecourt_cases($tahun, $jenis_perkara = null)
	{
		$this->db->select('
            pe.efiling_id,
            p.perkara_id,
            p.nomor_perkara,
            p.jenis_perkara_nama,
            pe.tanggal_pendaftaran,
            pput.tanggal_putusan,
            CASE
                WHEN pput.tanggal_putusan IS NOT NULL THEN "Putus"
                WHEN pp.penetapan_majelis_hakim IS NOT NULL THEN "Proses Persidangan"
                WHEN p.nomor_perkara IS NOT NULL THEN "Terdaftar"
                ELSE "Pendaftaran"
            END as status_perkara,
            pp1.nama as nama_advokat
        ', FALSE);

		$this->db->from('perkara_efiling pe');
		$this->db->join('perkara p', 'pe.nomor_perkara = p.nomor_perkara', 'left');
		$this->db->join('perkara_penetapan pp', 'p.perkara_id = pp.perkara_id', 'left');
		$this->db->join('perkara_putusan pput', 'p.perkara_id = pput.perkara_id', 'left');
		// Tambahkan join untuk mendapatkan nama advokat/pengacara
		$this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id AND pp1.urutan = 1', 'left');
		$this->db->where('YEAR(pe.tanggal_pendaftaran)', $tahun);

		if (!empty($jenis_perkara)) {
			$this->db->where('p.jenis_perkara_nama', $jenis_perkara);
		}

		$this->db->order_by('pe.tanggal_pendaftaran', 'DESC');

		return $this->db->get()->result();
	}

	/**
	 * Get list of case types for filter dropdown
	 * 
	 * @return array List of case types
	 */
	public function get_jenis_perkara_list()
	{
		$this->db->select('DISTINCT(jenis_perkara_nama) as jenis_perkara');
		$this->db->from('perkara');
		$this->db->where('jenis_perkara_nama IS NOT NULL');
		$this->db->order_by('jenis_perkara_nama', 'ASC');

		return $this->db->get()->result();
	}
}
