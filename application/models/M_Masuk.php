<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Masuk extends CI_Model
{
	function masuk($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT majelis_hakim_nama, COUNT(majelis_hakim_nama) AS masuk
		FROM perkara
		INNER JOIN perkara_penetapan ON perkara.`perkara_id`=perkara_penetapan.`perkara_id`
		AND nomor_perkara LIKE '%$jenis_perkara%' AND YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
		GROUP BY majelis_hakim_nama");
		return $query->result();

	}
}