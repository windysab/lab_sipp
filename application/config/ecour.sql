SELECT (
        @row_number := @row_number + 1
    ) AS jumlah,
    perkara_pihak1.`nama` AS nama_pihak,
    `email`,
    jenis_perkara_nama,
    nomor_perkara,
    tanggal_pendaftaran
FROM
    perkara
    INNER JOIN perkara_efiling_id ON perkara.`perkara_id` = perkara_efiling_id.`perkara_id`
    INNER JOIN perkara_pihak1 ON perkara.`perkara_id` = perkara_pihak1.`perkara_id`
    INNER JOIN pihak ON perkara_pihak1.`pihak_id` = pihak.`id`,
    (
        SELECT @row_number := 0
    ) AS t
WHERE
    YEAR(`tanggal_pendaftaran`) = '2025'
    AND MONTH(`tanggal_pendaftaran`) = '05'
    AND nomor_perkara LIKE '%Pdt.P%'
    AND perkara_pihak1.urutan = '1'
ORDER BY perkara.`perkara_id`