<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Penyerahan_ac extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all akta cerai data with pagination
     * 
     * @param int $limit Number of records per page
     * @param int $start Starting position
     * @param string $search Optional search term
     * @param string $status Optional status filter
     * @param string $date_from Optional start date
     * @param string $date_to Optional end date
     * @return array
     */
    public function get_all_akta_cerai($limit = NULL, $start = NULL, $search = NULL, $status = NULL, $date_from = NULL, $date_to = NULL) {
        $this->db->select('
            p.perkara_id,
            p.nomor_perkara,
            p.jenis_perkara_nama,
            ac.nomor_akta_cerai,
            ac.tgl_akta_cerai,
            ac.no_seri_akta_cerai,
            ac.tgl_penyerahan_akta_cerai,
            ac.tgl_penyerahan_akta_cerai_pihak2,
            p1.nama as nama_p1,
            p2.nama as nama_p2
        ');
        
        $this->db->from('perkara p');
        $this->db->join('perkara_akta_cerai ac', 'p.perkara_id = ac.perkara_id', 'inner');
        $this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'left');
        $this->db->join('pihak p1', 'pp1.pihak_id = p1.id', 'left');
        $this->db->join('perkara_pihak2 pp2', 'p.perkara_id = pp2.perkara_id', 'left');
        $this->db->join('pihak p2', 'pp2.pihak_id = p2.id', 'left');
        
        // Apply search filter if provided
        if ($search) {
            $this->db->group_start();
            $this->db->like('p.nomor_perkara', $search);
            $this->db->or_like('ac.nomor_akta_cerai', $search);
            $this->db->or_like('ac.no_seri_akta_cerai', $search);
            $this->db->or_like('p1.nama', $search);
            $this->db->or_like('p2.nama', $search);
            $this->db->group_end();
        }
        
        // Filter by delivery status
        if ($status == 'belum_diserahkan') {
            $this->db->where('ac.tgl_penyerahan_akta_cerai IS NULL');
        } else if ($status == 'sudah_diserahkan_pihak1') {
            $this->db->where('ac.tgl_penyerahan_akta_cerai IS NOT NULL');
            $this->db->where('ac.tgl_penyerahan_akta_cerai_pihak2 IS NULL');
        } else if ($status == 'sudah_diserahkan_semua') {
            $this->db->where('ac.tgl_penyerahan_akta_cerai IS NOT NULL');
            $this->db->where('ac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL');
        }
        
        // Filter by date range
        if ($date_from && $date_to) {
            $this->db->where('ac.tgl_akta_cerai >=', $date_from);
            $this->db->where('ac.tgl_akta_cerai <=', $date_to);
        }
        
        // Only get records with akta cerai
        $this->db->where('ac.nomor_akta_cerai IS NOT NULL');
        
        // Group by to avoid duplicates due to multiple pihak1/pihak2
        $this->db->group_by('p.perkara_id');
        
        // Order by newest akta cerai first
        $this->db->order_by('ac.tgl_akta_cerai', 'DESC');
        
        $this->db->limit($limit, $start);
        
        return $this->db->get()->result();
    }
    
    // Count total records for pagination
    public function count_all_akta_cerai($search = null, $status = null, $date_from = null, $date_to = null) {
        $this->db->select('COUNT(DISTINCT p.perkara_id) as total');
        $this->db->from('perkara p');
        $this->db->join('perkara_akta_cerai ac', 'p.perkara_id = ac.perkara_id', 'left');
        $this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'left');
        $this->db->join('perkara_pihak2 pp2', 'p.perkara_id = pp2.perkara_id', 'left');
        $this->db->join('pihak p1', 'pp1.pihak_id = p1.id', 'left');
        $this->db->join('pihak p2', 'pp2.pihak_id = p2.id', 'left');
        
        // Apply search filter if provided
        if ($search) {
            $this->db->group_start();
            $this->db->like('p.nomor_perkara', $search);
            $this->db->or_like('ac.nomor_akta_cerai', $search);
            $this->db->or_like('ac.no_seri_akta_cerai', $search);
            $this->db->or_like('p1.nama', $search);
            $this->db->or_like('p2.nama', $search);
            $this->db->group_end();
        }
        
        // Filter by delivery status
        if ($status == 'belum_diserahkan') {
            $this->db->where('ac.tgl_penyerahan_akta_cerai IS NULL');
        } else if ($status == 'sudah_diserahkan_pihak1') {
            $this->db->where('ac.tgl_penyerahan_akta_cerai IS NOT NULL');
            $this->db->where('ac.tgl_penyerahan_akta_cerai_pihak2 IS NULL');
        } else if ($status == 'sudah_diserahkan_semua') {
            $this->db->where('ac.tgl_penyerahan_akta_cerai IS NOT NULL');
            $this->db->where('ac.tgl_penyerahan_akta_cerai_pihak2 IS NOT NULL');
        }
        
        // Filter by date range
        if ($date_from && $date_to) {
            $this->db->where('ac.tgl_akta_cerai >=', $date_from);
            $this->db->where('ac.tgl_akta_cerai <=', $date_to);
        }
        
        // Only get records with akta cerai
        $this->db->where('ac.nomor_akta_cerai IS NOT NULL');
        
        $query = $this->db->get();
        return $query->row()->total;
    }
    
    // Update penyerahan akta cerai for pihak1
    public function update_penyerahan_pihak1($perkara_id) {
        $data = array(
            'tgl_penyerahan_akta_cerai' => date('Y-m-d'),
            'diperbaharui_oleh' => $this->session->userdata('username'),
            'diperbaharui_tanggal' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('perkara_id', $perkara_id);
        return $this->db->update('perkara_akta_cerai', $data);
    }
    
    // Update penyerahan akta cerai for pihak2
    public function update_penyerahan_pihak2($perkara_id) {
        $data = array(
            'tgl_penyerahan_akta_cerai_pihak2' => date('Y-m-d'),
            'diperbaharui_oleh' => $this->session->userdata('username'),
            'diperbaharui_tanggal' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('perkara_id', $perkara_id);
        return $this->db->update('perkara_akta_cerai', $data);
    }
    
    // Get detailed information for a specific akta cerai
    public function get_detail_akta_cerai($perkara_id) {
        $this->db->select('p.perkara_id, p.nomor_perkara, p.jenis_perkara_nama, 
                          pac.nomor_akta_cerai, pac.tgl_akta_cerai, pac.no_seri_akta_cerai, 
                          pac.tgl_penyerahan_akta_cerai, pac.tgl_penyerahan_akta_cerai_pihak2,
                          pp1.nama as nama_pihak1, pp1.alamat as alamat_pihak1,
                          pp2.nama as nama_pihak2, pp2.alamat as alamat_pihak2,
                          pit.tgl_ikrar_talak');
        $this->db->from('perkara p');
        $this->db->join('perkara_akta_cerai pac', 'p.perkara_id = pac.perkara_id', 'left');
        $this->db->join('perkara_pihak1 pp1', 'p.perkara_id = pp1.perkara_id', 'left');
        $this->db->join('perkara_pihak2 pp2', 'p.perkara_id = pp2.perkara_id', 'left');
        $this->db->join('perkara_ikrar_talak pit', 'p.perkara_id = pit.perkara_id', 'left');
        $this->db->where('p.perkara_id', $perkara_id);
        $this->db->limit(1);
        
        return $this->db->get()->row();
    }
}
