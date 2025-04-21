<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_sisa_bulan_ini extends CI_Model
{
	function sisa_bulan_ini($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT majelis_hakim_nama, COUNT(majelis_hakim_nama) AS sisa_bulan_ini
		FROM perkara
		INNER JOIN perkara_penetapan ON perkara.`perkara_id`=perkara_penetapan.`perkara_id`
		LEFT JOIN perkara_putusan ON perkara.`perkara_id` = perkara_putusan.`perkara_id`
		WHERE (tanggal_putusan IS NULL OR(tanggal_putusan > '$lap_tahun-$lap_bulan-31')) AND tanggal_pendaftaran<='$lap_tahun-$lap_bulan-31'
		AND nomor_perkara LIKE '%$jenis_perkara%'
		GROUP BY majelis_hakim_nama
		");
		return $query->result();

	}
}