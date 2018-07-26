<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	

<div class="block"> 
	<ul class="nav nav-tabs"> 
		<li class="active tip" title="tabel seminar ta 1">
			<a href="#tab5" data-toggle="tab" ><span class="icon-table"></span> Ruang Distribusi Seminar</a>
		</li>
		<li class="tip" title="tabel seminar ta 2">
			<a href="#tab6" data-toggle="tab" id="seminar-ta2-pemerataan" ><span class="icon-table"></span> Ruang Distribusi Sidang</a>
		</li>		
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 	 
			<div class="block"> 
				<div class="header"> 
					<h2>Seminar Tugas Akhir (<span style=''><a onclick='
							$("#search-name-seminar").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-name-seminar").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div> 
				<div class="content">
					<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
						<label style="margin : 1px;">
							<li class="btn-group">                                    
								<button style=" cursor :pointer;" class="dropdown-toggle tip btn btn-clean btn-info" title="Kelola semua data registrasi" data-toggle="dropdown" data-original-title="Dropdown"><span class="icon-ellipsis-horizontal"> Operasi</span></button>
								<ul class="dropdown-menu" role="menu">
									<li data-toggle="dropdown" onclick='openXLFormSem(base_url+"Controlresultseminar/getDataWithExcelSem")'><a style="cursor : pointer;"><span class='icon-download-alt'> Unduh (.xlsx)</span></a></li>
								</ul>                                                                            
							</li>
						</label>
						<label style="margin : 1px;">
							<select id="semester-seminar">
								<option value="1" <?php if($smts) echo "selected"?>>Semester 1</option>
								<option value="2" <?php if($smtd) echo "selected"?>>Semester 2</option>
							</select>
						</label>
						<label style="margin : 1px;">
							<select id="tahun-seminar">
								<?php 
								for($i=2013; $i<= $year;$i++){
									if($i == $year)
										echo "<option value='".$i."' selected>Tahun ajaran ".$i."-".($i+1)."</option>";
									else
										echo "<option value='".$i."'>Tahun ajaran ".$i."-".($i+1)."</option>";
								}
								?>
							</select>
						</label>
						<label style="margin : 1px;">
							<input type="text" id="search-name-seminar" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
						</label>
					</div> 
					<div>
						<table class="table table-striped table-hover " style="width : 100%;"> 
							<thead> 
								<tr> 
									<th style='text-align : center;'>No</th>
									<th style='text-align : center;'>Nim</th> 
									<th style='text-align : center;'>Nama Mahasiswa</th>
									<th style='text-align : center;'>Bidang Minat</th>    
									<th style='text-align : center;'>Dosen Pembimbing</th>
									<th style='text-align : center;'>Status kelengkapan</th>
									<th style='text-align : center;'>Aksi</th>
									<th style='text-align : center;'>Nilai</th>
								</tr> 
							</thead> 
							<tbody id="tabel-pemerataan-seminar-ta1" style="overflow-y : auto; max-height: 250px;">  
								<tr > 
									<td>-</td>
									<td>-</td>
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
				<ul class="nav nav-tabs nav-justified"> 
					<li class="active" onclick="reloadChartSeminarAll(1);"><a href="#tab11" data-toggle="tab">Total Bimbingan</a></li> 
					<li class="" onclick="reloadChartSeminarAll(2);"><a href="#tab12" data-toggle="tab">Total penguji 1</a></li> 
					<li class="" onclick="reloadChartSeminarAll(3);"><a href="#tab13" data-toggle="tab">Total penguji 2</a></li>
					<li class="" onclick="reloadChartSeminarAll(4);"><a href="#tab14" data-toggle="tab">Total penguji 3</a></li> 
				</ul> 
				<div class="content content-transparent tab-content">
					<div class="tab-pane active" id="tab11"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-1" style="width: 100%; height : 300px;">
									
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab12"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-2" style="width: 100%;height : 300px;">
									
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab13"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-3" style="width: 100%;height : 300px;">
									
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab14"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-4" style="width : 100%;height : 300px;">
									
								</div>
							</div>
						</div>
					</div> 
				</div> 
			</div>
			<div class="block"> 
				<div class="header"> 
					<h2>Sidang Tugas Akhir (<span style=''><a onclick='
							$("#search-name-sidang").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-name-sidang").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div> 
				<div class="content">
					<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
						<label style="margin : 1px; ">
						<li class="btn-group">                                    
							<button style=" cursor :pointer;" class="dropdown-toggle tip btn btn-clean btn-info" title="Kelola tampilan tab" data-toggle="dropdown" data-original-title="Dropdown"><span class="icon-ellipsis-horizontal"> Kelola Tabs</span></button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li class="dropdown-header">Kelola tab aksi penguji</li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.aksiPenguji = false; $('.tab-aksi-penguji').fadeIn('slow');"><a style="cursor : pointer;"><span class="icon-eye-open"> tampilkan</span></a></li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.aksiPenguji = true; $('.tab-aksi-penguji').fadeOut('slow');"><a style="cursor : pointer;"><span class="icon-eye-close"> sembunyikan</span></a></li>
								<li class="dropdown-header">Kelola tab status kelengkapan</li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.statusKelengkapan = false; $('.tab-status-kelengkapan').fadeIn('slow');"><a style="cursor : pointer;"><span class="icon-eye-open"> tampilkan</span></a></li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.statusKelengkapan = true; $('.tab-status-kelengkapan').fadeOut('slow');"><a style="cursor : pointer;"><span class="icon-eye-close"> sembunyikan</span></a></li>
								<li class="dropdown-header">Kelola tab aksi</li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.aksi = false; $('.tab-aksi').fadeIn('slow');"><a style="cursor : pointer;"><span class="icon-eye-open"> tampilkan</span></a></li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.aksi = true; $('.tab-aksi').fadeOut('slow');"><a style="cursor : pointer;"><span class="icon-eye-close"> sembunyikan</span></a></li>
								<li class="dropdown-header">Kelola tab nilai</li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.nilai = false; $('.tab-nilai').fadeIn('slow');"><a style="cursor : pointer;"><span class="icon-eye-open"> tampilkan</span></a></li>
								<li data-toggle="dropdown" onclick="tabControl.sidang.nilai = true; $('.tab-nilai').fadeOut('slow');"><a style="cursor : pointer;"><span class="icon-eye-close"> sembunyikan</span></a></li>
							</ul>                                                                            
						</li>
					</label>
						<label style="margin : 1px;">
							<li class="btn-group">                                    
								<button style=" cursor :pointer;" class="dropdown-toggle tip btn btn-clean btn-info" title="Kelola semua data registrasi" data-toggle="dropdown" data-original-title="Dropdown"><span class="icon-ellipsis-horizontal"> Operasi</span></button>
								<ul class="dropdown-menu" role="menu">
									<li data-toggle="dropdown" onclick='openXLFormSid(base_url+"Controlresultseminar/getDataWithExcelSid")'><a style="cursor : pointer;"><span class='icon-download-alt'> Unduh (.xlsx)</span></a></li>
								</ul>                                                                            
							</li>
						</label>
						<label style="margin : 1px;">
							<select id="semester-sidang">
								<option value="1" <?php if($smts) echo "selected"?>>Semester 1</option>
								<option value="2" <?php if($smtd) echo "selected"?>>Semester 2</option>
							</select>
						</label>
						<label style="margin : 1px;">
							<select id="tahun-sidang">
								<?php 
								for($i=2013; $i<= $year;$i++){
									if($i == $year)
										echo "<option value='".$i."' selected>Tahun ajaran ".$i."-".($i+1)."</option>";
									else
										echo "<option value='".$i."'>Tahun ajaran ".$i."-".($i+1)."</option>";
								}
								?>
							</select>
						</label>
						<label style="margin : 1px;">
							<input type="text" id="search-name-sidang" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
						</label>
					</div> 
					<div>
						<table class="table table-striped table-hover " style="width : 100%;"> 
							<thead> 
								<tr> 
									<th style='text-align : center;'>No</th>
									<th style='text-align : center;'>Nama Mahasiswa</th>
									<th style='text-align : center;'>Penguji 1</th>
									<th style='text-align : center;'>Penguji 2</th>
									<th style='text-align : center;'>Penguji 3</th>
									<th style='text-align : center;'>Pembimbing</th>
									<th class='tab-aksi-penguji' style='text-align : center;'>Aksi Penguji</th>
									<th class='tab-status-kelengkapan' style='text-align : center;'>Status kelengkapan</th>
									<th class='tab-aksi' style='text-align : center;'>Aksi</th>
									<th class='tab-nilai' style='text-align : center;'>Nilai</th>
								</tr> 
							</thead> 
							<tbody id="tabel-pemerataan-seminar-ta2" style="overflow-y : auto; max-height: 250px;">  
								<tr > 
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
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
	</div> 
</div>