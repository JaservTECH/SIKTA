<?php
	if(!defined('BASEPATH'))
		exit("Tidak memiliki hak akses");
	?>
<div class="block"> 
	<div class='accordion accordion-transparent'> 
		<h3>Bimbingan</h3> 
		<div> 
			<div class="header"> 
				<h2>Mahasiswa bimbingan periode <?php 
				$temp = intval(DATE('m'));
				if($temp <=6 && $temp >= 1){
					echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester Genap";
				}else{
					echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester Gasal";
				}
				?> (<span style=''><a onclick='
						$("#search-by-name").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-by-name").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
			</div> 
			<div class="content">
				<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
					<label style="margin : 1px;">
						<input type="text" id="search-by-name" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="nama  ..."/>
					</label>
				</div> 
				<div style="overflow-y : auto; max-height : 300px;padding-bottom : 50px;">
					<table class="table table-striped table-hover "> 
						<thead> 
							<tr> 
								<th style='text-align : center;'>Nim</th>
								<th style='text-align : center;'>Nama</th> 
								<th style='text-align : center;'>Judul</th> 
								<th style='text-align : center;'>Status</th> 
								<th style='text-align : center;'>Operasi</th> 
							</tr> 
						</thead> 
						<tbody id="tabel-bimbingan-dosen" style="overflow-y : auto;">   
							<tr>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
							</tr>
						</tbody> 
					</table>
				</div> 
			</div>
		</div> 
		<h3 onclick='
						$("#search-notifikasi-cup").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-notifikasi-cup").trigger({type:"keyup", keyCode:13})'>Mengajukan Dosen Pembimbing (Pengganti FS-01)</h3> 
		<div> 
			<div class='accordion accordion-transparent'> 
				<h3  onclick='
							$("#search-notifikasi-cup").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-notifikasi-cup").trigger({type:"keyup", keyCode:13})'>Belum Ditanggapi</h3> 
				<div> 
					<div class="header"> 
						<h2>Daftar Nama Mengajukan Dosen Pembimbing (<span style=''><a onclick='
						$("#search-notifikasi-cup").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-notifikasi-cup").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
					</div> 
					<div class="content">
						<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
							
					<!-- <label style="margin : 10px; float: right;">
							<span style='font-size : 21px; color : blue;'><a onclick='
							$("#search-notifikasi-cup").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-notifikasi-cup").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
						</label>-->
							<label style="margin : 1px;">
								<input type="text" id="search-notifikasi-cup" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="nama  ..."/>
							</label>
						</div> 
						<div style="overflow-y : auto;  max-height : 300px;padding-bottom : 50px;">
							<table class="table table-striped table-hover "> 
								<thead> 
									<tr> 
										<th style='text-align : center;'>Nim</th>
										<th style='text-align : center;'>Nama</th> 
										<th style='text-align : center;'>Mahasiswa Bimbingan ?</th> 
										<th style='text-align : center;'>Operasi</th> 
									</tr> 
								</thead> 
								<tbody id="tabel-notifikasi-cup" style="overflow-y : auto;">   
									<tr>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
									</tr>
								</tbody> 
							</table>
						</div> 
					</div>
					
				</div>
				<h3 onclick='
						$("#search-proses-cup").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-proses-cup").trigger({type:"keyup", keyCode:13})'>Ditanggapi</h3> 
				<div> 
					<div class="header"> 
						<h2>Daftar Nama Mengajukan Dosen Pembimbing (<span style=''><a onclick='
						$("#search-proses-cup").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-proses-cup").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
					</div> 
					<div class="content">
						<div style="display : inline : block; text-align : right;margin-bottom : 10px;">
							
					<!--
<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='
						$("#search-proses-cup").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-proses-cup").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					-->
							<label style="margin : 1px;">
								<input type="text" id="search-proses-cup" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="nama  ..."/>
							</label>
						</div> 
						<div style="overflow-y : auto; max-height : 300px;padding-bottom : 50px;">
							<table class="table table-striped table-hover "> 
								<thead> 
									<tr> 
										<th style='text-align : center;'>Nim</th>
										<th style='text-align : center;'>Nama</th> 
										<th style='text-align : center;'>Mahasiswa Bimbingan ?</th> 
										<th style='text-align : center;'>Status Tanggapan</th> 
										<th style='text-align : center;'>Operasi</th> 
									</tr> 
								</thead> 
								<tbody id="tabel-proses-cup" style="overflow-y : auto;">   
									<tr>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
									</tr>
								</tbody> 
							</table>
						</div> 
					</div>
				</div>
			</div>
		</div> 
	</div> 
</div>