<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Diska extends CI_Model
{
	function diska($lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT nomor_perkara, tanggal_pendaftaran, tanggal_putusan, status_putusan.`nama` as jenis_putusan, tanggal_sidang FROM perkara
			LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
			LEFT JOIN status_putusan ON perkara_putusan.`status_putusan_id`= status_putusan.`id`
			LEFT JOIN perkara_jadwal_sidang ON perkara.`perkara_id`=perkara_jadwal_sidang.`perkara_id`
			WHERE YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan' AND jenis_perkara_nama LIKE '%Dispensasi%'
			ORDER BY perkara.`perkara_id`");
		return $query->result();

	}
}