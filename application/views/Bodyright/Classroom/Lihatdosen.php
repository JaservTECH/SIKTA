<?php
if(!defined('BASEPATH'))
	exit("you dont have access to this path");
?>
<div class="block">
	<div class="header"> 
		<h2>Daftar Dosen Aktif (<span style=" color : blue;"><a onclick="refreshListDosen()" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
	</div> 
	<div class="block">
		<div class="alert alert-warning" style="opacity : 0.7; color : black; margin-bottom : 0px;">
			<b>Peringatan!</b><br>
			<ul style="list-style-type:decimal;">
				<li>Berhati-hati sebelum mengajukan</li>
				<li>Setiap perubahan akan disimpan secara otomatis</li>
				<li>Maksimal mengajukan 3 dosen (pengganti formulir FS-01)</li>
			</ul>
		</div>
	</div>
	<div class="content">
		<div style="overflow-x : hidden; overflow-y : auto; max-height : 400px;">
			<table class="table table-striped table-hover "> 
				<thead> 
					<tr> 
						<th style="text-align: center;">No</th>
						<th style="text-align: center;">Nip</th>
						<th style="text-align: center;">Nama</th> 
						<th style="text-align: center;">Operasi</th> 
					</tr> 
				</thead> 
				<tbody id="tabel-list-dosen" style="overflow-y : auto; max-height: 250px;">   
					<tr>
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