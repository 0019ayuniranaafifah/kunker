<?php
namespace App\Controllers;
use CodeIgniter\Config\Services;
use App\Models\Databasemodel;
class Pegawai extends BaseController{
	function __construct(){
		$this->mod = new Databasemodel();
		$this->db = db_connect();
	}

	public function index(){
		if(session()->get('p')){
			$data['data'] = $this->mod->getAll('pegawai');
			return view('pimpinan/pegawai',$data);
		}else if(session()->get('b')){
			return redirect()->to(base_url('b'));
		}else if(session()->get('o')){
			return redirect()->to(base_url('o'));
		}else{
			return redirect()->to(base_url(''));
		}
	}

	public function simpan(){
		$get = $this->request->getPost();
		$input = array(
			'idpegawai' => null,
			'nip' => $get['nip'],
			'nama' => $get['nama'],
			'jekel' => $get['jekel'],
			'alamat' => $get['alamat'],
			'pangkat' => $get['pangkat'],
			'golongan' => $get['golongan'],
			'jabatan' => $get['jabatan'],
			'status' => '1'
		);
		$this->mod->inserting('pegawai',$input);
		return redirect()->to(base_url('p/pegawai'));
	}

	public function ubah(){
		$get = $this->request->getPost();
		$input = array(
			'nip' => $get['nip'],
			'nama' => $get['nama'],
			'jekel' => $get['jekel'],
			'alamat' => $get['alamat'],
			'pangkat' => $get['pangkat'],
			'golongan' => $get['golongan'],
			'jabatan' => $get['jabatan'],
			'status' => $get['status']
		);
		$this->mod->updating('pegawai',$input,['idpegawai' => $get['id']]);
		return redirect()->to(base_url('p/pegawai'));
	}

	public function detail($x){
		$data['data'] = $this->mod->getData('pegawai',['idpegawai' => $x]);
		return view('pimpinan/pegawaidetail',$data);
	}

	public function hapus($x){
		$this->mod->deleting('pegawai',['idpegawai' => $x]);
		return redirect()->to(base_url('p/pegawai'));
	}
}
?>