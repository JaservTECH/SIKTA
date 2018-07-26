<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>

<div class="block" >
	<div class='accordion accordion-transparent'> 
		<h3>Selamat <?php
		$time = intval(date("H"));
		if($time > 0 && $time < 8){
			echo "Pagi";
		}else if($time >= 8 && $time < 14){
			echo "Siang";
		}else  if($time >= 14 && $time < 19){
			echo "Sore";
		}else{
			echo "Malam";
		}
		?></h3> 
		<div> 
			<p>Selamat datang di Sistem Informasi Akademik Tugas Akhir V 5.0 Beta Release Core JaservTech base CodeIgniter.<br>
				Sistem menyediakan proses registrasi baru maupun registrasi lama Tugas Akhir, serta proses pendaftaran seminar.<br>
				untuk selengkapnya, silahkan pilih menu bantuan untuk video tutorial penggunaan sistem ini.
				<br>
				<br>
				Terima kasih ^_^
			</p> 
		</div> 
		<h3>Info Cepat Registrasi</h3> 
		<div> 
			<div id="info-cepat-registrasi">
				<div class="block block-drop-shadow" id="content-info-fast"> 
					<div class="header"> 
						<h2>Ubah data registrasi (Berlaku saat belum disetujui)</h2>
					</div> 	
					<div class="block" onload="alert()">
						<div class="alert alert-warning" style="opacity : 0.7; color : black;">
							<b>Peringatan!</b><br>
							<ul style="list-style-type:decimal;">
								<li>Berhati-hati sebelum melakukan perubahan</li>
								<li>Form untuk setiap masukan akan disimpan secara otomatis</li>
								<li>Untuk masukan teks akan dilakukan proses penyimpanan saat berpindah input atau menekan tombol <i>enter</i></li>
								<li>Untuk masukan berupa <i>file</i> akan dilakukan proses penyimpanan saat <i>file</i> dipilih</li>
								<li>Semua perubahan dapat dilakukan jika Koordinator Tugas Akhir belum mengkonfirmasi data registrasi</li>
							</ul>
							<b>Catatan!</b><br>
							(*) Tidak dapat diganti<br>
							(**) Dapat diganti sesuai dengan ketentuan diatas<br>
							(***) Dapat diganti kapan saja
						</div>
					</div>
					<div class="content controls"> 					
						<div class="form-row">
							<div class="col-md-3">*Nama : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-nama" disabled>
								<span class="help-block">Nama Mahasiswa yang bersangkutan</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">*Dosen pembimbing : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-dosbing" disabled>
								<span class="help-block">Dosen pembbimbing yang dipilih</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">*Status : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-status" disabled>
								<span class="help-block">Status registrasi yang didaftarkan</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">*Kategori : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-kategori" disabled>
								<span class="help-block">Kategori registrasi yang dilakukan</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">**Judul TA : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' onchange='ubahDataOnetoSix(1,this.value);' id="preview-judulta">
								<span class="help-block">Judul tugas akhir yang diajukan</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">**Metode : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-metode" onchange='ubahDataOnetoSix(2,this.value);'>
								<span class="help-block">Metode yang digunakan dalam judul tugas akhir</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">**Lokasi : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-lokasi" onchange='ubahDataOnetoSix(3,this.value);'>
								<span class="help-block">Lokasi pengerjaan tugas akhir</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">**Referensi 1 : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="referensis" onchange='ubahDataOnetoSix(4,this.value);'>
								<span class="help-block">Sumber acuan 1 dalam pengerjaan tugas akhir</span> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">**Referensi 2 : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="referensid" onchange='ubahDataOnetoSix(5,this.value);'>
								<span class="help-block">Sumber acuan 2 dalam pengerjaan tugas akhir</span> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">**Referensi 3 : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="referensit" onchange='ubahDataOnetoSix(6,this.value);'>
								<span class="help-block">Sumber acuan 3 dalam pengerjaan tugas akhir</span> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">**KRS : </div>
							<div class="col-md-9">
								<button class="btn btn-info btn-clean" onclick="lihatKRS()" title='lihat krs'><span  class="icon-eye-open"> tampilkan</span></button>
								<button class="btn btn-warning btn-clean" id="ganti-krs-exe" onclick="gantiKRS()" title="ganti krs"><span  class="icon-upload-alt"> ubah</span></button>
								<span class="help-block">Pilih ubah untuk mengganti krs</span> 
								<!--
								<span  style='font-size : 30px; color : green; cursor : pointer; margin-right : 20px;'><i onclick="lihatKRS()" title='lihat KRS' class="icon-eye-open"></i></span>
								<span  style='font-size : 30px; color : green; cursor : pointer;'><i onclick="gantiKRS();" title='ganti KRS' class="icon-upload-alt"></i></span>
								<span class="help-block">File auto upload, hati-hati sebelum mengganti</span> 
								-->
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">***Transkrip : </div>
							<div class="col-md-9">
								<button class="btn btn-info btn-clean" onclick="lihatTranskrip()" title='lihat transkrip'><span  class="icon-eye-open"> tampilkan</span></button>
								<button class="btn btn-warning btn-clean" onclick="updateTranskrip()" title="ganti transkrip"><span  class="icon-upload-alt"> ubah</span></button>
								<span class="help-block">Pilih ubah untuk mengganti transkrip</span> 
								<!--
								<span  style='font-size : 30px; color : green; cursor : pointer; margin-right : 20px;'><i onclick="lihatTranskrip()" title='lihat Transkrip' class="icon-eye-open"></i></span>
								<span  style='font-size : 30px; color : green; cursor : pointer;' onclick="updateTranskrip()"><i title='ganti Transkrip' class="icon-upload-alt"></i></span>
								<span class="help-block">File auto upload, hati-hati sebelum mengganti</span> 
								-->
							</div>
						</div>
						<form id="KRS-session" class="hidden" method='POST' target="frame-upload-pengaturan" enctype="multipart/form-data" action="<?php echo base_url()?>Classroom/setReferences.jsp">
							<input type="file" onchange='uploadKRS(7,"upgrade-krs");' accept=".pdf" name="upgrade-krs" id="support-krs">
							<input type="text" name="kode" value="7">
							<input type="text" name="referensi" value="upgrade-krs">
						</form>						
					</div>
				</div>
			</div>
		</div> 
		
	</div> 
</div>