<?php
	//	Instruksi Kerja Nomor 1.
	//	Berisi fungsi penghitungan tagihan awal, dari harga dan jumlah
	function hitung_tagihan_awal($hargaSatuan,$jumlahPesanan){ 
		$tagihanAwal = $hargaSatuan * $jumlahPesanan;
		return $tagihanAwal;
		
	}
	
	//	Instruksi Kerja Nomor 2.
	//	Variabel $cabang berisi data kota lokasi cabang restoran dalam bentuk array.
	//	$cabang = array("x","x","x","x",);
	$cabang = array("Harmoni", "Sarinah", "Grogol", "Senayan", "Pluit", "Cempaka");
	
	//	Instruksi Kerja Nomor 3.
	//	Mengurutkan array $cabang sesuai abjad A-Z.
	//	.....
	sort($cabang);

	//	Instruksi Kerja Nomor 4.
	//	Variabel untuk menyimpan harga satuan nasi kotak.
	//	.....
	$hargaSatuan = 50000;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Form Pemesanan Nasi Kotak</title>
		<!-- Instruksi Kerja Nomor 5. -->
		<!-- Menghubungkan dengan library/berkas CSS. -->
		<!-- Ini cara memanggil CSS dengan menggunakan framework dari Bootstrap secara external -->
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
	</head>
	
	<body>
	<div class="container border">
		<!-- Menampilkan judul halaman -->
		<h3 class="alert alert-primary">Form Pemesanan Nasi Kotak</h3>
		
		<!-- Instruksi Kerja Nomor 6. -->
		<!-- Menampilkan logo restoran -->
		<!-- Menggunakan img untuk memuculkan img. -->
		<img src="image/logo.png" alt="logo" width="100px">
		
		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formPemesanan">
			<div class="form-group row">
				<!-- Masukan pilihan lokasi cabang resto. -->
				<div class="col-lg-2"><label for="tipe">Cabang:</label></div>
				<div class="col-lg-2">
					<select id="cabang" name="cabang">
					<option value="cabang" name="cabang">- Pilih Cabang -</option>
					<?php
						//	Instruksi Kerja Nomor 7.
						//	Menampilkan dropdown pilihan lokasi cabang restoran berdasarkan data pada array $cabang.
						//	Menggunakan foreach untuk melakukan pengulangan
						
						foreach ($cabang as $lokasi_cabang) {
						echo "('<option value=" . $lokasi_cabang .">".$lokasi_cabang."</option>')";
						}						
					?>	
					</select>
				</div>
			</div>
			<div class="form-group row">
				<!-- Masukan data nama pelanggan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama" placeholder="Masukkan Nama Anda">Nama Pelanggan:</label></div>
				<div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
			</div>
			<div class="form-group row">
				<!-- Masukan data nomor HP pelanggan. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Nomor HP:</label></div>
				<div class="col-lg-2"><input type="number" id="noHP" name="noHP" maxlength="16"></div>
			</div>
			<div class="form-group row">
				<!-- Masukan data jumlah kotak pesanan. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Jumlah Kotak:</label></div>
				<div class="col-lg-2"><input type="number" id="jumlahPesanan" name="jumlahPesanan" maxlength="4"></div>
			</div>
			<div class="form-group row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPemesanan" value="Pesan" name="Pesan">Pesan</button></div>
				<div class="col-lg-2"></div>		
			</div>
		</form>
	</div>
	<?php
		//	Kode berikut dieksekusi setelah tombol Hitung ditekan.
		if(isset($_POST['Pesan'])) {
			
			//	Variabel $dataPesanan berisi data-data pemesanan dari form dalam bentuk array.
			$dataPesanan = array(
				'cabang' => $_POST['cabang'],
				'nama' => $_POST['nama'],
				'noHP' => $_POST['noHP'],
				'jumlahPesanan' => $_POST['jumlahPesanan']
			);
			
			//	Variabel berisi path file data.json yang digunakan untuk menyimpan data pemesanan.
			$berkas = "data.json";
			
			//	Mengubah data pemesanan yang berbentuk array PHP menjadi bentuk JSON.
			$dataJson = json_encode($dataPesanan, JSON_PRETTY_PRINT);
			
			//	Instruksi Kerja Nomor 8.
			//	Menyimpan data pemesanan yang berbentuk JSON ke dalam file JSON
			file_put_contents('data/data.json', $dataJson);
			
			//	Instruksi Kerja Nomor 9.
			//	Mengambil data pemesanan dari file JSON
			$dataJson = file_get_contents('data/data.json');
			
			//	Mengubah data pemesanan dalam format JSON ke dalam format array PHP.
			$dataPesanan = json_decode($dataJson, true);
			
			//	Variabel $tagihanAwal berisi nilai tagihan awal (sebelum diskon) yang dihitung dengan menggunakan fungsi hitung_tagihan_awal().
			$tagihanAwal = hitung_tagihan_awal($dataPesanan['jumlahPesanan'], $hargaSatuan);
			
			//	Menginisiasi variabel $diskon dengan nilai awal 0.
			$diskon = 0;
			
			//	Instruksi Kerja Nomor 10.
			//	Menghitung diskon.
			if($_POST['cabang'] == "Sarinah" && $tagihanAwal >= 1000000){
				$diskon = (5/100) * $tagihanAwal;
			} else {
				$diskon = 0;
			}
			
			// Tambahan: menambahakan Tagihan Pajak
			$tagihanPajak = $tagihanAwal*0.1;
			
			
			//	Variabel $tagihanAkhir berisi nilai tagihan akhir yang didapat dari nilai tagihan awal dikurangi diskon dan ditambakan pajak.
			$tagihanAkhir = $tagihanAwal - $diskon + $tagihanPajak;
			
			//	Menampilkan data pemesanan dan hasil perhitungan diskon dan tagihan.
			echo "
				<br/>
				<div class='container'>
					<div class='form-group row'>
						<!-- Menampilkan lokasi cabang restoran. -->
						<div class='col-lg-2'>Cabang:</div>
						<div class='col-lg-2'>".$dataPesanan['cabang']."</div>
					</div>
					<div class='form-group row'>
						<!-- Menampilkan nama pelanggan. -->
						<div class='col-lg-2'>Nama Pelanggan:</div>
						<div class='col-lg-2'>".$dataPesanan['nama']."</div>
					</div>
					<div class='form-group row'>
						<!-- Menampilkan nomor HP pelanggan. -->
						<div class='col-lg-2'>Nomor HP:</div>
						<div class='col-lg-2'>".$dataPesanan['noHP']."</div>
					</div>
					<div class='form-group row'>
						<!-- Menampilkan jumlah kotak pesanan. -->
						<div class='col-lg-2'>Jumlah Kotak:</div>
						<div class='col-lg-2'>".$dataPesanan['jumlahPesanan']." box</div>
					</div>
					<div class='form-group row'>
						<!-- Menampilkan tagihan awal (sebelum diskon). -->
						<div class='col-lg-2'>Tagihan Awal:</div>
						<div class='col-lg-2'>Rp".number_format($tagihanAwal, 0, ".", ".").",-</div>
					</div>
					<div class='form-group row'>
						<!-- Menampilkan tarif pemesanan. -->
						<div class='col-lg-2'>Diskon:</div>
						<div class='col-lg-2'>Rp".number_format($diskon, 0, ".", ".").",-</div>
					</div>
					<div class='form-group row'>
						<!-- Menampilkan tagihan awal (sebelum diskon). -->
						<div class='col-lg-2'>Tagihan Pajak:</div>
						<div class='col-lg-2'>Rp".number_format($tagihanPajak, 0, ".", ".").",-</div>
					</div>
					<div class='form-group row'>
						<!-- Menampilkan tagihan akhir (setelah diskon). -->
						<div class='col-lg-2'>Tagihan Akhir:</div>
						<div class='col-lg-2'>Rp".number_format($tagihanAkhir, 0, ".", ".").",-</div>
					</div>
			</div>
			";
		}
	?>
	</body>
</html>