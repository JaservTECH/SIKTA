<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
<div class="block"> 
	<div class="header"> 
		<div>
			<h2>Daftar Dosen (<span ><a onclick='
						$("#search-dosen").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-dosen").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
		</div>
	</div> 
	<div class="content">
	
		<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
			<label id="label-semester-ajaran" style=" margin : 1px;">
				<button class="btn btn-clean btn-success" id="add-new-dosen" title='tambahkan dosen' onclick="addNewDosen();"><span class="icon-plus"> tambahkan</span></button>
			</label>
			<label id="label-semester-ajaran" style=" margin : 1px;">
				<input type="text" id="search-dosen" title='cari dosen berdasarkan nama' pattern="[a-zA-Z0-9 @.]{0,50}" placeholder="Nama Dosen ..."/>
			</label>
		</div> 
		<div style="overflow-y : auto; max-height : 400px;"  class="table-responsive">
			<table class="table table-striped table-hover"> 
			<thead> 
				<tr> 
					<th style="text-align : center;">No</th> 
					<th style="text-align : center;">Nip</th> 
					<th style="text-align : center;">Nama Dosen</th>
					<th style="text-align : center;">Bidang</th>
					<th style="text-align : center;">Mahasiswa Bimbingan</th>
					<th style="text-align : center;">Status</th> 
				</tr> 
			</thead> 
			<tbody id="data-table-dosen">  
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tbody> 
		</table>
		</div>  
		<div class="dataTables_paginate paging_two_button" id="table-dosen-next-prev">
			<a title='sebelumnya' class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">sebelumnya</a>
			<a title='selanjutnya' class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">selanjutnya</a>
		</div> 
	</div> 
</div>
<div class="block">
	
</div>