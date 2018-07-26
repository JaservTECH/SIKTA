<?php
if(!defined('BASEPATH'))
	exit("you dont have access to this path");
?>
<div class="block">
	<div class="header"> 
		<h2>Daftar peserta yang melakukan registrasi dan sudah di verifikasi Tugas Akhir (<span style=''><a onclick='
						$("#search-name-info-public").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-info-public").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
	</div> 
	<div class="content">
		<div style="display : inline : block; text-align : right;">
					<label style="margin : 1px;">
						<input type="text" id="search-name-info-public" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="pencarian berdasarkan nim, nama, judul maupun nama dosen" placeholder="Ketikan sesuatu ..."/>
					</label>
		</div> 
		<div style="overflow-x : hidden;overflow-y : auto; max-height : 350px; ">
			<table class="table table-striped table-hover "> 
				<thead> 
					<tr> 
						<th style="text-align: center;">No</th> 
						<th style="text-align: center;">Nim</th> 
						<th style="text-align: center;">Nama</th> 
						<th style="text-align: center;">Judul</th> 
						<th style="text-align: center;">Dosen</th> 
						<th style="text-align: center;">Status</th> 
						
					</tr> 
				</thead> 
				<tbody id="tabel-imfo-public-registrasi" style="overflow-y : auto;">   
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
		<div class="dataTables_paginate paging_two_button" id="table-registrasi-next-prev">
			<a class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">Previous</a>
			<a class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">Next</a>
		</div> 
	</div>
	
</div>