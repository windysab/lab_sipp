<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_PNS extends CI_Model
{
	function pns($jenis_perkara, $lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT nomor_perkara, majelis_hakim_nama, panitera_pengganti_text, tanggal_pendaftaran, penetapan_majelis_hakim, penetapan_hari_sidang, sidang_pertama, tanggal_putusan, status_putusan_nama, pekerjaan
			FROM perkara
			LEFT JOIN perkara_penetapan ON perkara.`perkara_id`=perkara_penetapan.`perkara_id`
			LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
			LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
			LEFT JOIN pihak ON perkara_pihak1.`pihak_id`=pihak.`id`
			WHERE ((YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan') 
			OR (YEAR(penetapan_majelis_hakim)='$lap_tahun' AND MONTH(penetapan_majelis_hakim)='$lap_bulan')
			OR (YEAR(penetapan_hari_sidang)='$lap_tahun' AND MONTH(penetapan_hari_sidang)='$lap_bulan')
			OR (YEAR(sidang_pertama)='$lap_tahun' AND MONTH(sidang_pertama)='$lap_bulan')
			OR (YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan') or tanggal_putusan is null
			) 
			and perkara.nomor_perkara like '%$jenis_perkara%'
			AND perkara_pihak1.`urutan`='1' AND (pekerjaan LIKE '%PNS%' or pekerjaan LIKE '%Pegawai Negeri Sipil%') AND pekerjaan NOT LIKE '%Pensiunan%'
			ORDER BY perkara.`perkara_id`
			");
		return $query->result();

	}
}