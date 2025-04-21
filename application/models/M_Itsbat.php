<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Itsbat extends CI_Model
{
	function itsbat($lap_bulan, $lap_tahun)
	{
		$query = $this->db->query("SELECT 
    nomor_perkara,
    tanggal_pendaftaran,
    tanggal_putusan,
    status_putusan.nama AS jenis_putusan,
    a.`nama` AS nama_p1,
    c.`tanggal_lahir` AS tanggal_lahir_p1,
    b.`nama` nama_p2,
    d.`tanggal_lahir` AS tanggal_lahir_p2,
    TIMESTAMPDIFF(YEAR, c.`tanggal_lahir`, tanggal_pendaftaran) AS usia_p1,
    TIMESTAMPDIFF(YEAR, d.`tanggal_lahir`, tanggal_pendaftaran) AS usia_p2,
    posita as tahun_nikah
FROM perkara
LEFT JOIN perkara_pihak1 a ON perkara.`perkara_id`=a.`perkara_id`
LEFT JOIN perkara_pihak1 b ON perkara.`perkara_id`=b.`perkara_id`
LEFT JOIN pihak c ON a.`pihak_id`=c.`id`
LEFT JOIN pihak d ON b.`pihak_id`=d.`id`
LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
LEFT JOIN status_putusan ON perkara_putusan.`status_putusan_id`= status_putusan.`id`
WHERE YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
AND jenis_perkara_nama = 'Pengesahan Perkawinan/Istbat Nikah'
AND ((a.`urutan` < b.`urutan`) OR (perkara.pihak1_text NOT LIKE '%br%'))
ORDER BY perkara.`perkara_id`");
		return $query->result();
	}
}
