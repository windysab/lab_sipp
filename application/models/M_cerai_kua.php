<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_cerai_kua extends CI_Model
{
	function cerai_kua($lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT nomor_perkara, tgl_akta_cerai, nomor_akta_cerai, a.nama as nama_p, c.alamat as alamat_p, b.nama as nama_t, d.alamat as alamat_t, kua_tempat_nikah
			FROM perkara, perkara_akta_cerai, perkara_pihak1 a, perkara_pihak2 b, pihak c, pihak d, perkara_data_pernikahan
			WHERE perkara.`perkara_id`=perkara_akta_cerai.`perkara_id`
			AND perkara.`perkara_id`=a.`perkara_id`
			AND perkara.`perkara_id`=b.`perkara_id`
			AND a.`pihak_id`=c.`id`
			AND b.`pihak_id`=d.`id`
			AND perkara.`perkara_id`=perkara_data_pernikahan.`perkara_id`
			AND YEAR(tgl_akta_cerai)='$lap_tahun' AND MONTH(tgl_akta_cerai)='$lap_bulan'
			ORDER BY nomor_urut_akta_cerai");
		return $query->result();

	}
}