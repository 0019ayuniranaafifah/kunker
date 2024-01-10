<?php
namespace App\Controllers;
use CodeIgniter\Config\Services;
use App\Models\Databasemodel;
class Pengguna extends BaseController{
	function __construct(){
		$this->mod = new Databasemodel();
		$this->db = db_connect();
	}

	public function index(){
		if(session()->get('p')){
			$data['data'] = $this->db->query("select * from pengguna where level not in ('p')")->getResultArray();
			return view('pimpinan/pengguna',$data);
		}else if(session()->get('b')){
			return redirect()->to(base_url('b'));
		}else if(session()->get('o')){
			return redirect()->to(base_url('o'));
		}else{
			return redirect()->to(base_url(''));
		}
	}

	public function buatusername($x){
		$username = '';
		$x = explode(" ", $x);
		$x = strtolower($x[0]);
		$ada = true;
		$n = 0;
		while ($ada) {
			$username = $x.$n;
			$cek = $this->db->query("select ifnull(count(*),0) as jumlah from pengguna where username = '".$username."'")->getRowArray()['jumlah'];
			if($cek == 0){
				$ada = false;
			}else{
				$n++;
			}
		}
		return $username;
	}

	public function simpan(){
		$get = $this->request->getPost();
		$input = array(
			'idpengguna' => null,
			'nama' => $get['nama'],
			'jekel' => $get['jekel'],
			'level' => $get['level'],
			'username' => $this->buatusername($get['nama']),
			'password' => md5(123456),
			'status' => '1'
		);
		$this->mod->inserting('pengguna',$input);
		return redirect()->to(base_url('p/pengguna'));
	}

	public function ubah(){
		$get = $this->request->getPost();
		$input = array(
			'level' => $get['level'],
			'status' => $get['status']
		);
		$this->mod->updating('pengguna',$input,['idpengguna' => $get['id']]);
		return redirect()->to(base_url('p/pengguna'));
	}

	public function detail($x){
		$data['data'] = $this->mod->getData('pengguna',['idpengguna' => $x]);
		return view('pimpinan/penggunadetail',$data);
	}

	public function hapus($x){
		$this->mod->deleting('pengguna',['idpengguna' => $x]);
		return redirect()->to(base_url('p/pengguna'));
	}
}
?>