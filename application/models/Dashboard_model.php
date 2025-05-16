<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get count of cases received in a specific year
     * 
     * @param int $year The year to get data for
     * @return int Number of cases received
     */
    public function get_perkara_diterima($year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        $this->db->where('YEAR(tanggal_pendaftaran)', $year);
        $query = $this->db->get('perkara');
        return $query->num_rows();
    }

    /**
     * Get count of cases decided in a specific year
     * 
     * @param int $year The year to get data for
     * @return int Number of cases decided
     */
    public function get_perkara_putus($year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        $this->db->where('YEAR(tanggal_putusan)', $year);
        $query = $this->db->get('perkara_putusan');
        return $query->num_rows();
    }

    /**
     * Get count of cases minutasi in a specific year
     * 
     * @param int $year The year to get data for
     * @return int Number of cases minutasi
     */
    public function get_perkara_minutasi($year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        $this->db->where('YEAR(tanggal_minutasi)', $year);
        $query = $this->db->get('perkara_putusan');
        return $query->num_rows();
    }

    /**
     * Get count of remaining cases (registered but not decided)
     * 
     * @param int $year The year to get data for
     * @return int Number of remaining cases
     */
    public function get_perkara_sisa($year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        $this->db->select('perkara.perkara_id');
        $this->db->from('perkara');
        $this->db->join('perkara_putusan', 'perkara.perkara_id = perkara_putusan.perkara_id', 'left');
        $this->db->where('YEAR(perkara.tanggal_pendaftaran)', $year);
        $this->db->where('perkara_putusan.tanggal_putusan IS NULL');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Get monthly statistics for cases in a specific year
     * 
     * @param int $year The year to get data for
     * @return array Monthly data for charts
     */
    public function get_monthly_stats($year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        $monthly_data = array(
            'received' => array_fill(0, 12, 0),
            'decided' => array_fill(0, 12, 0),
            'minutasi' => array_fill(0, 12, 0)
        );

        // Get monthly received cases
        $query = $this->db->query(
            "SELECT MONTH(tanggal_pendaftaran) as month, COUNT(*) as count 
             FROM perkara 
             WHERE YEAR(tanggal_pendaftaran) = ? 
             GROUP BY MONTH(tanggal_pendaftaran)",
            array($year)
        );

        foreach ($query->result() as $row) {
            $monthly_data['received'][$row->month - 1] = (int)$row->count;
        }

        // Get monthly decided cases
        $query = $this->db->query(
            "SELECT MONTH(tanggal_putusan) as month, COUNT(*) as count 
             FROM perkara_putusan 
             WHERE YEAR(tanggal_putusan) = ? 
             GROUP BY MONTH(tanggal_putusan)",
            array($year)
        );

        foreach ($query->result() as $row) {
            $monthly_data['decided'][$row->month - 1] = (int)$row->count;
        }

        // Get monthly minutasi cases
        $query = $this->db->query(
            "SELECT MONTH(tanggal_minutasi) as month, COUNT(*) as count 
             FROM perkara_putusan 
             WHERE YEAR(tanggal_minutasi) = ? 
             GROUP BY MONTH(tanggal_minutasi)",
            array($year)
        );

        foreach ($query->result() as $row) {
            $monthly_data['minutasi'][$row->month - 1] = (int)$row->count;
        }

        return $monthly_data;
    }

    /**
     * Get case type distribution statistics
     * 
     * @param int $year The year to get data for
     * @return array Case type distribution data
     */
    public function get_case_type_stats($year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        $this->db->select('jenis_perkara_nama, COUNT(*) as count');
        $this->db->from('perkara');
        $this->db->where('YEAR(tanggal_pendaftaran)', $year);
        $this->db->group_by('jenis_perkara_nama');
        $this->db->order_by('count', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();

        return $query->result();
    }
}
