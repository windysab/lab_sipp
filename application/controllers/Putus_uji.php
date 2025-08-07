<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Putus_uji extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_putus_uji");
    }

    public function index()
    {
        // Inisialisasi data kosong untuk tampilan awal
        $data['datafilter'] = array();
        
        // Cek apakah ada data POST (form sudah disubmit)
        if ($this->input->post('btn') == 'Tampilkan') {
            $jenis_perkara = $this->input->post('jenis_perkara');
            $lap_bulan = $this->input->post('lap_bulan');
            $lap_tahun = $this->input->post('lap_tahun');
            
            // Validasi input
            if (!empty($jenis_perkara) && !empty($lap_bulan) && !empty($lap_tahun)) {
                $data['datafilter'] = $this->M_putus_uji->putus($jenis_perkara, $lap_bulan, $lap_tahun);
            }
        } else {
            // Tampilkan data default untuk bulan dan tahun saat ini
            $current_month = date('m');
            $current_year = date('Y');
            $default_jenis = 'Pdt.G'; // Default jenis perkara
            
            // Ambil data default
            $data['datafilter'] = $this->M_putus_uji->putus($default_jenis, $current_month, $current_year);
        }
        
        // Load views
        $this->load->view('template/new_header');
        $this->load->view('template/new_sidebar');
        $this->load->view('v_putus_uji', $data);
        $this->load->view('template/new_footer');
    }
}
