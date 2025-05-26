<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Notifications');
    }

    public function index()
    {
        $data['title'] = 'Semua Notifikasi';
        $data['perkara_putus_today'] = $this->M_Notifications->getPerkaraToday();

        // Load view
        $this->render('v_notifikasi', $data);
    }
}
