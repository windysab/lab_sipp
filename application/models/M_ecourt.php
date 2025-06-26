<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_ecourt extends CI_Model
{
	/**
	 * Get E-Court cases based on filters
	 * 
	 * @param string $jenis_perkara Type of case
	 * @param string $lap_bulan Month (01-12)
	 * @param string $lap_tahun Year
	 * @return array List of E-Court cases
	 */
	public function ecourt($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		// Initialize row counter
		$this->db->query('SET @row_number := 0');

		// Use direct SQL query approach to match your working SQL
		$this->db->select('
            (@row_number := @row_number + 1) as jumlah,
            pp1.nama as nama_pihak,
            ph.email,
            p.jenis_perkara_nama,
            p.nomor_perkara,
            tanggal_pendaftaran,
            CASE WHEN p.nomor_perkara IS NOT NULL THEN "Teregistrasi" ELSE "Pendaftaran" END as status,
            p.perkara_id
        ', FALSE);

		$this->db->from('perkara p');
		$this->db->join('perkara_efiling_id pei', 'p.perkara_id = pei.perkara_id', 'inner');
		$this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'inner');
		$this->db->join('pihak ph', 'pp1.pihak_id = ph.id', 'inner');

		// Apply filters
		$this->db->where('YEAR(tanggal_pendaftaran)', $lap_tahun);
		$this->db->where('MONTH(tanggal_pendaftaran)', $lap_bulan);
		$this->db->where('pp1.urutan', '1');

		if ($jenis_perkara !== 'all') {
			$this->db->like('p.nomor_perkara', $jenis_perkara, 'both');
		}

		$this->db->order_by('p.perkara_id', 'ASC');

		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Get statistics for E-Court cases
	 * 
	 * @param string $lap_bulan Month (01-12)
	 * @param string $lap_tahun Year
	 * @return object Statistics data
	 */
	public function get_stats($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		$stats = new stdClass();

		// Count total cases first
		$this->db->select('COUNT(*) as total_count');
		$this->db->from('perkara p');
		$this->db->join('perkara_efiling_id pei', 'p.perkara_id = pei.perkara_id', 'inner');
		$this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'inner');
		$this->db->where('YEAR(tanggal_pendaftaran)', $lap_tahun);
		$this->db->where('MONTH(tanggal_pendaftaran)', $lap_bulan);
		$this->db->where('pp1.urutan', '1');

		$result = $this->db->get()->row();
		$stats->total_count = $result->total_count;

		// Count registered cases
		$this->db->select('COUNT(*) as registered_count');
		$this->db->from('perkara p');
		$this->db->join('perkara_efiling_id pei', 'p.perkara_id = pei.perkara_id', 'inner');
		$this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'inner');
		$this->db->where('YEAR(tanggal_pendaftaran)', $lap_tahun);
		$this->db->where('MONTH(tanggal_pendaftaran)', $lap_bulan);
		$this->db->where('p.nomor_perkara IS NOT NULL');

		$result = $this->db->get()->row();
		$stats->registered_count = $result->registered_count;

		// Count Gugatan (Pdt.G) cases
		$this->db->select('COUNT(*) as gugatan_count');
		$this->db->from('perkara p');
		$this->db->join('perkara_efiling_id pei', 'p.perkara_id = pei.perkara_id', 'inner');
		$this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'inner');
		$this->db->where('YEAR(tanggal_pendaftaran)', $lap_tahun);
		$this->db->where('MONTH(tanggal_pendaftaran)', $lap_bulan);
		$this->db->like('p.nomor_perkara', 'Pdt.G', 'both');

		$result = $this->db->get()->row();
		$stats->gugatan_count = $result->gugatan_count;

		// Count Permohonan (Pdt.P) cases
		$this->db->select('COUNT(*) as permohonan_count');
		$this->db->from('perkara p');
		$this->db->join('perkara_efiling_id pei', 'p.perkara_id = pei.perkara_id', 'inner');
		$this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'inner');
		$this->db->where('YEAR(tanggal_pendaftaran)', $lap_tahun);
		$this->db->where('MONTH(tanggal_pendaftaran)', $lap_bulan);
		$this->db->like('p.nomor_perkara', 'Pdt.P', 'both');

		$result = $this->db->get()->row();
		$stats->permohonan_count = $result->permohonan_count;

		return $stats;
	}

	/**
	 * Get case detail
	 * 
	 * @param int $perkara_id Case ID
	 * @return object Case details
	 */
	public function get_case_detail($perkara_id)
	{
		$this->db->select('
            p.*,
            pe.efiling_id,
            pe.tanggal_pendaftaran as ecourt_reg_date,
            pe.status_pembayaran,
            pe.jumlah_skum,
            pe.tanggal_bayar,
            pp1.nama as nama_penggugat,
            pp2.nama as nama_tergugat
        ');
		$this->db->from('perkara p');
		$this->db->join('perkara_efiling_id pei', 'p.perkara_id = pei.perkara_id', 'left');
		$this->db->join('perkara_efiling pe', 'pe.efiling_id = pei.efiling_id', 'left');
		$this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id AND pp1.urutan = 1', 'left');
		$this->db->join('perkara_pihak2 pp2', 'p.perkara_id = pp2.perkara_id AND pp2.urutan = 1', 'left');
		$this->db->where('p.perkara_id', $perkara_id);

		$query = $this->db->get();
		return $query->row();
	}
}
