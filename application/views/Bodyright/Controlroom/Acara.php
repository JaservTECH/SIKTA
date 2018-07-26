<?php
	if(!defined('BASEPATH'))
		exit("Tidak memiliki hak akses");
	?>
<div class="block"> 
	<ul class="nav nav-tabs"> 
		<li class="active">
			<a href="#tab5" data-toggle="tab"><span class="icon-calendar-empty"></span> Waktu Akademik</a>
		</li> 
		<li class=""><a href="#tab6" data-toggle="tab"><span class="icon-calendar"></span> Informasi Singkat</a></li> 
		<li class=""><a href="#tab7" data-toggle="tab"><span class="icon-calendar"></span> File Unggahan</a></li> 
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Tahun Ajaran <?php 
						echo $year."-".($year+1)." Semester ".$semester;
					?></h2>
				</div> 
				<div class="content">
					<div style="overflow-y : auto; max-height:250px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th style="text-align : center;">No</th>
									<th style="text-align : center;">Tahun</th>
									<th style="text-align : center;">Semester</th>
									<th style="text-align : center;">Mulai</th> 
									<th style="text-align : center;">Berakhir</th>
									<th style="text-align : center;">Operasi</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-acara-default" style="overflow-y : auto; max-height: 250px;">   
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>

		</div> 
		<div class="tab-pane" id="tab6"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Kelola Papan Informasi</h2>
				</div> 
				<div class="content">
					<div style="display : inline : block; text-align : right; margin-bottom : 10px;">
						<label style=" margin : 1px;">
							<button class="btn btn-clean btn-success" id="add-new-event"><span class="icon-plus"> tambahkan</span></button>
						</label>
						<label style=" margin : 1px;">
							<input type="text" id="search-semester" pattern="[a-zA-Z0-9 @.]{0,50}" placeholder="judul acara ..."/>
						</label>
							
						
					</div> 
					<div style="overflow-y : auto; max-height : 250px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th style='text-align : center;'>No</th>
									<th style='text-align : center;'>Judul</th> 
									<th style='text-align : center;'>Isi</th>
									<th style='text-align : center;'>Operasi</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-acara-lain">   
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>
		</div> 
		<div class="tab-pane"  id="tab7"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Kelola File Unggahan</h2>
				</div> 
				<div class="content">
					<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
						<label style=" margin : 1px;">
						<button class="btn btn-clean btn-success" id="add-new-file-data"><span class="icon-plus"> tambahkan</span></button>
						</label>
						<div class='hidden'>
							<form  id="newFile-session" method='POST' target="frame-upload-newFile" enctype="multipart/form-data" action="Controlfileupload/addNewRecord.jsp">
								<input type='file' name='file-data-name' id="file-data-id">
								<input type='text' name='file-data-keterangan-name' id='file-data-keterangan-id'>
							</form>
							<iframe id="frame-upload-newFile" name="frame-upload-newFile" style="display: none;"></iframe>
						</div>
						
					</div> 
					<div style="overflow-y : auto; max-height : 250px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th style="text-align : center;">No</th>
									<th style="text-align : center;">Deskripsi File</th>
									<th style="text-align : center;">Operasi</th> 
								</tr> 
							</thead style="display:block"> 
							<tbody id="tabel-file-default" style="overflow-y : auto; max-height: 250px;">   
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>

		</div> 
	</div> 
</div>