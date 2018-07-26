<?php
if(!defined('BASEPATH'))
	exit("you dont have access to this path");
?>
<div class=block> 
	<ul class="nav nav-tabs nav-justified"> 
		<li  id="reload-seminar-ta1"  class=active ><a href=#tab11 data-toggle=tab>Seminar Tugas Akhir</a></li> 
		<li id="reload-seminar-ta2"><a href=#tab12  data-toggle=tab>Sidang Tugas Akhir</a></li> 
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id=tab11> 
			
			<div class="block">
				<div class="header"> 
					<h2>Daftar Peserta Seminar Tugas Akhir Tervalidasi (<span style=''><a onclick='
							$("#search-judul-seminar-ta1").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-judul-seminar-ta1").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div> 
				<div class="content">
					<div style="display : inline : block; text-align : right;">
						<label style="margin : 1px;">
							<input type="text" id="search-judul-seminar-ta1" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="judul acara ..."/>
						</label>
						
					</div> 
					<div style="overflow-x : hidden; overflow-y : auto; max-height : 350px; padding-bottom : 50px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr>  
									<th style="text-align: center;">No</th> 
									<th style="text-align: center;">Nama</th> 
									<th style="text-align: center;">Judul</th> 
									<th style="text-align: center;">Ruang</th> 
									<th style="text-align: center;">Waktu</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-list-public-seminar-ta1" style="overflow-y : auto; max-height: 250px;">   
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
		<div class=tab-pane id=tab12> 
			
			<div class="block">
				<div class="header"> 
					<h2>Daftar Sidang Tugas Akhir Tervalidasi (<span style=''><a onclick='
							$("#search-judul-seminar-ta2").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-judul-seminar-ta2").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>)</h2>
				</div> 
				<div class="content">
					<div style="display : inline : block; text-align : right;">
						<label style="margin : 1px;">
							<input type="text" id="search-judul-seminar-ta2" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="judul acara ..."/>
						</label>
						
					</div> 
					<div style="overflow-x : hidden; overflow-y : auto; max-height : 350px; padding-bottom : 50px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr>  
									<th style="text-align: center;">No</th> 
									<th style="text-align: center;">Nama</th> 
									<th style="text-align: center;">Judul</th> 
									<th style="text-align: center;">Ruang</th> 
									<th style="text-align: center;">Waktu</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-list-public-seminar-ta2" style="overflow-y : auto; max-height : 250px;">   
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
	</div> 
</div> 