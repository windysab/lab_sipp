<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    protected $data = array();

    public function __construct()
    {
        parent::__construct();

        // Load model notifikasi
        $this->load->model('M_Notifications');

        // Siapkan data notifikasi untuk header
        $this->data['notifikasi_perkara'] = $this->M_Notifications->getPerkaraToday();
        $this->data['jumlah_notifikasi'] = $this->M_Notifications->countPerkaraToday();
    }

    protected function render($content, $data = array())
    {
        // Gabungkan data notifikasi dengan data lainnya
        $view_data = array_merge($this->data, $data);

        $this->load->view('template/new_header', $view_data);
        $this->load->view('template/new_sidebar', $view_data);
        $this->load->view($content, $data);
        $this->load->view('template/new_footer');
    }
}
