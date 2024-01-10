<?php
namespace App\Controllers;
use CodeIgniter\Config\Services;
use App\Models\Databasemodel;
class Pengajuan extends BaseController{
	function __construct(){
		$this->mod = new Databasemodel();
		$this->db = db_connect();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		if(session()->get('p')){
			return redirect()->to(base_url('p'));
		}else if(session()->get('b')){
			return redirect()->to(base_url('b'));
		}else if(session()->get('o')){
			$data['data'] = $this->mod->getAll('pengajuan');
			return view('operator/pengajuan',$data);
		}else{
			return redirect()->to(base_url(''));
		}
	}

	public function baru(){
		$data['dasar'] = [];
		$data['utusan'] = [];
		$data['agenda'] = [];
		$data['keterangan'] = [];
		$data['biaya'] = [];
		$data['pengikut'] = [];
		$data['aktif'] = 'dasar';
		return view('operator/pengajuanbaru',$data);
	}

	public function tambahdasar(){
		$get = $this->request->getPost();
		$input = unserialize($get['dasar']);
		array_push($input, $get['isi']);
		$data['dasar'] = $input;
		$data['utusan'] = unserialize($get['utusan']);
		$data['agenda'] = unserialize($get['agenda']);
		$data['keterangan'] = unserialize($get['keterangan']);
		$data['biaya'] = unserialize($get['biaya']);
		$data['pengikut'] = unserialize($get['pengikut']);
		$data['aktif'] = 'dasar';
		return view('operator/pengajuanbaru',$data);
	}

	public function tambahutusan(){
		$get = $this->request->getPost();
		$input = unserialize($get['utusan']);
		$jabatan = $this->mod->getData('pegawai',['idpegawai' => $get['pegawai']])['jabatan'];
		$isi = array(
			'jabatan' => $jabatan,
			'keterangan' => $get['isi'],
			'pegawai' => $get['pegawai']
		);
		array_push($input, $isi);
		$data['dasar'] = unserialize($get['dasar']);
		$data['utusan'] = $input;
		$data['agenda'] = unserialize($get['agenda']);
		$data['keterangan'] = unserialize($get['keterangan']);
		$data['biaya'] = unserialize($get['biaya']);
		$data['pengikut'] = unserialize($get['pengikut']);
		$data['aktif'] = 'utusan';
		return view('operator/pengajuanbaru',$data);
	}

	public function tambahagenda(){
		$get = $this->request->getPost();
		$input = unserialize($get['agenda']);
		$isi = array(
			'waktu' => date('Y-m-d', strtotime($get['tanggal'])).' '.date('H:i', strtotime($get['jam'])),
			'acara' => $get['acara']
		);
		array_push($input, $isi);
		$data['dasar'] = unserialize($get['dasar']);
		$data['utusan'] = unserialize($get['utusan']);
		$data['agenda'] = $input;
		$data['keterangan'] = unserialize($get['keterangan']);
		$data['biaya'] = unserialize($get['biaya']);
		$data['pengikut'] = unserialize($get['pengikut']);
		$data['aktif'] = 'agenda';
		return view('operator/pengajuanbaru',$data);
	}

	public function tambahketerangan(){
		$get = $this->request->getPost();
		$input = unserialize($get['keterangan']);
		array_push($input, $get['isi']);
		$data['dasar'] = unserialize($get['dasar']);
		$data['utusan'] = unserialize($get['utusan']);
		$data['agenda'] = unserialize($get['agenda']);
		$data['keterangan'] = $input;
		$data['biaya'] = unserialize($get['biaya']);
		$data['pengikut'] = unserialize($get['pengikut']);
		$data['aktif'] = 'keterangan';
		return view('operator/pengajuanbaru',$data);
	}

	public function tambahpengikut(){
		$get = $this->request->getPost();
		$input = unserialize($get['pengikut']);
		$isi = array(
			'nama' => $get['nama'],
			'tanggal' => date('Y-m-d', strtotime($get['tanggal'])),
			'keterangan' => $get['isi']
		);
		array_push($input, $isi);
		$data['dasar'] = unserialize($get['dasar']);
		$data['utusan'] = unserialize($get['utusan']);
		$data['agenda'] = unserialize($get['agenda']);
		$data['keterangan'] = unserialize($get['keterangan']);
		$data['biaya'] = unserialize($get['biaya']);
		$data['pengikut'] = $input;
		$data['aktif'] = 'pengikut';
		return view('operator/pengajuanbaru',$data);
	}

