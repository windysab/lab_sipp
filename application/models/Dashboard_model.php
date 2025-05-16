<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get count of cases received in a specific year
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
     * Get monthly statistics
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

        // You can fill in real data here from your database

        return $monthly_data;
    }

    /**
     * Get case type distribution
     */
    public function get_case_type_stats($year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        // Return empty array for now - customize as needed
        return array();
    }
}
