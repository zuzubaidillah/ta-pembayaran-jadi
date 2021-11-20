<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
			$this->load->view('login');
		}
	}
	
	public function daftar_user()
	{
		$this->load->view('daftar_user');
	}

	public function proses_daftar_user()
	{
		$password = $this->input->post('password');
		$email = $this->input->post('email');
		$nama = $this->input->post('nama');
		$jk = $this->input->post('jk');
		$no_telfon = $this->input->post('no_telfon');

		// pengelompokan data untuk disimpan
		$data_post = [
			"id_tb_user"=> mt_rand(11111,99999),
			"nama_user"=>$nama,
			"no_telfon"=>$no_telfon,
			"level"=>"admin",
			"password"=> password_hash($password, PASSWORD_DEFAULT),
			"email"=> $email,
			"jk"=>$jk
		];

		// simpan ke tabel user
		$hasil = $this->M_tb_user->tambah($data_post);
		// logika if
		if ($hasil==1) {
			// berhasil disimpan
			redirect("login?pesan=data-berhasil-disimpan");
		}else{
			// gagal disimpan
			redirect("login/daftar_user?pesan=data-gagal-disimpan");
		}
	}

	public function proses_login()
	{
		$password = $this->input->post('password');
		$email = $this->input->post('email');

		// cek jika request tidak ditemukan
		if ($email==null || $password==null) {
			// pindah ke halaman login lagi
			redirect("login?pesan=request-null-ulangi-lagi");
		}


		// cek email
		$hasil = $this->M_tb_user->cek_email($email);
		if ($hasil['jumlah']==0) {
			// pindah ke halaman login lagi
			redirect("login?pesan=email-salah");
		}
		// cek password
		if (password_verify($password, $hasil['data']->password)) {
			$nama_user = $hasil['data']->nama_user;
			$level = $hasil['data']->level;

			$data_session = [
				"ss_nama_user" => $nama_user,
				"ss_level" => $level,
				"ss_email" => $email,
			];

			$this->session->set_userdata($data_session);
			switch ($level) {
				case "admin":
					redirect("login?pesan=selamat-datang-admin");
					echo "Your favorite color is red!";
					break;
				case "kepala sekolah":
					echo "Your favorite color is blue!";
					break;
				default:
					echo "Your favorite color is neither red, blue, nor green!";
			}
		}else{
			// pindah ke halaman login lagi
			redirect("login?pesan=password-salah");
		}
	}
}
