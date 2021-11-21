<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	// fungsi yang pertama kali dijalankan
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_tb_user');
	}

	public function index()
	{
		// cek apakah ada datanya tabel user
		$jml_data = $this->M_tb_user->cek_data();

		if ($jml_data==0) {
			redirect('login/daftar_user');
		}else{
			$this->load->view('bagian-admin/admin/part/header');
			$this->load->view('bagian-admin/admin/dashboard');
			$this->load->view('bagian-admin/admin/part/footer');
		}
	}
}
