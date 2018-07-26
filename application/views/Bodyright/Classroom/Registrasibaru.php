<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>

		<form id=validate method=POST target="frame-layout" enctype="multipart/form-data" action="<?php echo base_url();?>Classregistrasibaru/getResultRegistrasiBaru.jsp"> 
			<div class=block> 
				<div class=header> 
					<h2>Registrasi TA Baru</h2> 
					<div class="side pull-right"> 
						<button class="btn btn-default btn-clean" id="reset-form" type=button>bersihkan formulir</button> 
					</div> 
				</div> 
				<div class="block">
					<div class="alert alert-warning" style="opacity : 0.7; color : black; margin-bottom : 0px;">
						<b>Peringatan!</b><br>
						<ul style="list-style-type:decimal;">
							<li>Siapkan dokumen KRS sebagai dokumen persyaratan</li>
							<li>Untul melakukan perubahan transkrip dapat dilakukan pada halaman pengaturan</li>
							<li>Untul isian yang di-<i>disable</i> di ubah pada halaman pengaturan</li>
							<li>Isian dosen merupakan alternatif dari mengajukan dosen (pengganti FS-01)</li>
						</ul>
					</div>
				</div>
				<div class="content controls"> 
					<div class=form-row> 
						<div class=col-md-3>Nama :
						</div> 
						<div class=col-md-9> 
							<div ></div>
							<input type=text class="form-control" id="baru-nama" name="baru-nama" /> 
							<span class=help-block>wajib diisi, a-z A-Z (spasi)</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Nim :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text class="form-control" id="baru-nim" name="baru-nim" /> 
							<span class=help-block>wajib diisi, J2F000000 &lt; <b>2009</b> &lt; 00000000000000 (spasi)</span> 
						</div> 
					</div> 
					<div class="form-row"> 
						<div class="col-md-3">Bidang Minat:
						</div> 
						<div class="col-md-9"> 
							<div></div>
							<select name="baru-minat" class="form-control" id="baru-minat" > 
								<option value="0" ></option> 
								<?php 
								for($i=0;$i<count($peminatan);$i++){
									echo "<option value='".$peminatan[$i]['id'];
									echo"'>".$peminatan[$i]['nama']."</option>";
								}
								?>
							</select> 
							<span class="help-block">wajib dipilih salah satu</span> 
						</div> 
					</div>
					<div class="form-row"> 
						<div class=col-md-3>No Hp :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text pattern="[0-1]{9,13}" name="baru-nohp" id="baru-nohp" class="form-control" /> 
							<span class=help-block>wajib diisi, Contoh = 087829315699</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>E-mail :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type="email" class="form-control" id="baru-email" name="baru-email" /> 
							<span class=help-block>wajib diisi, Contoh = jafarabdurrahman50@live.com</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Nama Orang Tua :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text name="baru-ortu" id="baru-ortu" pattern="[a-zA-Z]{1}[a-zA-Z ]{48}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Abdurrahman Albasyir</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>No Hp Orang Tua :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text id="baru-nohportu" name="baru-nohportu" pattern="[0-1]{9,13}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = 087829315699</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Judul TA :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text id="baru-judulta" name="baru-judulta" pattern="[a-zA-Z]{1}[a-zA-Z ]{48}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Sistem Pembaca Pikiran Dengan Deteksi Wajah</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Lokasi :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text name="baru-lokasi" id="baru-lokasi" pattern="[a-zA-Z]{1}[a-zA-Z ]{48}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Semarang Selatan, kecamatan peterongan</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Metode :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text id="baru-metode" name="baru-metode" pattern="[a-zA-Z]{1}[a-zA-Z ]{28}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Citra Random Face Detect</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Referensi 1 :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text id="baru-ref1" name="baru-ref1" pattern="[a-zA-Z]{1}[a-zA-Z ]{38}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Randomize On Structural 1</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Referensi 2 :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text id="baru-ref2" name="baru-ref2" pattern="[a-zA-Z]{1}[a-zA-Z ]{38}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>tidak wajib diisi, Contoh = Randomize On Structural 2</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Referensi 3 :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text id="baru-ref3" name="baru-ref3" pattern="[a-zA-Z]{1}[a-zA-Z ]{38}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>tidak wajib diisi, Contoh = Randomize On Structural 3</span> 
						</div> 
					</div> 		
					<div class="form-row"> 
						<div class="col-md-3">Dosen pembimbing:
						</div> 
						<div class="col-md-9"> 
							<div></div>
							<select class="form-control" id="baru-dosbing" name="baru-dosbing"> 
								<option value="0"></option> 
								<?php 
								for($i=0;$i<$listdosen['length'];$i++){
									echo "<option value='".$listdosen[$i]['id']."'>".$listdosen[$i]['nama']."</option>";
								}
								?>
							</select> 
							<span class="help-block">Wajib sebagai syarat minimal mengajukan 1 dosen pembimbing dan pengganti lembar FS-01</span> 
						</div> 
					</div>	
					<div class=form-row> 
						<div class=col-md-3>Upload KRS :
						</div> 
						<div class="col-md-9">
							<div></div>
							<input type=file accept=".pdf" class="form-control hidden" id="baru-krs" name="baru-krs" name="baru-krs"/> 
							<button class="btn btn-default" type=button id="krs-exe">Unggah Krs(.pdf)</button>
							<span class=help-block>wajib di unggah, Contoh = Jafar-Krs.pdf</span> 
						</div> 
					</div> 		
					<div class=form-row>  
						<div class="col-md-2">
							<span class=help-block>Catatan : </span>
						</div>
						<div class="col-md-10">
							<span class=help-block>Secara umum data personal yang sudah dimiliki akan mengisi otomatis pada form, jika anda merubahnya, maka data asli anda akan ikut terganti, karena form registrasi harus mengandung isian yang sesuai dengan data yang melakukan registrasi.Terima Kasih.</span> 
						</div> 
					</div> 		
				</div> 
				<div class=footer> 
					<div class="side pull-right"> 
						<div class=btn-group> 
							<button class="btn btn-success btn-clean" id="registrasi-baru-submit" type='button'><span class='icon-save'> daftarkan</span></button> 
						</div> 
					</div> 
				</div> 
				 <iframe class="hidden" id="frame-layout" name="frame-layout"></iframe>
			</div> 
		</form> 
		<script type="text/javascript">
		var registrasiBaruNotReset = "hello jafar";
		</script>