<?php
namespace App\Controllers;
use CodeIgniter\Config\Services;
use App\Models\Databasemodel;
class Verifikasi extends BaseController{
	function __construct(){
		$this->mod = new Databasemodel();
		$this->db = db_connect();
	}

	public function index(){
		if(session()->get('p')){
			$data['data'] = $this->mod->getAll('pengajuan');
			return view('pimpinan/pengajuan',$data);
		}else if(session()->get('b')){
			return redirect()->to(base_url('b'));
		}else if(session()->get('o')){
			return redirect()->to(base_url('o'));
		}else{
			return redirect()->to(base_url(''));
		}
	}

	public function detail($x){
		$data['data'] = $this->mod->getData('pengajuan',['idpengajuan' => $x]);
		$data['agenda'] = $this->mod->getSome('agenda',['idpengajuan' => $x]);
		$data['biaya'] = $this->mod->getSome('biaya',['idpengajuan' => $x]);
		$data['dasar'] = $this->mod->getSome('dasar',['idpengajuan' => $x]);
		$data['utusan'] = $this->mod->getSome('utusan',['idpengajuan' => $x]);
		$data['keterangan'] = $this->mod->getSome('keterangan',['idpengajuan' => $x]);
		$data['pengikut'] = $this->mod->getSome('pengikut',['idpengajuan' => $x]);
		return view('pimpinan/pengajuandetail',$data);
	}

	public function sesuai(){
		$get = $this->request->getPost();
		$p = $this->mod->getData('pegawai',['idpegawai' => $get['pegawai']]);
		$this->mod->updating('pengajuan',['status' => '2'],['idpengajuan' => $get['id']]);
		$data = array(
			'idacc' => null,
			'waktu' => date('Y-m-d H:i:s'),
			'tanggal' => date('Y-m-d'),
			'pangkat' => $p['pangkat'],
			'idpegawai' => $get['pegawai'],
			'idpengajuan' => $get['id']
		);
		$this->mod->inserting('acc',$data);
		return redirect()->to(base_url('p/verifikasi/d/'.$get['id']));
	}

	public function tidaksesuai(){
		$get = $this->request->getPost();
		$input = array(
			'catatan' => $get['catatan'],
			'status' => '1'
		);
		$this->mod->updating('pengajuan',$input,['idpengajuan' => $get['id']]);
		return redirect()->to(base_url('p/verifikasi'));
	}
}
?>