	public function tambahbiaya(){
		$get = $this->request->getPost();
		$input = unserialize($get['biaya']);
		$isi = array(
			'jenis' => $get['jenis'],
			'rincian' => $get['isi'],
			'jumlah' => $get['jumlah']
		);
		array_push($input, $isi);
		$data['dasar'] = unserialize($get['dasar']);
		$data['utusan'] = unserialize($get['utusan']);
		$data['agenda'] = unserialize($get['agenda']);
		$data['keterangan'] = unserialize($get['keterangan']);
		$data['biaya'] = $input;
		$data['pengikut'] = unserialize($get['pengikut']);
		$data['aktif'] = 'biaya';
		return view('operator/pengajuanbaru',$data);
	}

	public function hapusdasar($a,$x){
		$a = unserialize(base64_decode($a));
		array_splice($a['dasar'], $x, 1);
		$data['dasar'] = $a['dasar'];
		$data['utusan'] = $a['utusan'];
		$data['agenda'] = $a['agenda'];
		$data['keterangan'] = $a['keterangan'];
		$data['biaya'] = $a['biaya'];
		$data['pengikut'] = $a['pengikut'];
		$data['aktif'] = 'dasar';
		return view('operator/pengajuanbaru',$data);
	}

	public function hapusutusan($a,$x){
		$a = unserialize(base64_decode($a));
		array_splice($a['utusan'], $x, 1);
		$data['dasar'] = $a['dasar'];
		$data['utusan'] = $a['utusan'];
		$data['agenda'] = $a['agenda'];
		$data['keterangan'] = $a['keterangan'];
		$data['biaya'] = $a['biaya'];
		$data['pengikut'] = $a['pengikut'];
		$data['aktif'] = 'utusan';
		return view('operator/pengajuanbaru',$data);
	}

	public function hapusagenda($a,$x){
		$a = unserialize(base64_decode($a));
		array_splice($a['agenda'], $x, 1);
		$data['dasar'] = $a['dasar'];
		$data['utusan'] = $a['utusan'];
		$data['agenda'] = $a['agenda'];
		$data['keterangan'] = $a['keterangan'];
		$data['biaya'] = $a['biaya'];
		$data['pengikut'] = $a['pengikut'];
		$data['aktif'] = 'agenda';
		return view('operator/pengajuanbaru',$data);
	}

	public function hapusketerangan($a,$x){
		$a = unserialize(base64_decode($a));
		array_splice($a['keterangan'], $x, 1);
		$data['dasar'] = $a['dasar'];
		$data['utusan'] = $a['utusan'];
		$data['agenda'] = $a['agenda'];
		$data['keterangan'] = $a['keterangan'];
		$data['biaya'] = $a['biaya'];
		$data['pengikut'] = $a['pengikut'];
		$data['aktif'] = 'keterangan';
		return view('operator/pengajuanbaru',$data);
	}

	public function hapuspengikut($a,$x){
		$a = unserialize(base64_decode($a));
		array_splice($a['pengikut'], $x, 1);
		$data['dasar'] = $a['dasar'];
		$data['utusan'] = $a['utusan'];
		$data['agenda'] = $a['agenda'];
		$data['keterangan'] = $a['keterangan'];
		$data['biaya'] = $a['biaya'];
		$data['pengikut'] = $a['pengikut'];
		$data['aktif'] = 'pengikut';
		return view('operator/pengajuanbaru',$data);
	}

	public function hapusbiaya($a,$x){
		$a = unserialize(base64_decode($a));
		array_splice($a['biaya'], $x, 1);
		$data['dasar'] = $a['dasar'];
		$data['utusan'] = $a['utusan'];
		$data['agenda'] = $a['agenda'];
		$data['keterangan'] = $a['keterangan'];
		$data['biaya'] = $a['biaya'];
		$data['pengikut'] = $a['pengikut'];
		$data['aktif'] = 'biaya';
		return view('operator/pengajuanbaru',$data);
	}

