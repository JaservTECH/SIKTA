<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
<div class="block"> 
	<div class="header"> 
		<div>
			<h2>Rekapitulasi Dosen (<span ><a onclick='
						$("#search-name-rekapitulasi").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-rekapitulasi").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
		</div>
	</div> 
	<div class="content">
	
		<div style="display : inline : block; text-align : right;">
			<label style="margin : 1px;">
				<li class="btn-group">                                    
					<button style=" cursor :pointer;" class="dropdown-toggle tip btn btn-clean btn-info" title="Kelola rekapitulasi" data-toggle="dropdown" data-original-title="Dropdown"><span class="icon-ellipsis-horizontal"> Operasi</span></button>
					<ul class="dropdown-menu" role="menu">
						<li title='unduh rekap dalam bentuk excel' data-toggle="dropdown" onclick='openXLRekap(base_url+"/Controlrekap/getDataWithExcel")'><a style="cursor : pointer;"><span class='icon-download-alt'> Unduh (.xlsx)</span></a></li>
					</ul>                                                                            
				</li>
			</label>
			<label id="label-semester-ajaran" style=" margin : 1px;margin-bottom : 10px;">
				<select id="semester-ajaran" title='semester akademik'>
					<!--<option value="0" selected>satu tahun ajaran</option>-->
					<option value="1" <?php if($srt[4] == '1') echo 'selected';?>>Semester 1</option>
					<option value="2" <?php if($srt[4] == '2') echo 'selected';?>>Semester 2</option>
				</select>
			</label>
			<label style="margin : 1px;">
				<select id="tahun-ajaran" onchange="checkSemesterOnRekap(this)" title='tahun akademik'>
					<?php 
					$year= intval(substr($srt,0,4));
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
				<!--<a style="position : absolute; color : #666666; font-size : 22px; right : 0; margin-right : 26px;" class="pointer" onclick="hello()"><i class="icon-search"></i></a>-->
				<input title='cari berdasarkan nama' type="text" id="search-name-rekapitulasi" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
			</label>
		</div> 
		<div style="overflow-y : auto; max-height : 300px;"  class="table-responsive">
			<table class="table table-striped table-hover"> 
			<thead> 
				<tr> 
					<th style='text-align : center;'>No</th> 
					<th style='text-align : center;'>Nip</th> 
					<th style='text-align : center;'>Nama Dosen</th> 
					<th style='text-align : center;'>Jumlah Bimbingan</th> 
					<th style='text-align : center;'>Jumlah Menguji</th>
					<th style='text-align : center;'>Jumlah Lulusan</th> 
				</tr> 
			</thead> 
			<tbody id="data-table-rekap">  
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tbody> 
		</table>
		</div> 
		<div class="dataTables_paginate paging_two_button" id="table-rekap-next-prev">
			<a title='sebelumnya' class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">sebelumnya</a>
			<a title='selanjutnya' class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">selanjutnya</a>
		</div> 
	</div> 
</div>
<div class="block">
	
</div>