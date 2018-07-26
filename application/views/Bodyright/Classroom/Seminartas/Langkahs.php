<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<div class="block"> 
	<div class="header"> 
		<h2>Seminar Tugas Akhir (<span style=" color : blue;"><a onclick="refreshPageSeminarTas()" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span>)</h2> 
	</div> 
	<div class="content controls"> 
		<ul id="wizard-titles" class="stepy-titles">
			<li id="wizard-title-0" class="current-step" style="cursor: default;"><div>Langkah 1</div><span>Upload</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 2</div><span>Informasi</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 3</div><span>Get File Support</span></li>
		</ul>
		<div action="" method="POST" id="wizard"> 
			<fieldset class="step" id="wizard-step-0" style="display: block;"> 
				<legend>Fields</legend> 
				<div class=form-row>
					<div class="col-md-3">File pendukung </div>
					<div class="col-md-9">
						<button onclick="showFujPDFTAS('11');" class="btn btn-base btn clean"><span class='icon-download-alt'> unduh fuj 11</span></button>
					<!-- 
					<div tittle='download fuj 11' style="cursor : pointer; width : 100px; height : 45px; text-align : center; float : left; color : white; background-color : black; border-radius : 45px;">
						<i class="icon-file-alt" style="font-size : 16pt; line-height : 45px;"></i> FUJ11
					</div>
					-->
					</div>
				</div> 
				<?php 
				if($fuj11U){
					echo '
					<div class=form-row>
						<div class=col-md-3>FUJ 11 </div>
						<div class=col-md-3>
							<button  id=exec-s-pengantar class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
						</div>
						<div class=col-md-4>
							<a style="color : #666;" id="info-s-pengantar"> : Data kosong</a>
						</div>
					</div> 
					';
				}else{
					echo '
					<div class=form-row>
						<div class=col-md-3>FUJ 11 </div>
						<div class=col-md-3>
							<button  id=exec-s-pengantar class="btn btn-success btn-clean" disabled="true" style=""><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
						</div>
						<div class=col-md-4>
							<a style="color : #666;" id="info-s-pengantar"> : direkomendasikan</a>
						</div>
					</div> 
					';
				}
				?>
				<div class=form-row>
					<div class="col-md-3">Scan Kartu Bimbingan TA </div>
					<div class="col-md-3">
						<button  id="exec-s-k-bimbingan"  class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.png)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-bimbingan"> : Data kosong</a>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Scan Kartu Peserta TA </div>
					<div class="col-md-3">
						<button  id="exec-s-k-peserta"  class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.png)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-peserta"> : Data kosong</a>
					</div>
				</div>
				<div class="form-row">
					<div class=header>
						<h2>Booking Ruang TA 1 untuk Seminar Ta 1</h2> 
					</div> 
					<div class="content controls">
						<div id='calendar'></div> 
						<div class=form-row style="text-align : center; display : inline-block;">
							<div style="max-width : 320px; margin-left : auto; margin-right : auto;">
								<div style="width: 150px; float: left; margin-right : 10px;">
									<button class="btn btn-success btn-clean" id="input-data-seminarta1"><span class='icon-save'> daftarkan</span></button>
								</div>
								
								<div style="width: 150px; float : left; margin-left : 10px;">
									<button class="btn btn-primary btn-clean" id="resetForm"><span class='icon-eraser'> bersihkan</span></button>
								</div>
							</div>			
						</div>
					</div>
					<form class="hidden" id=seminar1form method=POST target="frame-layout" enctype="multipart/form-data" action="<?php echo base_url();?>Classseminartas/setSeminarTA1.jsp">
						<input class="hidden" type="file" id="s-pengantar" name="s-pengantar" accept=".pdf">
						<input class="hidden" type="file" id="s-k-bimbingan" name="s-k-bimbingan" accept=".png">
						<input class="hidden" type="file" id="s-k-peserta"  name="s-k-peserta" accept=".png">
						<input class="hidden" type="text" id="s_tanggal" name="s_tanggal">
						<input class="hidden" type="text" id="s_ruang" name="s_ruang">
					</form>
					<iframe id="frame-layout" name="frame-layout" class="hidden"></iframe>
				</div>
			</fieldset>
		</div> 
	</div> 
</div>