<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Biaya_perdata extends CI_Model
{
    /**
     * Get civil case fee data
     * 
     * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
     * @param string $lap_bulan Month (01-12)
     * @param string $lap_tahun Year
     * @return array Array of fee data
     */
    function get_biaya_perdata($jenis_perkara, $lap_bulan, $lap_tahun)
    {
        // Sanitize input parameters
        $jenis_perkara = $this->db->escape_str($jenis_perkara);
        $lap_bulan = $this->db->escape_str($lap_bulan);
        $lap_tahun = $this->db->escape_str($lap_tahun);

        $sql = "SELECT 
                p.perkara_id,
                p.nomor_perkara,
                p.jenis_perkara_nama,
                p.tanggal_pendaftaran,
                pp.tanggal_putusan,
                p.prodeo,
                SUM(pb.jumlah) as total_biaya
            FROM 
                perkara p
                INNER JOIN perkara_biaya pb ON p.perkara_id = pb.perkara_id
                LEFT JOIN perkara_putusan pp ON p.perkara_id = pp.perkara_id
            WHERE 
                p.prodeo = 0
                AND p.nomor_perkara LIKE '%$jenis_perkara%'
                AND YEAR(p.tanggal_pendaftaran)='$lap_tahun' 
                AND MONTH(p.tanggal_pendaftaran)='$lap_bulan'
            GROUP BY 
                p.perkara_id
            ORDER BY 
                p.tanggal_pendaftaran DESC";

        $query = $this->db->query($sql);
        return $query->result();
    }

    /**
     * Get fee component breakdown
     * 
     * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
     * @param string $lap_bulan Month (01-12)
     * @param string $lap_tahun Year
     * @return array Array of fee components
     */
    function get_komponen_biaya($jenis_perkara, $lap_bulan, $lap_tahun)
    {
        // Sanitize input parameters
        $jenis_perkara = $this->db->escape_str($jenis_perkara);
        $lap_bulan = $this->db->escape_str($lap_bulan);
        $lap_tahun = $this->db->escape_str($lap_tahun);

        $sql = "SELECT 
                jb.nama as jenis_biaya,
                COUNT(pb.id) as jumlah_kasus,
                AVG(pb.jumlah) as rata_rata,
                MIN(pb.jumlah) as minimum,
                MAX(pb.jumlah) as maksimum,
                SUM(pb.jumlah) as total
            FROM 
                perkara p
                INNER JOIN perkara_biaya pb ON p.perkara_id = pb.perkara_id
                INNER JOIN jenis_biaya jb ON pb.jenis_biaya_id = jb.id
            WHERE 
                p.prodeo = 0
                AND p.nomor_perkara LIKE '%$jenis_perkara%'
                AND YEAR(p.tanggal_pendaftaran)='$lap_tahun' 
                AND MONTH(p.tanggal_pendaftaran)='$lap_bulan'
            GROUP BY 
                pb.jenis_biaya_id, jb.nama
            ORDER BY 
                total DESC";

        $query = $this->db->query($sql);
        return $query->result();
    }

    /**
     * Get case fee statistics
     * 
     * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
     * @param string $lap_bulan Month (01-12)
     * @param string $lap_tahun Year
     * @return object Statistics data
     */
    function get_statistics($jenis_perkara, $lap_bulan, $lap_tahun)
    {
        // Sanitize input parameters
        $jenis_perkara = $this->db->escape_str($jenis_perkara);
        $lap_bulan = $this->db->escape_str($lap_bulan);
        $lap_tahun = $this->db->escape_str($lap_tahun);

        $sql = "SELECT 
                COUNT(DISTINCT p.perkara_id) as total_perkara,
                AVG(case_totals.total_biaya) as avg_biaya,
                MIN(case_totals.total_biaya) as min_biaya,
                MAX(case_totals.total_biaya) as max_biaya,
                STDDEV(case_totals.total_biaya) as std_biaya
            FROM 
                perkara p
                INNER JOIN (
                    SELECT 
                        pb.perkara_id, 
                        SUM(pb.jumlah) as total_biaya
                    FROM 
                        perkara_biaya pb
                    GROUP BY 
                        pb.perkara_id
                ) as case_totals ON p.perkara_id = case_totals.perkara_id
            WHERE 
                p.prodeo = 0
                AND p.nomor_perkara LIKE '%$jenis_perkara%'
                AND YEAR(p.tanggal_pendaftaran)='$lap_tahun' 
                AND MONTH(p.tanggal_pendaftaran)='$lap_bulan'";

        $query = $this->db->query($sql);
        $result = $query->row();

        // Get prodeo cases count for comparison
        $sql_prodeo = "SELECT 
                COUNT(*) as total_prodeo
            FROM 
                perkara p
            WHERE 
                p.prodeo = 1
                AND p.nomor_perkara LIKE '%$jenis_perkara%'
                AND YEAR(p.tanggal_pendaftaran)='$lap_tahun' 
                AND MONTH(p.tanggal_pendaftaran)='$lap_bulan'";

        $query_prodeo = $this->db->query($sql_prodeo);
        $prodeo_result = $query_prodeo->row();

        $result->total_prodeo = $prodeo_result->total_prodeo;

        // Calculate potential savings
        if ($result->avg_biaya && $prodeo_result->total_prodeo) {
            $result->potential_savings = $result->avg_biaya * $prodeo_result->total_prodeo;
        } else {
            $result->potential_savings = 0;
        }

        return $result;
    }

    /**
     * Get yearly trends for case costs
     * 
     * @param string $jenis_perkara Case type (e.g., Pdt.G, Pdt.P)
     * @param string $lap_tahun Year
     * @return array Monthly data for the year
     */
    function get_yearly_trend($jenis_perkara, $lap_tahun)
    {
        // Sanitize input parameters
        $jenis_perkara = $this->db->escape_str($jenis_perkara);
        $lap_tahun = $this->db->escape_str($lap_tahun);

        $sql = "SELECT 
                MONTH(p.tanggal_pendaftaran) as bulan,
                COUNT(DISTINCT p.perkara_id) as total_perkara,
                AVG(case_totals.total_biaya) as avg_biaya
            FROM 
                perkara p
                INNER JOIN (
                    SELECT 
                        pb.perkara_id, 
                        SUM(pb.jumlah) as total_biaya
                    FROM 
                        perkara_biaya pb
                    GROUP BY 
                        pb.perkara_id
                ) as case_totals ON p.perkara_id = case_totals.perkara_id
            WHERE 
                p.prodeo = 0
                AND p.nomor_perkara LIKE '%$jenis_perkara%'
                AND YEAR(p.tanggal_pendaftaran)='$lap_tahun'
            GROUP BY 
                MONTH(p.tanggal_pendaftaran)
            ORDER BY 
                MONTH(p.tanggal_pendaftaran)";

        $query = $this->db->query($sql);
        return $query->result();
    }
}
