<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_cerai_kua extends CI_Model
{
	function cerai_kua($lap_bulan, $lap_tahun)
	{
		// Sanitasi input untuk mencegah SQL injection
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		// Query lebih efisien menggunakan JOIN yang selektif
		$sql = "SELECT 
                p.nomor_perkara,
                pac.tgl_akta_cerai,
                pac.nomor_akta_cerai,
                pp1.nama AS nama_p,
                ph1.alamat AS alamat_p,
                pp2.nama AS nama_t,
                ph2.alamat AS alamat_t,
                pdp.kua_tempat_nikah
            FROM 
                perkara p
                INNER JOIN perkara_akta_cerai pac ON p.perkara_id = pac.perkara_id
                LEFT JOIN perkara_pihak1 pp1 ON p.perkara_id = pp1.perkara_id
                LEFT JOIN perkara_pihak2 pp2 ON p.perkara_id = pp2.perkara_id
                LEFT JOIN pihak ph1 ON pp1.pihak_id = ph1.id
                LEFT JOIN pihak ph2 ON pp2.pihak_id = ph2.id
                LEFT JOIN perkara_data_pernikahan pdp ON p.perkara_id = pdp.perkara_id
            WHERE 
                YEAR(pac.tgl_akta_cerai) = ? 
                AND MONTH(pac.tgl_akta_cerai) = ?
            ORDER BY 
                pac.nomor_urut_akta_cerai";

		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
		return $query->result();
	}

	function get_statistics($lap_bulan, $lap_tahun)
	{
		// Sanitasi input
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		// Query untuk statistik
		$sql = "SELECT 
                COUNT(DISTINCT pdp.kua_tempat_nikah) AS total_kua
            FROM 
                perkara p
                INNER JOIN perkara_akta_cerai pac ON p.perkara_id = pac.perkara_id
                LEFT JOIN perkara_data_pernikahan pdp ON p.perkara_id = pdp.perkara_id
            WHERE 
                YEAR(pac.tgl_akta_cerai) = ? 
                AND MONTH(pac.tgl_akta_cerai) = ?
                AND pdp.kua_tempat_nikah IS NOT NULL";

		$query = $this->db->query($sql, array($lap_tahun, $lap_bulan));
		return $query->row();
	}
}
