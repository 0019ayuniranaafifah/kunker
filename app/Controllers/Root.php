<?php
namespace App\Controllers;
use CodeIgniter\Config\Services;
use App\Models\Databasemodel;
use App\Libraries\Fpdf\Fpdf;
class Root extends BaseController{
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
			return redirect()->to(base_url('o'));
		}else{
			session()->setFlashdata('gagal','');
			return view('landing');
		}
	}

	public function proseslogin(){
		$get = $this->request->getPost();
		$username = $get['username'];
		$password = $get['password'];
		$cek = $this->db->query("select ifnull(count(*),0) as jumlah from pengguna where username = '".$username."' and password = '".md5($password)."'")->getRowArray()['jumlah'];
		if($cek > 0){
			$cek = $this->mod->getData('pengguna',['username' => $username, 'password' => md5($password)]);
			if($cek['status'] == '0'){
				session()->setFlashdata('gagal','Akun tidak dapat diakses!');
				return view('landing');
			}else{
				session()->set($cek['level'],$cek['idpengguna']);
				return redirect()->to(base_url(''));
			}
		}else{
			session()->setFlashdata('gagal','Akun tidak ditemukan atau Kombinasi tidak sesuai!');
			return view('landing');
		}
	}

	public function proseslogout(){
		session_unset();
		session()->destroy();
		return redirect()->to(base_url(''));
	}

	public function cetaksuratpengajuan($x){
		$data = $this->mod->getData('pengajuan',['idpengajuan' => $x]);
		$dari = $this->db->query("select date(waktu) as tanggal from agenda where idpengajuan = '".$x."' order by waktu asc")->getRowArray()['tanggal'];
		$sampai = $this->db->query("select date(waktu) as tanggal from agenda where idpengajuan = '".$x."' order by waktu desc")->getRowArray()['tanggal'];
		$pejabat = "-";
		$utusan = $this->mod->getSome('utusan',['idpengajuan' => $x]);
		$agenda = $this->mod->getSome('agenda',['idpengajuan' => $x]);
		$pengikut = $this->mod->getSome('pengikut',['idpengajuan' => $x]);
		
		$tanggal_1 = date_create($dari);
		$tanggal_2 = date_create($sampai);
		$selisih  = date_diff( $tanggal_1, $tanggal_2 );		
		

		$this->pdf = new fpdf('P','mm','A4');
		$this->pdf->AddPage();
		$this->pdf->Image('../public/assets/gambar/logo.png',10,7,15);
		$this->pdf->SetLineWidth(1);
		$this->pdf->Line(10,28,198,28);
		$this->pdf->SetLineWidth(0);
		$this->pdf->SetFont('Arial','B',16);
		$this->pdf->Cell(10,6,'',0,0,'C');
		$this->pdf->Cell(180,6,'PEMERINTAH KABUPATEN BATANG',0,1,'C');
		$this->pdf->SetFont('Arial','B',14);
		$this->pdf->Cell(10,6,'',0,0,'C');
		$this->pdf->Cell(180,6,'SEKRETARIAT DEWAN PERWAKILAN RAKYAT DAERAH',0,1,'C');
		$this->pdf->SetFont('Arial','',9);
		$this->pdf->Cell(10,4,'',0,0,'C');
		$this->pdf->Cell(180,4,'Jl. Jend. Sudirman No. 262 Telp.(0285) 3991146 Fax.(0285) 391760 email. dprdbatang@gmail.com Batang 52125',0,1,'C');
		$this->pdf->Ln(5);

		$this->pdf->SetFont('Arial','BU',12);
		$this->pdf->Cell(190,4,'SURAT PENGAJUAN PERJALANAN DINAS',0,1,'C');
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(190,5,'Nomor : '.$data['nomor'],0,1,'C');
		$this->pdf->Ln(2);

		$this->pdf->Cell(9,7,'1.',1,0,'C');
		$this->pdf->Cell(81,7,'Pejabat yang memberikan perintah',1,0);
		$this->pdf->Cell(100,7,$pejabat,1,1);

		if(count($utusan) > 1){
			$this->pdf->Cell(9,7,'2.',1,0,'C');
			$this->pdf->Cell(81,7,'Nama staf yang diperintah',1,0);
			$this->pdf->Cell(100,7,'TERLAMPIR',1,1);
			$this->pdf->Cell(9,7,'3.',1,0,'C');
			$this->pdf->Cell(81,7,'Jabatan',1,0);
			$this->pdf->Cell(100,7,'TERLAMPIR',1,1);
		}else{
			$this->pdf->Cell(9,7,'2.',1,0,'C');
			$this->pdf->Cell(81,7,'Nama staf yang diperintah',1,0);
			foreach ($utusan as $u) {
				$s = $this->mod->getData('pegawai',['idpegawai' => $u['idpegawai']])['nama'];
				$this->pdf->Cell(100,7,$s,1,1);
			}
			$this->pdf->Cell(9,7,'3.',1,0,'C');
			$this->pdf->Cell(81,7,'Jabatan',1,0);
			foreach ($utusan as $u) {
				$this->pdf->Cell(100,7,$u['jabatan'],1,1);
			}
		}

		$x = ceil(strlen($data['tujuan'])/50);
		$this->pdf->Cell(9,7*$x,'4.',1,0,'C');
		$this->pdf->Cell(81,7*$x,'Maksud perjalanan',1,0);
		$this->pdf->MultiCell(100, 7, $data['tujuan'], 1, 'J');

		$x = ceil(strlen($data['angkutan'])/50);
		$this->pdf->Cell(9,7*$x,'5.',1,0,'C');
		$this->pdf->Cell(81,7*$x,'Angkutan yang dipergunakan',1,0);
		$this->pdf->MultiCell(100, 7, $data['angkutan'], 1, 'J');

		if(count($agenda) > 1){
			$this->pdf->Cell(9,7,'6.',1,0,'C');
			$this->pdf->Cell(81,7,'Tempat Tujuan',1,0);
			$this->pdf->Cell(100,7,'TERLAMPIR',1,1);
		}else{

		}

		$this->pdf->Cell(9,7,'7.',1,0,'C');
		$this->pdf->Cell(81,7,'Lama perjalanan',1,0);
		$this->pdf->Cell(100,7,$selisih->days.' hari',1,1);

		if(count($pengikut) > 1){
			$this->pdf->Cell(9,7,'8.',1,0,'C');
			$this->pdf->Cell(81,7,'Pengikut',1,0);
			$this->pdf->Cell(100,7,'TERLAMPIR',1,1);
		}else{

		}

		$x = ceil(strlen($data['anggaran'])/50);
		$this->pdf->Cell(9,7*$x,'9.',1,0,'C');
		$this->pdf->Cell(81,7*$x,'Pembebanan anggaran',1,0);
		$this->pdf->MultiCell(100, 7, $data['anggaran'], 1, 'J');


		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Cell(190,7,'PELAKSANAAN PERJALANAN DINAS',1,0,'C');

		$this->pdf->Output();
		exit;
	}
}
?>