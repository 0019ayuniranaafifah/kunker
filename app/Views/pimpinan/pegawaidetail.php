<?php
$db = db_connect();
$pangkat = $db->query("select pangkat from pegawai group by pangkat asc")->getResultArray();
$golongan = $db->query("select golongan from pegawai group by golongan asc")->getResultArray();
$jabatan = $db->query("select jabatan from pegawai group by jabatan asc")->getResultArray();
?>
<!DOCTYPE html>
<html lang="en">
<?php echo view('pimpinan/ahead') ?>
<body>
	<?php echo view('pimpinan/aheader') ?>
	<?php echo view('pimpinan/aaside') ?>
	<main id="main" class="main">
		<div class="pagetitle">
			<h1>Master Pegawai</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('p/pegawai') ?>">Pengolahan Data Master Pegawai</a></li>
					<li class="breadcrumb-item active">Detail Data <?php echo $data['nama'] ?></li>
				</ol>
			</nav>
		</div>
		<section class="section">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<form action="<?php echo base_url('p/pegawai/u') ?>" method="post">
							<input type="hidden" name="id" value="<?php echo $data['idpegawai'] ?>">
							<div class="card-body">
								<a href="#tambah" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3" style="float: right;"><i class="bi bi-plus-circle"></i> Tambah Data</a>
								<h5 class="card-title">Data Pegawai</h5>
								<p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Simpan Data</strong> untuk menyimpan inputan data baru</p>
								<hr>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">NIP</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" placeholder="Nomor Induk Pegawai" name="nip" maxlength="21" value="<?php echo $data['nip'] ?>">
									</div>
								</div>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">Nama</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" placeholder="Nama Pengguna" name="nama" maxlength="63" value="<?php echo $data['nama'] ?>" required>
									</div>
								</div>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">Jenis Kelamin</label>
									<div class="col-sm-9">
										<select class="form-control" name="jekel" required>
											<option <?php if($data['jekel'] == 'Pria'){echo "selected";} ?>>Pria</option>
											<option <?php if($data['jekel'] == 'Wanita'){echo "selected";} ?>>Wanita</option>
										</select>
									</div>
								</div>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">Alamat</label>
									<div class="col-sm-9">
										<textarea class="form-control" placeholder="Alamat Lengkap" name="alamat" rows="3" style="resize: none;" required><?php echo $data['alamat'] ?></textarea>
									</div>
								</div>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">Pangkat</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" placeholder="Pangkat Pegawai" name="pangkat" maxlength="27" value="<?php echo $data['pangkat'] ?>" list="daftarpangkat" required>
										<datalist id="daftarpangkat">
											<?php foreach ($pangkat as $p) {?>
												<option><?php echo $p['pangkat'] ?></option>
											<?php } ?>
										</datalist>
									</div>
								</div>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">Golongan</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" placeholder="Golongan Pegawai" name="golongan" maxlength="9" value="<?php echo $data['golongan'] ?>" list="daftargolongan" required>
										<datalist id="daftargolongan">
											<?php foreach ($golongan as $g) {?>
												<option><?php echo $g['golongan'] ?></option>
											<?php } ?>
										</datalist>
									</div>
								</div>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">Jabatan</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" placeholder="Jabatan Pegawai" name="jabatan" maxlength="99" value="<?php echo $data['jabatan'] ?>" list="daftarjabatan" required>
										<datalist id="daftarjabatan">
											<?php foreach ($jabatan as $j) {?>
												<option><?php echo $j['jabatan'] ?></option>
											<?php } ?>
										</datalist>
									</div>
								</div>
								<div class="row mb-4">
									<label for="inputText" class="col-sm-3 col-form-label">Status</label>
									<div class="col-sm-9">
										<select class="form-control" name="status" required>
											<option <?php if($data['status'] == '1'){echo "selected";} ?> value="1">Aktif</option>
											<option <?php if($data['status'] == '0'){echo "selected";} ?> value="0">Nonaktif</option>
										</select>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<a href="<?php echo base_url('p/pegawai') ?>" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Kembali</a>
								<button type="submit" class="btn btn-primary btn-sm" style="float: right;"><i class="bi bi-download"></i> Simpan Perubahan Data</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php echo view('pimpinan/ascript') ?>
</body>
</html>