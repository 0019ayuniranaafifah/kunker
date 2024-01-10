<?php
namespace App\Controllers;
use CodeIgniter\Config\Services;
use App\Models\Databasemodel;
class Operator extends BaseController{
	function __construct(){
		$this->mod = new Databasemodel();
		$this->db = db_connect();
	}

	public function index(){
		if(session()->get('p')){
			return redirect()->to(base_url('p'));
		}else if(session()->get('b')){
			return redirect()->to(base_url('b'));
		}else if(session()->get('o')){
			return view('operator/landing');
		}else{
			return redirect()->to(base_url(''));
		}
	}

	public function tampilprofil(){
		$data['data'] = $this->mod->getData('pengguna',['idpengguna' => session()->get('o')]);
		return view('operator/profil',$data);
	}

	public function ubahprofil(){
		$get = $this->request->getPost();
		$input = array(
			'nama' => $get['nama'],
			'username' => $get['username']
		);
		$this->mod->updating('pengguna',$input,['idpengguna' => session()->get('o')]);
		return redirect()->to(base_url('o/profil'));
	}

	public function tampilakses(){
		return view('operator/akses');
	}

	public function ubahakses(){
		$get = $this->request->getPost();
		$p1 = $get['p1'];
		$p2 = $get['p2'];
		$p3 = $get['p3'];
		$cek = $this->db->query("select ifnull(count(*),0) as jumlah from pengguna where password = '".md5($p1)."' and idpengguna = '".session()->get('o')."'")->getRowArray()['jumlah'];
		if($cek > 0){
			if($p2 == $p3){
				$this->mod->updating('pengguna',['password' => md5($p3)],['idpengguna' => session()->get('o')]);
			}
		}
		return redirect()->to(base_url('o/akses'));
	}
}
?>