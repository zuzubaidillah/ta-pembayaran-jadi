<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tb_user extends CI_Model {

  public $tabel = "tb_user";

	public function cek_data()
	{
    $tabel = $this->tabel;
    $query = $this->db->query("SELECT * FROM $tabel");
    // mengetahui jml data
    $hasil = $query->num_rows();
    return $hasil;
	}

  public function tambah($data)
  {
    $tabel = $this->tabel;
    $query = $this->db->insert("$tabel", $data);

    // cek apakah berhasil?
    if ($query==true) {
      $hasil = 1;
    }else{
      $hasil = 0;
    }
    return $hasil;
  }

	public function cek_email($e)
	{
    $tabel = $this->tabel;
    $query = $this->db->query("SELECT * FROM $tabel WHERE email='$e'");
    // mengetahui jml data
    $hasil = $query->num_rows();
    if ($hasil==0) {
      $hasil = [
        "jumlah" => 0,
        "data" => null
      ];
    }else{
      $hasil = [
        "jumlah" => $hasil,
        "data" => $query->row()
      ];
    }
    return $hasil;
	}

	public function cek_password($e,$p)
	{
    $tabel = $this->tabel;
    $query = $this->db->query("SELECT * FROM $tabel WHERE email='$e' AND password='$p'");
    // mengetahui jml data
    $hasil = $query->num_rows();
    if ($hasil==0) {
      $hasil = [
        "jumlah" => 0,
        "data" => null
      ];
    }else{
      $hasil = [
        "jumlah" => $hasil,
        "data" => $query->row()
      ];
    }
    return $hasil;
	}
}