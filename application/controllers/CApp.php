<?php
defined('BASEPATH')OR exit('No direct script access ');

/**
 * 
 */
class CApp extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();

		//load base_url
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('V_Login');
	}
	public function CProsesLogin()
	{
		$pengguna=$this->input->post('nm_pengguna');
		$pass=$this->input->post('pass');
		$role='kasir';

		$hasil=$this->MApp->MProsesLogin($pengguna,$pass,$role);
		if ($hasil== false) {
			$this->session->set_flashdata('error_login',true);
			redirect('CApp');
		}
		 $hasil2 = array (
			'username'=> $hasil ['username'],
			'nm_user'=> $hasil ['nm_user'],
			'id_user'=> $hasil ['id_user'],
			'id_outlet'=> $hasil ['id_outlet'],
		);
		$this->session->set_userdata($hasil2);
		//this->session->set_flashdata('id_outlet', $hasil2['id_outlet']);

		$this->session->set_flashdata('status', 'selamat datang :' .$hasil2['username']);
		redirect('CApp/CTampilMember');
	}

	public function CTampilMember()
	{
		$id_user= $this->session->userdata('id_user');
		$data=$this->MApp->MTampilMember($id_user);
		$this->load->view('V_Home',['data'=> $data]);
	}

	public function CTambahMember()
	{
		$this->load->view('VTambahMember');
	}
	public function CProsesTambahMember()
	{
		$id_user=$this->session->userdata('id_user');
		$nm_member=$this->input->post('nm_member');
		$tlp_member=$this->input->post('tlp_member');
		$alamat_member=$this->input->post('alamat_member');

		$hasil=$this->MApp->MProsesTambahMember($nm_member, $tlp_member, $alamat_member, $id_user);

		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Berhasil Menambahkan');
		}else{
			$this->session->set_flashdata('status', 'Gagal Menambahkan');
		}
		redirect('CApp/CTampilMember');
	}
	public function CLogout()
	{
		$this->session->unset_userdata('username');
		redirect('CApp');
	}
	public function CHapusMember($id)
	{
		// $this->App_model->MHapusMember($id);
		// redirect('App_controler/CTampilMember');

		$this->MApp->MHapusMember($id);
		redirect('CApp/CTampilMember');
	}
	public function CEditMember($id_member)
	{ 
		$data=$this->MApp->MEditMember($id_member);
		$this->load->view('V_EditMember',['data' => $data]);
	}
	public function CProsesEditMember($id_member)
	{
		$id = $id_member;
		$nm_member=$this->input->post('nm_member');
		$tlp_member = $this->input->post('tlp_member');
		$alamat_member = $this->input->post('alamat_member');

		$hasil=$this->MApp->MProsesEditMember($nm_member, $tlp_member, $alamat_member, $id);

			if ($hasil == true) {
				$this->session->set_flashdata('status', 'Berhasil Mengedit Member');
			}else {
				$this->session->set_flashdata('status', 'Gagal Mengedit Member');
			}
			redirect('CApp/CTampilMember');
	}
	public function CTampilService()
	{
		$ambil_jenis=$this->MApp->MAmbilJenis();
		$id_outlet  =$this->session->userdata('id_outlet');

			foreach ($ambil_jenis as $j ) {
				if ($j['jenis_paket'] == 'paketan') {
					$paketan  = $this->MApp->MTampilPaket('paketan', $id_outlet);
					$paketan2 = $this->load->view('VServicePaket',['data' => $paketan], true);
				}elseif ($j['jenis_paket'] == 'standar') {
					$standar  = $this->MApp->MTampilPaket('standar', $id_outlet);
					$standar2=  $this->load->view('VServiceStandar',['data' => $standar], true);
				}
			}
			$this->load->view('VService',['standar' => $standar2, 'paketan' => $paketan2]);

	}
	public function CMasukKeranjang($id)
	{
		
		$id_paket = $id;
		$id_user = $this->session->userdata('id_user');
		$qty = $this->input->post('kuantitas');


		$hasil = $this->MApp->MMasukKeranjang($qty, $id_paket, $id_user);
		if ($hasil == true) {
			$this->session->set_flashdata('status', 'Berhasil Masuk Keranjang ');

		}else {
			$this->session->set_flashdata('status', 'Gagal Masuk Keranjang');
		}
		redirect('CApp/CTampilService');
	}

		public function CTampilKeranjang()
	{
		$data = $this->MApp->MTampilKeranjang($this->session->userdata('id_user'));
		$this->load->view('VKeranjang', ['data' => $data]);
	}

	// public function CHapusKeranjang($id_detail_transaksi)
	// {
	// 	$this->App_model->MHapusKeranjang($id_detail_transaksi);
	// 	redirect('App_controler/CTampilKeranjang');
	// }


	public function CProsesKeranjang()
	{
		$total_harga = $this->input->post('total_bayar');
		$id_member = $this->input->post('id_member');
		$biaya_tambahan = $this->input->post('biaya_tambahan');
		$pajak = $this->input->post('pajak');
		$diskon = $this->input->post('diskon');
		$keterangan = $this->input->post('keterangan');
		$batas_waktu = $this->input->post('batas_waktu');

		$id_user = $this->session->userdata('id_user');
		$id_outlet = $this->session->userdata('id_outlet');
		
		$hasil = $this->MApp->MProsesKeranjang($id_member, $biaya_tambahan, $pajak, $diskon, $id_user, $id_outlet, $batas_waktu, $total_harga);
		$hasil2 = $this->MApp->MUpdateKeranjang($id_user, $keterangan, $id_member);
		
		$invoice = $this->MApp->MAmbilDataTransaksi($id_member);
		$invoice2 = array(
			'kode_invoice' => $invoice['kode_invoice']
			);

		$updateStatus = $this->MApp->MUpdateStatus($invoice2['kode_invoice']);

		//mengecek klo berhasil checkout atau tidak
		if ($hasil == true) {
			$this->session->set_userdata($invoice2);
			$this->session->set_flashdata('status', 'Berhasil Checkout, dengan Kode Invoice : '.$invoice2['kode_invoice']);

		}else {
			$this->session->set_flashdata('status', 'Gagal Checkout');
		}
		redirect('CApp/CTampilKeranjang');
	}


	public function MUpdateKeranjang($id_user, $keterangan, $id_member)
	{
		$sql = $this->db->get_where('tb_transaksi', [
			'id_member' => $id_member,
			'status_transaksi' => 'baru'
			])->row_array();

		$dikeranjang = 'dikeranjang';
		$array = array('id_user' => $id_user, 'status_detail' => $dikeranjang);
		$this->db->where($array);
		return $hasil = $this->db->update('tb_detail_transaksi',[
			'id_transaksi' => $sql['id_transaksi'],
			'keterangan' => $keterangan,
			'status_detail' => 'ditransaksi'
		]) > 0;
	}


	public function MAmbilDataTransaksi($id_member)
	{
		
		return $sql = $this->db->get_where('tb_transaksi', [
			'id_member' => $id_member,
			'status_transaksi' => 'baru'
			])->row_array();
		
	}

	public function MUpdateStatus($kode_invoice)
	{
		$array = array('kode_invoice' => $kode_invoice, 'status_transaksi' => 'baru' );
		$this->db->where($array);
		return $hasil = $this->db->update('tb_transaksi',[
			'status_transaksi' => 'proses'
			]) > 0;
	}




}
