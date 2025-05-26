<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Notifications extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Mendapatkan perkara yang diputus hari ini
     * 
     * @return array Data perkara yang sudah diputus hari ini
     */
    public function getPerkaraToday()
    {
        $today = date('Y-m-d');

        $this->db->select('p.perkara_id, p.nomor_perkara, p.jenis_perkara_nama, pp.tanggal_putusan, pp.status_putusan_nama');
        $this->db->from('perkara p');
        $this->db->join('perkara_putusan pp', 'p.perkara_id = pp.perkara_id');
        $this->db->where('DATE(pp.tanggal_putusan)', $today);
        $this->db->order_by('pp.tanggal_putusan', 'DESC');
        $this->db->limit(5);

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Menghitung jumlah perkara yang diputus hari ini
     * 
     * @return int Jumlah perkara
     */
    public function countPerkaraToday()
    {
        $today = date('Y-m-d');

        $this->db->from('perkara p');
        $this->db->join('perkara_putusan pp', 'p.perkara_id = pp.perkara_id');
        $this->db->where('DATE(pp.tanggal_putusan)', $today);

        return $this->db->count_all_results();
    }
}
