<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Usia_cerai extends CI_Model
{
	function usia_cerai($lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT nomor_perkara, tanggal_putusan,`faktor_perceraian`.`nama` as alasan, a.`nama` as nama_p, c.`tanggal_lahir` as tanggal_lahir_p, b.`nama` as nama_t, d.`tanggal_lahir` as tanggal_lahir_t, TIMESTAMPDIFF(YEAR,c.`tanggal_lahir`,tanggal_putusan) AS usia_p, TIMESTAMPDIFF(YEAR,d.`tanggal_lahir`,tanggal_putusan) AS usia_t
			FROM perkara
			INNER JOIN perkara_akta_cerai ON perkara.`perkara_id`=perkara_akta_cerai.`perkara_id`
			INNER JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
			LEFT JOIN `faktor_perceraian` ON perkara_akta_cerai.`faktor_perceraian_id`=`faktor_perceraian`.`id`
			LEFT JOIN perkara_pihak1 a ON perkara.`perkara_id`=a.`perkara_id`
			LEFT JOIN perkara_pihak2 b ON perkara.`perkara_id`=b.`perkara_id`
			LEFT JOIN pihak c ON a.`pihak_id`=c.`id`
			LEFT JOIN pihak d ON b.`pihak_id`=d.`id`
			WHERE YEAR(tgl_akta_cerai)='$lap_tahun' AND MONTH(tgl_akta_cerai)='$lap_bulan'  
			ORDER BY perkara.`perkara_id`");
		return $query->result();

	}
}