	public function simpan(){
		$get = $this->request->getPost();
		$nomor = $get['indek'].'/'.$get['nomor'];
		$waktu = date('Y-m-d H:i:s');
		$dasar = unserialize($get['dasar']);
		$utusan = unserialize($get['utusan']);
		$agenda = unserialize($get['agenda']);
		$keterangan = unserialize($get['keterangan']);
		$biaya = unserialize($get['biaya']);
		$pengikut = unserialize($get['pengikut']);
		$input = array(
			'idpengajuan' => null,
			'waktu' => $waktu,
			'nomor' => $nomor,
			'tujuan' => $get['tujuan'],
			'tembusan' => $get['tembusan'],
			'angkutan' => $get['angkutan'],
			'anggaran' => $get['anggaran'],
			'keterangan' => $get['isi'],
			'catatan' => '',
			'status' => '0',
			'idpengguna' => session()->get('o')
		);
		$this->mod->inserting('pengajuan',$input);
		$id = $this->mod->getData('pengajuan',['waktu' => $waktu,'status' => '0','idpengguna' => session()->get('o')])['idpengajuan'];
		for ($i=0; $i < count($dasar); $i++) {
			$input = array(
				'iddasar' => null,
				'dasar' => $dasar[$i],
				'idpengajuan' => $id
			);
			$this->mod->inserting('dasar',$input);
		}
		for ($i=0; $i < count($utusan); $i++) {
			$input = array(
				'idutusan' => null,
				'jabatan' => $utusan[$i]['jabatan'],
				'keterangan' => $utusan[$i]['keterangan'],
				'idpegawai' => $utusan[$i]['pegawai'],
				'idpengajuan' => $id
			);
			$this->mod->inserting('utusan',$input);
		}
		for ($i=0; $i < count($agenda); $i++) {
			$input = array(
				'idagenda' => null,
				'waktu' => $agenda[$i]['waktu'].':00',
				'acara' => $agenda[$i]['acara'],
				'idpengajuan' => $id
			);
			$this->mod->inserting('agenda',$input);
		}
		for ($i=0; $i < count($keterangan); $i++) {
			$input = array(
				'idketerangan' => null,
				'keterangan' => $keterangan[$i],
				'idpengajuan' => $id
			);
			$this->mod->inserting('keterangan',$input);
		}
		for ($i=0; $i < count($biaya); $i++) {
			$input = array(
				'idbiaya' => null,
				'jenis' => $biaya[$i]['jenis'],
				'rincian' => $biaya[$i]['rincian'],
				'jumlah' => $biaya[$i]['jumlah'],
				'idpengajuan' => $id
			);
			$this->mod->inserting('biaya',$input);
		}
		for ($i=0; $i < count($pengikut); $i++) {
			$input = array(
				'idpengikut' => null,
				'nama' => $pengikut[$i]['nama'],
				'tanggal' => $pengikut[$i]['tanggal'],
				'keterangan' => $pengikut[$i]['keterangan'],
				'idpengajuan' => $id
			);
			$this->mod->inserting('pengikut',$input);
		}
		return redirect()->to(base_url('o/pengajuan/b'));
	}

	public function verifikasi(){
		$data['data'] = $this->mod->getAll('pengajuan');
		return view('operator/pengajuanverifikasi',$data);
	}

	public function detail($x){
		$data['pengajuan'] = $this->mod->getData('pengajuan',['idpengajuan' => $x]);
		$data['dasar'] = $this->mod->getSome('dasar',['idpengajuan' => $x]);
		$data['utusan'] = $this->mod->getSome('utusan',['idpengajuan' => $x]);
		$data['agenda'] = $this->mod->getSome('agenda',['idpengajuan' => $x]);
		$data['keterangan'] = $this->mod->getSome('keterangan',['idpengajuan' => $x]);
		$data['pengikut'] = $this->mod->getSome('pengikut',['idpengajuan' => $x]);
		$data['biaya'] = $this->mod->getSome('biaya',['idpengajuan' => $x]);
		$data['aktif'] = 'dasar';
		return view('operator/pengajuandetail',$data);
	}

	public function tambahdetaildasar(){
		$get = $this->request->getPost();
		$input = array(
			'iddasar' => null,
			'dasar' => $get['isi'],
			'idpengajuan' => $get['id']
		);
		$this->mod->inserting('dasar',$input);
		return redirect()->to(base_url('o/pengajuan/d/'.$get['id']));
	}

	public function tambahdetailutusan(){
		$get = $this->request->getPost();
		$jabatan = $this->mod->getData('pegawai',['idpegawai' => $get['pegawai']])['jabatan'];
		$input = array(
			'idutusan' => null,
			'jabatan' => $jabatan,
			'keterangan' => $get['isi'],
			'idpegawai' => $get['pegawai'],
			'idpengajuan' => $get['id']
		);
		$this->mod->inserting('utusan',$input);
		return redirect()->to(base_url('o/pengajuan/d/'.$get['id']));
	}

	public function tambahdetailagenda(){
		$get = $this->request->getPost();
		$input = array(
			'idagenda' => null,
			'waktu' => date('Y-m-d', strtotime($get['tanggal'])).' '.date('H:i', strtotime($get['jam'])),
			'acara' => $get['acara'],
			'idpengajuan' => $get['id']
		);
		$this->mod->inserting('agenda',$input);
		return redirect()->to(base_url('o/pengajuan/d/'.$get['id']));
	}

	public function tambahdetailketerangan(){
		$get = $this->request->getPost();
		$input = array(
			'idketerangan' => null,
			'keterangan' => $get['isi'],
			'idpengajuan' => $get['id']
		);
		$this->mod->inserting('keterangan',$input);
		return redirect()->to(base_url('o/pengajuan/d/'.$get['id']));
	}

