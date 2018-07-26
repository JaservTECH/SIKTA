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
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 3</div><span>Upload</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 4</div><span>Informasi</span></li>
			<li id="wizard-title-1" class="current-step" style="cursor: default;"><div>Langkah 5</div><span>Get File Support</span></li>
		</ul>
		<div action="" method="POST" id="wizard"> 
			<fieldset title="Step 1" class="step" id="wizard-step-0" style="display: block;"> 
				<legend>Fields</legend> 
				<div class=form-row>
					<div class="col-md-3">File pendukung </div>
					<div class="col-md-9">
						<div style='text-align : left;'>
							<button onclick="showFujPDFTAD('22');" class="btn btn-base btn clean"><span class='icon-download-alt'> unduh fuj 22</span></button>
							&nbsp;&nbsp;
							<button onclick="showFujPDFTAD('23');" class="btn btn-base btn clean"><span class='icon-download-alt'> unduh fuj 23</span></button>
						</div>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-12">Selamat! ,Pendaftaran Anda terverifikasi Koordinator Tugas Akhir. Silahkan Unduh dokumen yang diperlukan untuk Pelaksaan Sidang, Semoga Sukses Menyertai Anda. </div>
				</div> 
				<!--
					<div class="form-row">
					<form class="hidden" id=seminar1form method=POST target="frame-layout" enctype="multipart/form-data" action="<?php echo base_url();?>Classseminartad/setSeminarTA2next2.aspx">
						<input class="hidden" type="file" id="s-k-bimbingan" name="s-k-bimbingan" accept=".pdf">
						<input class="hidden" type="file" id="s-k-peserta" name="s-k-peserta" accept=".pdf">
					</form>
					<iframe id="frame-layout" name="frame-layout" class="hidden"></iframe>
				</div>
					-->
			</fieldset>
		</div> 
	</div> 
</div>