<?php
namespace App\Models;
use CodeIgniter\Model;
class Databasemodel extends Model{
	public function getAll($tabel){
		return $this->db->table($tabel)->get()->getResultArray();
	}

	public function getSome($tabel, $kondisi){
		return $this->db->table($tabel)->where($kondisi)->get()->getResultArray();
	}

	public function getData($tabel, $kondisi){
		return $this->db->table($tabel)->where($kondisi)->get()->getRowArray();
	}

	public function inserting($tabel, $data){
		$this->db->table($tabel)->insert($data);
	}

	public function updating($tabel, $data, $kondisi){
		$this->db->table($tabel)->where($kondisi)->set($data)->update();
	}

	public function updateAll($tabel, $data){
		$this->db->table($tabel)->set($data)->update();
	}

	public function deleting($tabel, $kondisi){
		$this->db->table($tabel)->where($kondisi)->delete();
	}
}
?>