	public function tambahdetailpengikut(){
		$get = $this->request->getPost();
		$input = array(
			'idpengikut' => null,
			'nama' => $get['nama'],
			'tanggal' => $get['tanggal'],
			'keterangan' => $get['isi'],
			'idpengajuan' => $get['id']
		);
		$this->mod->inserting('pengikut',$input);
		return redirect()->to(base_url('o/pengajuan/d/'.$get['id']));
	}

	public function tambahdetailbiaya(){
		$get = $this->request->getPost();
		$input = array(
			'idbiaya' => null,
			'jenis' => $get['jenis'],
			'rincian' => $get['isi'],
			'jumlah' => $get['jumlah'],
			'idpengajuan' => $get['id']
		);
		$this->mod->inserting('biaya',$input);
		return redirect()->to(base_url('o/pengajuan/d/'.$get['id']));
	}

	public function hapusdetaildasar($x){
		$id = $this->mod->getData('dasar',['iddasar' => $x])['idpengajuan'];
		$this->mod->deleting('dasar',['iddasar' => $x]);
		return redirect()->to(base_url('o/pengajuan/d/'.$id));
	}

	public function hapusdetailutusan($x){
		$id = $this->mod->getData('utusan',['idutusan' => $x])['idpengajuan'];
		$this->mod->deleting('utusan',['idutusan' => $x]);
		return redirect()->to(base_url('o/pengajuan/d/'.$id));
	}

	public function hapusdetailagenda($x){
		$id = $this->mod->getData('agenda',['idagenda' => $x])['idpengajuan'];
		$this->mod->deleting('agenda',['idagenda' => $x]);
		return redirect()->to(base_url('o/pengajuan/d/'.$id));
	}

	public function hapusdetailketerangan($x){
		$id = $this->mod->getData('keterangan',['idketerangan' => $x])['idpengajuan'];
		$this->mod->deleting('keterangan',['idketerangan' => $x]);
		return redirect()->to(base_url('o/pengajuan/d/'.$id));
	}
	
	public function hapusdetailpengikut($x){
		$id = $this->mod->getData('pengikut',['idpengikut' => $x])['idpengajuan'];
		$this->mod->deleting('pengikut',['idpengikut' => $x]);
		return redirect()->to(base_url('o/pengajuan/d/'.$id));
	}

	public function hapusdetailbiaya($x){
		$id = $this->mod->getData('biaya',['idbiaya' => $x])['idpengajuan'];
		$this->mod->deleting('biaya',['idbiaya' => $x]);
		return redirect()->to(base_url('o/pengajuan/d/'.$id));
	}

	public function ubah(){
		$get = $this->request->getPost();
		$status = $this->mod->getData('pengajuan',['idpengajuan' => $get['id']])['status'];
		if($status == '0' || $status == '1'){
			$status = '0';
		}else if($status == '2'){
			$status = '2';
		}
		$nomor = $get['indek'].'/'.$get['nomor'];
		$input = array(
			'nomor' => $nomor,
			'tujuan' => $get['tujuan'],
			'tembusan' => $get['tembusan'],
			'angkutan' => $get['angkutan'],
			'anggaran' => $get['anggaran'],
			'keterangan' => $get['isi'],
			'status' => $status
		);
		$this->mod->updating('pengajuan',$input,['idpengajuan' => $get['id']]);
		return redirect()->to(base_url('o/pengajuan/d/'.$get['id']));
	}

	public function acc($x){
		$this->mod->updating('pengajuan',['status' => '4'],['idpengajuan' => $x]);
		return redirect()->to(base_url('o/pengajuan/d/'.$x));
	}

	public function laporan(){
		$bulan = date('m');
		$tahun = date('Y');
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['data'] = $this->db->query("select * from pengajuan where month(waktu) = '".$bulan."' and year(waktu) = '".$tahun."' and status = '5' order by waktu asc")->getResultArray();
		return view('operator/pengajuanlaporan',$data);
	}

	public function tampillaporan(){
		$get = $this->request->getPost();
		$bulan = $get['bulan'];
		$tahun = $get['tahun'];
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['data'] = $this->db->query("select * from pengajuan where month(waktu) = '".$bulan."' and year(waktu) = '".$tahun."' and status = '5' order by waktu asc")->getResultArray();
		return view('operator/pengajuanlaporan',$data);
	}

	public function simpanlaporan(){
		$get = $this->request->getPost();
		$input = array(
			'idlaporan' => null,
			'waktu' => date('Y-m-d H:i:s'),
			'klien' => $get['klien'],
			'lokasi' => $get['lokasi'],
			'materi' => $get['materi'],
			'solusi' => $get['solusi'],
			'pic' => $get['pic'],
			'id' => $get['idpic'],
			'jabatan' => $get['jabatanpic'],
			'idagenda' => $get['id']
		);
		$this->mod->inserting('laporan',$input);
		return redirect()->to(base_url('o/laporan/l'));
	}	

	public function cetaklaporan($x){
		$x = "idpengajuan";
	}
}
?>