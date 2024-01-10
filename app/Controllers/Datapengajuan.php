<?php
namespace App\Controllers;
use CodeIgniter\Config\Services;
use App\Models\Databasemodel;
class Datapengajuan extends BaseController{
	function __construct(){
		$this->mod = new Databasemodel();
		$this->db = db_connect();
	}

	public function index(){
		if(session()->get('p')){
			return redirect()->to(base_url('p'));
		}else if(session()->get('b')){
			$data['data'] = $this->mod->getAll('pengajuan');
			return view('bendahara/pengajuan',$data);
		}else if(session()->get('o')){
			return redirect()->to(base_url('o'));
		}else{
			return redirect()->to(base_url(''));
		}
	}

	public function bayar(){
		$get = $this->request->getPost();
		$input = array(
			'idbayar' => null,
			'waktu' => date('Y-m-d H:i:s'),
			'jenis' => $get['jenis'],
			'jumlah' => $get['jumlah'],
			'penerima' => $get['penerima'],
			'keterangan' => $get['keterangan'],
			'idpengajuan' => $get['id'],
			'idpengguna' => session()->get('b')
		);
		$this->mod->inserting('bayar',$input);
		$this->cektotal($get['id']);
		return redirect()->to(base_url('b/pengajuan'));
	}

	public function cektotal($x){
		$t = $this->db->query("select sum(jumlah) as total from biaya where idpengajuan = '".$x."'")->getRowArray()['total'];
		$b = $this->db->query("select sum(jumlah) as total from bayar where idpengajuan = '".$x."'")->getRowArray()['total'];
		if($t == $b){
			$this->mod->updating('pengajuan',['status' => '5'],['idpengajuan' => $x]);
		}
	}

	public function laporan(){
		$bulan = date('m');
		$tahun = date('Y');
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['data'] = $this->db->query("select * from bayar where month(waktu) = '".$bulan."' and year(waktu) = '".$tahun."' order by waktu asc")->getResultArray();
		return view('bendahara/pengajuanlaporan',$data);
	}

	public function tampillaporan(){
		$get = $this->request->getPost();
		$bulan = $get['bulan'];
		$tahun = $get['tahun'];
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['data'] = $this->db->query("select * from bayar where month(waktu) = '".$bulan."' and year(waktu) = '".$tahun."' order by waktu asc")->getResultArray();
		return view('bendahara/pengajuanlaporan',$data);
	}

	public function cetaklaporan($x){
		$x = explode("_", $x);
		$bulan = $x[0];
		$tahun = $x[1];
	}
}
?>