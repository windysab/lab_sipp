<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_ecourt extends CI_Model
{
	function ecourt($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT perkara_pihak1.`nama` as nama_pihak, `email`,jenis_perkara_nama, nomor_perkara, tanggal_pendaftaran FROM perkara
			INNER JOIN perkara_efiling_id ON perkara.`perkara_id`=`perkara_efiling_id`.`perkara_id`
			INNER JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
			INNER JOIN pihak ON perkara_pihak1.`pihak_id`=pihak.`id`
			WHERE YEAR(`tanggal_pendaftaran`)='$lap_tahun' AND MONTH(`tanggal_pendaftaran`)='$lap_bulan' AND nomor_perkara LIKE '%$jenis_perkara%' AND perkara_pihak1.urutan='1'
			ORDER BY perkara.`perkara_id`
		");
		return $query->result();

	}
}