<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
	 

<div class="block">
	<div>
		<div class="block"  style="padding-bottom : 0px; margin-bottom : 0px;">
			<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
				<div id="controller-diagram" style="100%; height : 200px;">
					
				</div>
			</div>
		</div>
		<div class="block" style="padding-bottom : 0px; margin-bottom : 0px;"> 
			<div class="header"> 
				<h2>Registrasi Pemerataan Mahasiswa (<span ><a onclick='
						$("#search-name-pemerataan").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-pemerataan").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
			</div> 
			<div class="content" style="padding-bottom : 0px;padding-top : 0px; margin-bottom : 0px; margin-top : 0px;">
				<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
					<label style="margin : 1px; ">
						<?php echo $datafilter;?>
					</label>
					<label style="margin : 1px; ">
						<li class="btn-group">                                    
							<button style=" cursor :pointer;" class="dropdown-toggle tip btn btn-clean btn-info" title="Kelola tampilan tab" data-toggle="dropdown" data-original-title="Dropdown"><span class="icon-ellipsis-horizontal"> Kelola Tabs</span></button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li class="dropdown-header">Kelola tab registrasi</li>
								<li data-toggle="dropdown" onclick="
									$('.tab-registrasi').fadeIn('slow');
									tabControl.registrasi.registrasi = false;
								"><a style="cursor : pointer;"><span class="icon-eye-open"> tampilkan</span></a></li>
								<li data-toggle="dropdown" onclick="
									$('.tab-registrasi').fadeOut('slow');
									tabControl.registrasi.registrasi = true;
								"><a style="cursor : pointer;"><span class="icon-eye-close"> sembunyikan</span></a></li>
								<li class="dropdown-header">Kelola tab operasi</li>
								<li data-toggle="dropdown" onclick="
									$('.tab-operasi').fadeIn('slow');
									tabControl.registrasi.operasi = false;
								"><a style="cursor : pointer;"><span class="icon-eye-open"> tampilkan</span></a></li>
								<li data-toggle="dropdown" onclick="
									$('.tab-operasi').fadeOut('slow');
									tabControl.registrasi.operasi = true;
								"><a style="cursor : pointer;"><span class="icon-eye-close"> sembunyikan</span></a></li>
								<li class="dropdown-header">Kelola tab status</li>
								<li data-toggle="dropdown" onclick="
									$('.tab-status').fadeIn('slow');
									tabControl.registrasi.status = false;
								"><a style="cursor : pointer;"><span class="icon-eye-open"> tampilkan</span></a></li>
								<li data-toggle="dropdown" onclick="
									$('.tab-status').fadeOut('slow');
									tabControl.registrasi.status = true;
								"><a style="cursor : pointer;"><span class="icon-eye-close"> sembunyikan</span></a></li>
							</ul>                                                                            
						</li>
					</label>
					<label style="margin : 1px; ">
						<li class="btn-group">                                    
							<button style=" cursor :pointer;" class="dropdown-toggle tip btn btn-clean btn-info" title="Kelola semua data registrasi" data-toggle="dropdown" data-original-title="Dropdown"><span class="icon-ellipsis-horizontal"> Operasi</span></button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li data-toggle="dropdown" onclick='openXLForm(base_url+"Controlresultregistrasi/getDataWithExcel")'><a style="cursor : pointer;"><span class='icon-download-alt'> Unduh (.xlsx)</span></a></li>
								<li data-toggle="dropdown" onclick='saveAllPemerataanList()'><a style="cursor : pointer;"><span class='icon-save'> Simpan distribusi</span></a></li>
								<li data-toggle="dropdown"  onclick='setOnThisPageAsForAll(2)'><a style="cursor : pointer;"><span class='icon-ok'> Setujui semua</span></a></li>
								<li data-toggle="dropdown"  onclick='setOnThisPageAsForAll(1)'><a style="cursor : pointer;"><span class='icon-time'> Menunggu semua</span></a></li>
								<li data-toggle="dropdown"  onclick='setOnThisPageAsForAll(3)' ><a style="cursor : pointer;"><span class='icon-remove'> Tolak semua</span></a></li>
								<li data-toggle="dropdown"  onclick='setOnThisPageAsJustOne(2)'><a style="cursor : pointer;"><span class='icon-ok'> Setujui yang tampil</span></a></li>
								<li data-toggle="dropdown"  onclick='setOnThisPageAsJustOne(1)'><a style="cursor : pointer;"><span class='icon-time'> Menunggu yang tampil</span></a></li>
								<li data-toggle="dropdown"  onclick='setOnThisPageAsJustOne(3)' ><a style="cursor : pointer;"><span class='icon-remove'> Tolak tampil</span></a></li>
							</ul>                                                                            
						</li>
					</label>
					<label style="margin : 1px; ">
						<select id="semester-ajaran">
							<option value="1" <?php if($smts) echo "selected"?>>Semester 1</option>
							<option value="2" <?php if($smtd) echo "selected"?>>Semester 2</option>
						</select>
					</label>
					<label style="margin : 1px;">
						<select id="tahun-ajaran">
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
						<input type="text" id="search-name-pemerataan" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
					</label>
				</div> 
			</div>
		</div>
		<div class="block" style="overflow-y : auto; max-height : 250px;"> 
			
			<div class="content">
				
				<div>
					<table class="table table-striped table-hover " style="width : 100%"> 
						<thead> 
							<tr> 
								<th style="text-align : center;">No</th>
								<th style="text-align : center;">Nama Mahasiswa</th>
								<th class="tab-registrasi" style="text-align : center;">Registrasi</th>   
								<th style="text-align : center;">Distribusi</th>
								<th style="text-align : center;">Sebelum Distribusi</th>
								<th style="text-align : center;">Log distribusi</th> 
								<th style="text-align : center;">Review</th>
								<th class='tab-status' style="text-align : center;">Status</th>
								<th class="tab-operasi" style="text-align : center;">Operasi</th>
							</tr> 
						</thead> 
						<tbody id="tabel-pemerataan-mahasiswa" style="overflow-y : auto; max-height: 250px;">  
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
				<!--
				<div class="dataTables_paginate paging_two_button" id="table-pemerataan-next-prev">
					<a class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">Previous</a>
					<a class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">Next</a>
				</div>
				-->
			</div> 
		</div>
	</div>
</div>