<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyerahan_ac extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('M_Penyerahan_ac');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('form');
        
        // Hapus pengecekan login
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('login');
        // }
    }

    public function index() {
        // Set pagination config
        $config['base_url'] = site_url('penyerahan_ac/index');
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        
        // Get search parameters
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        
        // Count total records
        $config['total_rows'] = $this->M_Penyerahan_ac->count_all_akta_cerai($search, $status, $date_from, $date_to);
        
        // Initialize pagination
        $this->pagination->initialize($config);
        
        // Get current page
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // Get data
        $data['akta_cerai'] = $this->M_Penyerahan_ac->get_all_akta_cerai(
            $config['per_page'], 
            $page, 
            $search, 
            $status, 
            $date_from, 
            $date_to
        );
        
        // Pagination links
        $data['pagination'] = $this->pagination->create_links();
        
        // Search parameters for view
        $data['search'] = $search;
        $data['status'] = $status;
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        
        // Add statistics for dashboard cards
        $data['total_akta_cerai'] = $this->M_Penyerahan_ac->count_all_akta_cerai(null, null, null, null);
        $data['total_diserahkan'] = $this->M_Penyerahan_ac->count_all_akta_cerai(null, 'sudah_diserahkan_semua', null, null);
        $data['total_belum_diserahkan'] = $this->M_Penyerahan_ac->count_all_akta_cerai(null, 'belum_diserahkan', null, null);
        
        // Load view - FIXED PATH HERE
        $this->load->view('template/new_header');
        $this->load->view('template/new_sidebar');
        $this->load->view('v_penyerahan_ac', $data);
        $this->load->view('template/new_footer');
    }
    
    public function detail($perkara_id) {
        $data['detail'] = $this->M_Penyerahan_ac->get_detail_akta_cerai($perkara_id);
        
        if (!$data['detail']) {
            show_404();
        }
        
        $this->load->view('templates/header');
        $this->load->view('v_detail_penyerahan_ac', $data);
        $this->load->view('templates/footer');
    }
    
    public function update_pihak1($perkara_id) {
        // Update penyerahan for pihak1
        $result = $this->M_Penyerahan_ac->update_penyerahan_pihak1($perkara_id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Penyerahan akta cerai kepada Pihak 1 berhasil dicatat');
        } else {
            $this->session->set_flashdata('error', 'Gagal mencatat penyerahan akta cerai');
        }
        
        redirect('penyerahan_ac/detail/' . $perkara_id);
    }
    
    public function update_pihak2($perkara_id) {
        // Update penyerahan for pihak2
        $result = $this->M_Penyerahan_ac->update_penyerahan_pihak2($perkara_id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Penyerahan akta cerai kepada Pihak 2 berhasil dicatat');
        } else {
            $this->session->set_flashdata('error', 'Gagal mencatat penyerahan akta cerai');
        }
        
        redirect('penyerahan_ac/detail/' . $perkara_id);
    }
    
    public function print_receipt($perkara_id) {
        $data['detail'] = $this->M_Penyerahan_ac->get_detail_akta_cerai($perkara_id);
        
        if (!$data['detail']) {
            show_404();
        }
        
        $this->load->view('v_print_receipt_ac', $data);
    }
}
