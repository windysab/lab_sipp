<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_putus extends CI_Model
{
	function putus($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT majelis_hakim_nama, COUNT(majelis_hakim_nama) AS putus
		FROM perkara, perkara_penetapan, perkara_putusan
		WHERE perkara.`perkara_id`=perkara_penetapan.`perkara_id` 
		AND perkara.`perkara_id`=perkara_putusan.`perkara_id`
		AND YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan' 
		AND nomor_perkara LIKE '%$jenis_perkara%'
		GROUP BY majelis_hakim_nama");
		return $query->result();

	}
}