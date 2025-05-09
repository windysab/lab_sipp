<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Penyerahan_ac extends CI_Model
{
	function penyerahan_ac($lap_bulan, $lap_tahun)
	{
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		$query = $this->db->query("SELECT nomor_perkara, jenis_perkara_nama, nomor_akta_cerai, tanggal_putusan, tgl_ikrar_talak, tanggal_bht, tgl_penyerahan_akta_cerai as tgl_AC_P, tgl_penyerahan_akta_cerai_pihak2 as tgl_AC_T, perkara_pihak1.`nama` as nama_p, perkara_pihak2.`nama` as nama_t FROM perkara
			LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
			LEFT JOIN perkara_ikrar_talak ON perkara.`perkara_id`=perkara_ikrar_talak.`perkara_id`
			LEFT JOIN perkara_akta_cerai ON perkara.`perkara_id`=perkara_akta_cerai.`perkara_id`
			LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
			LEFT JOIN perkara_pihak2 ON perkara.`perkara_id`=perkara_pihak2.`perkara_id`
			WHERE (YEAR(tgl_penyerahan_akta_cerai)='$lap_tahun' AND MONTH(tgl_penyerahan_akta_cerai)='$lap_bulan') OR (YEAR(tgl_penyerahan_akta_cerai_pihak2)='$lap_tahun' AND MONTH(tgl_penyerahan_akta_cerai_pihak2)='$lap_bulan')
			ORDER BY perkara.perkara_id");
		return $query->result();
	}

	function getStatistics($lap_bulan, $lap_tahun)
	{
		$lap_bulan = $this->db->escape_str($lap_bulan);
		$lap_tahun = $this->db->escape_str($lap_tahun);

		$sql = "SELECT
			COUNT(*) as total,
			SUM(CASE WHEN (jenis_perkara_nama = 'Cerai Talak' AND tgl_penyerahan_akta_cerai IS NOT NULL) OR (jenis_perkara_nama = 'Cerai Gugat' AND tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL) THEN 1 ELSE 0 END) as total_suami,
			SUM(CASE WHEN (jenis_perkara_nama = 'Cerai Talak' AND tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL) OR (jenis_perkara_nama = 'Cerai Gugat' AND tgl_penyerahan_akta_cerai IS NOT NULL) THEN 1 ELSE 0 END) as total_istri
			FROM perkara
			LEFT JOIN perkara_akta_cerai ON perkara.perkara_id = perkara_akta_cerai.perkara_id
			WHERE (YEAR(tgl_penyerahan_akta_cerai)='$lap_tahun' AND MONTH(tgl_penyerahan_akta_cerai)='$lap_bulan')
			   OR (YEAR(tgl_penyerahan_akta_cerai_pihak2)='$lap_tahun' AND MONTH(tgl_penyerahan_akta_cerai_pihak2)='$lap_bulan')";
		$query = $this->db->query($sql);
		return $query->row();
	}
}
