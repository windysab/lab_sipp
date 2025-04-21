<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_odm extends CI_Model
{
	function odm($lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT nomor_perkara, jenis_perkara_nama, tanggal_putusan, tanggal_minutasi
				FROM perkara, perkara_putusan
				WHERE perkara.perkara_id=perkara_putusan.perkara_id 
				AND YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
				ORDER BY tanggal_putusan, nomor_perkara");
		return $query->result();

	}
}