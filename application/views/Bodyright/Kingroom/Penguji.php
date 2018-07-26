<?php
	if(!defined('BASEPATH'))
		exit("Tidak memiliki hak akses");
	?>
<div class="block">
	<ul class="nav nav-tabs">
		<li class="active" id="penguji-TA1">
			<a href="#tab5" data-toggle="tab" title="Penguji bimbingan Seminar TA 1"><span class="icon-calendar-empty"></span> Bimbingan Seminar</a>
		</li>
		<li class=""  id="penguji-TA2"><a href="#tab6" data-toggle="tab" title="Penguji bimbingan Seminar TA 2" ><span class="icon-calendar"></span> Bimbingan Sidang</a></li>
		<li class=""  id="penguji-TA2-ketua"><a href="#tab8" data-toggle="tab" title="Ketua Penguji Seminar TA 2"><span class="icon-calendar"></span> Ketua Penguji</a></li>
		<li class=""  id="penguji-TA2-pembantu"><a href="#tab7" data-toggle="tab" title="Anggota 1 Penguji Seminar TA 2"><span class="icon-calendar"></span> Anggota 1</a></li>
		<li class=""  id="penguji-TA2-pembantu2"><a href="#tab9" data-toggle="tab" title="Anggota 2 Penguji Seminar TA 2"><span class="icon-calendar"></span> Anggota 2</a></li>
	</ul>
	<div class="content content-transparent tab-content">
		<div class="tab-pane active" id="tab5">
		 	<div class="block">
				<div class="header">
					<h2>Penguji Bimbingan Seminar Tugas Akhir Tahun Ajaran <?php
					$temp = intval(DATE('m'));
					if($temp <=6 && $temp >= 1){
						echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester Genap";
					}else{
						echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester Gasal";
					}
					?> (<span><a onclick='
						$("#search-name-penguji-ta1").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta1").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div>
				<div class="content">
					<div  style="display : inline : block; text-align : right;margin-bottom : 10px;">
						<label style="margin : 1px;">
							<input type="text" id="search-name-penguji-ta1" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim, nama dan judul ta mahasiswa " placeholder="Ketikan lalu enter ..."/>
						</label>
					</div>
					<div style="overflow-y : auto; max-height : 300px; padding-bottom : 50px;">
						<table class="table table-striped table-hover ">
							<thead>
								<tr>
									<th style='text-align : center;'>No</th>
									<th style='text-align : center;'>Nama</th>
									<th style='text-align : center;'>Waktu</th>
									<th style='text-align : center;'>Ruang</th>
									<th style='text-align : center;'>Operasi</th>
								</tr>
							</thead>
							<tbody id="tabel-penguji-TA1" style="overflow-y : auto;">
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
		<div class="tab-pane" id="tab6">
		 	<div class="block">
				<div class="header">
					<h2>Penguji Bimbingan Sidang Tugas Akhir Tahun Ajaran <?php
					$temp = intval(DATE('m'));
					if($temp <=6 && $temp >= 1){
						echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester Genap";
					}else{
						echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester Gasal";
					}
					?> (<span style=''><a onclick='
						$("#search-name-penguji-ta2").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div>
				<div class="content">
					<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
						<label style="margin : 1px;">
							<input type="text" id="search-name-penguji-ta2" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim, nama dan judul ta mahasiswa " placeholder="Ketikan lalu enter ..."/>
						</label>
					</div>
					<div style="overflow-y : auto;max-height : 300px; padding-bottom : 50px;">
						<table class="table table-striped table-hover ">
							<thead>
								<tr>
									<th style='text-align : center;'>No</th>
									<th style='text-align : center;'>Nama</th>
									<th style='text-align : center;'>Waktu</th>
									<th style='text-align : center;'>Ruang</th>
									<th style='text-align : center;'>Operasi</th>
								</tr>
							</thead>
							<tbody id="tabel-penguji-TA2" style="overflow-y : auto; ">
								<tr style="">
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
		<div class="tab-pane" id="tab7">
		 	<div class="block">
				<div class="header">
					<h2>Anggota 1 Penguji Sidang Tugas Akhir Tahun Ajaran <?php
					$temp = intval(DATE('m'));
					if($temp <=6 && $temp >= 1){
						echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester Genap";
					}else{
						echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester Gasal";
					}
					?> (<span style=''><a onclick='
						$("#search-name-penguji-ta2-pembantu").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2-pembantu").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div>
				<div class="content">
					<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
						<label style="margin : 1px;">
							<input type="text" id="search-name-penguji-ta2-pembantu" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim dan nama mahasiswa " placeholder="Ketikan lalu enter ..."/>
						</label>
					</div>
					<div style="overflow-y : auto;max-height : 300px; padding-bottom : 80px;">
						<table class="table table-striped table-hover ">
							<thead>
								<tr>
									<th  style='text-align : center;'>No</th>
									<th style='text-align : center;'>Nama</th>
									<th style='text-align : center;'>Waktu</th>
									<th style='text-align : center;'>Ruang</th>
									<th style='text-align : center;'>Operasi</th>
								</tr>
							</thead>
							<tbody id="tabel-penguji-TA2-pembantu" style="overflow-y : auto; ">
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
		<div class="tab-pane" id="tab9">
		 	<div class="block">
				<div class="header">
					<h2>Anggota 2 Penguji Sidang Tugas Akhir Tahun Ajaran <?php
					$temp = intval(DATE('m'));
					if($temp <=6 && $temp >= 1){
						echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester Genap";
					}else{
						echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester Gasal";
					}
					?> (<span style=''><a onclick='
						$("#search-name-penguji-ta2-pembantu2").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2-pembantu2").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div>
				<div class="content">
					<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
						<label style="margin : 1px;">
							<input type="text" id="search-name-penguji-ta2-pembantu2" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim dan nama mahasiswa " placeholder="Ketikan lalu enter ..."/>
						</label>
					</div>
					<div style="overflow-y : auto; max-height : 300px; padding-bottom : 80px;">
						<table class="table table-striped table-hover ">
							<thead>
								<tr>
									<th  style='text-align : center;'>No</th>
									<th style='text-align : center;'>Nama</th>
									<th style='text-align : center;'>Waktu</th>
									<th style='text-align : center;'>Ruang</th>
									<th style='text-align : center;'>Operasi</th>
								</tr>
							</thead>
							<tbody id="tabel-penguji-TA2-pembantu2" style="overflow-y : auto;">
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
		<div class="tab-pane" id="tab8">
		 	<div class="block">
				<div class="header">
					<h2>Ketua Penguji Sidang Tugas Akhir Tahun Ajaran <?php
					$temp = intval(DATE('m'));
					if($temp <=6 && $temp >= 1){
						echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester Genap";
					}else{
						echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester Gasal";
					}
					?> (<span style=''><a onclick='
						$("#search-name-penguji-ta2-ketua").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2-ketua").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div>
				<div class="content">
					<div style="display : inline : block; text-align : right;margin-bottom : 10px;">

						<label style="margin : 1px;">
							<input type="text" id="search-name-penguji-ta2-ketua" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim dan nama mahasiswa " placeholder="Ketikan lalu enter ..."/>
						</label>

					</div>
					<div style="overflow-y : auto; max-height : 300px; padding-bottom : 80px;">
						<table class="table table-striped table-hover ">
							<thead>
								<tr>
									<th  style='text-align : center;'>No</th>
									<th style='text-align : center;'>Nama</th>
									<th style='text-align : center;'>Waktu</th>
									<th style='text-align : center;'>Ruang</th>
									<th style='text-align : center;'>Operasi</th>
								</tr>
							</thead>
							<tbody id="tabel-penguji-TA2-ketua" style="overflow-y : auto;">
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
	</div>
</div>
