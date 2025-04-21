<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_odp extends CI_Model
{
	// function odp($lap_bulan, $lap_tahun)
	// {
	// 	$query = $this->db->query("SELECT nomor_perkara, jenis_perkara_nama, tanggal_putusan, dirput_dokumen.`created_date` AS tanggal_publish 
	// 			FROM perkara, perkara_putusan, dirput_dokumen
	// 			WHERE perkara.`perkara_id`=perkara_putusan.`perkara_id`
	// 			AND perkara_putusan.`perkara_id`=dirput_dokumen.`perkara_id`
	// 			AND YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
	// 			AND filename LIKE '%anonimisasi%'
	// 			ORDER BY tanggal_putusan, nomor_perkara");
	// 	return $query->result();

	// }

	function odp($lap_tahun)
	{
		$query = $this->db->query("SELECT nomor_perkara, jenis_perkara_nama, tanggal_putusan, dirput_dokumen.`created_date` AS tanggal_publish 
				FROM perkara, perkara_putusan, dirput_dokumen
				WHERE perkara.`perkara_id`=perkara_putusan.`perkara_id`
				AND perkara_putusan.`perkara_id`=dirput_dokumen.`perkara_id`
				AND YEAR(tanggal_putusan)='$lap_tahun'
				AND filename LIKE '%anonimisasi%'
				ORDER BY tanggal_putusan, nomor_perkara");
		return $query->result();

	}
}