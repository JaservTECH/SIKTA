<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<div class="block"> 
	<div class="header"> 
		<h2>Sidang Tugas Akhir (<span><a onclick='refreshPageSeminarTad()' style='cursor:pointer;'><i class='icon-refresh' title='refresh table'></i></a></span>)</h2> 
	</div> 
	<div class="content controls"> 
		<ul id="wizard-titles" class="stepy-titles">
			<li id="wizard-title-0" class="" style="cursor: default;"><div>Langkah 1</div><span>Upload</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 2</div><span>Informasi</span></li>
			<li id="wizard-title-1" class="current-step" style="cursor: default;"><div>Langkah 3</div><span>Upload</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 4</div><span>Informasi</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 5</div><span>Get File Support</span></li>
		</ul>
		<div action="" method="POST" id="wizard">
			<fieldset title="Step 1" class="step" id="wizard-step-0" style="display: block;"> 
				<legend>Fields</legend> 
				<div class=form-row>
					<div class="col-md-3">File pendukung </div>
					<div class="col-md-9">
						<div style='text-align : left;'>
							<button onclick="showFujPDFTAD('20');" class="btn btn-base btn clean"><span class='icon-download-alt'> unduh fuj 20</span></button>
							&nbsp;&nbsp;
							<button onclick="showFujPDFTAD('25');" class="btn btn-base btn clean"><span class='icon-download-alt'> unduh fuj 25</span></button>
						</div>
					
					
						<!-- <div tittle='download fuj 20' onclick="showFujPDFTAD('20');" style="cursor : pointer; width : 100px; height : 45px; text-align : center; float : left; color : white; background-color : black; border-radius : 45px;">
							<i class="icon-file-alt" style="font-size : 16pt; line-height : 45px;"></i> FUJ20
						</div>
						<div tittle='download fuj 25' onclick="showFujPDFTAD('25');" style="cursor : pointer; width : 100px; height : 45px; text-align : center; float : left; color : white; background-color : black; border-radius : 45px;">
							<i class="icon-file-alt" style="font-size : 16pt; line-height : 45px;"></i> FUJ25
						</div> -->
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">FUJ 20 </div>
					<div class="col-md-3">
						<button  id="exec-s-k-fuj20"  class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-fuj20"> : Data kosong</a>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">FUJ 25 </div>
					<div class="col-md-3">
						<button  id="exec-s-k-fuj25"  class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-fuj25"> : Data kosong</a>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Transkrip </div>
					<div class="col-md-3">
						<button  id="exec-s-k-transkrip"  class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-transkrip"> : Data kosong</a>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Toefl </div>
					<div class="col-md-3">
						<button  id="exec-s-k-toefl"  class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-toefl"> : Data kosong</a>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Krs </div>
					<div class="col-md-3">
						<button  id="exec-s-k-krs"  class="btn btn-clean btn-danger"><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-krs"> : Data kosong</a>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Kartu Bimbingan </div>
					<div class="col-md-3">
						<button  id="exec-s-k-bimbingan"  class="btn btn-danger btn-clean"><span class="icon-upload-alt"></span> Unggah (.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-bimbingan"> : Data kosong</a>
					</div>
				</div> 
				<div class="form-row">				
					<div class='accordion accordion-transparent'> 
						<h3 onclick="ruangActiveNowF(1);" id="show-calendar-1">Booking Ruang Seminar TA 1</h3> 
						<div> 
							<div id='calendar-1'></div> 
						</div> 
						<h3 onclick="ruangActiveNowF(2);"  id="show-calendar-2">Booking Ruang Sidang TA 2</h3> 
						<div> 
							<div id='calendar-2'></div> 
						</div> 
						<h3 onclick="ruangActiveNowF(3);"  id="show-calendar-3">Booking Ruang Sidang Matematika</h3> 
						<div> 
							<div id='calendar-3'></div> 
						</div> 
						<h3 onclick="ruangActiveNowF(4);"  id="show-calendar-4">Booking Ruang Puspital</h3> 
						<div> 
							<div id='calendar-4'></div> 
						</div> 
					</div> 
				</div>
				<div class="form-row" style="text-align : center; display : inline-block;">
					<div style="max-width : 320px; margin-left : auto; margin-right : auto;">
						<div style="width: 150px; float: left; margin-right : 10px;">
							<button class="btn btn-success btn-clean" id="input-data-seminarta1"><span class='icon-save'> daftarkan</span></button>
						</div>
						
						<div style="width: 150px; float : left; margin-left : 10px;">
							<button class="btn btn-primary btn-clean" id="resetForm"><span class='icon-eraser'> bersihkan</span></button>
						</div>
					</div>			
				</div>
				<div class="form-row">
					<form class="hidden" id=seminar1form method=POST target="frame-layout" enctype="multipart/form-data" action="<?php echo base_url();?>Classseminartad/setSeminarTA2next.jsp">
						<input class="hidden" type="file" id="s-k-fuj25" name="s-k-fuj25" accept=".pdf">
						<input class="hidden" type="file" id="s-k-fuj20" name="s-k-fuj20" accept=".pdf">
						<input class="hidden" type="file" id="s-k-transkrip" name="s-k-transkrip" accept=".pdf">
						<input class="hidden" type="file" id="s-k-toefl" name="s-k-toefl" accept=".pdf">
						<input class="hidden" type="file" id="s-k-krs" name="s-k-krs" accept=".pdf">
						<input class="hidden" type="file" id="s-k-bimbingan"  name="s-k-bimbingan" accept=".pdf">
						<input class="hidden" type="text" id="s-k-ruangan"  name="s-k-ruangan" accept=".pdf">
						<input class="hidden" type="text" id="s-k-tanggal"  name="s-k-tanggal" accept=".pdf">
					</form>
					<iframe id="frame-layout" name="frame-layout" class="hidden"></iframe>
				</div>
			</fieldset>
		</div> 
	</div> 
</div>