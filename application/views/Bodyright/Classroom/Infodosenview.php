<?php
if(!defined('BASEPATH'))
	exit('you dont have access this path');
?>
<div class="block" >
	<div class="col-md-2" style="height : 100%;">
		<img style="max-height : 100%; width: 100%;" src="<?php echo base_url()."resources/mystyle/image/undip.png";?>">
	</div>
	<div class="col-md-10">
		<div class="row">
			<div class="col-md-3">Nama </div>
			<div class="col-md-9">: <?php echo $nama;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Nip </div>
			<div class="col-md-9">: <?php echo $nip;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Bidang riset </div>
			<div class="col-md-9">: <?php echo $bidris;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Alamat </div>
			<div class="col-md-9">: <?php echo $alamat;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Email </div>
			<div class="col-md-9">: <?php echo $email;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">No telp </div>
			<div class="col-md-9">: <?php echo $notelp;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Operasi </div>
			<div class="col-md-9">: 
			<?php 
				if($mydosen){
					echo "
					<button class='btn btn-clean btn-danger' onclick='beNotMyFavorThisGuys(".'"'.$nip.'"'.",1);' title='Dosen Favorit : Ya'>
					<span class='icon-remove pointer' > batalkan</span>
					</button>";
				}else{ 
					echo "
					<button class='btn btn-clean btn-primary' onclick='beMyFavorThisGuys(".'"'.$nip.'"'.",1);' title='Dosen Favorit : Tidak'>
					<span class='icon-ok pointer'> ajukan</span>
					</button>";
				}
			?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">favorit anda </div>
			<div class="col-md-9">: 
			</div>
			<div class="col-md-12">
				<table  class="table table-striped table-hover " style="width : 100%; border : 1px solid block; padding : 0px;">
					<thead>
						<tr>
							<th style="text-align : center;">No </th>
							<th style="text-align : center;">Nip </th>
							<th style="text-align : center;">Nama </th>
							<th style="text-align : center;">Operasi </th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if($favorite == null){
						echo "
						<tr>
							<th style='padding-left : 2px; padding-right : 2px; text-align : center;'>-</th>
							<th style='padding-left : 2px; padding-right : 2px;text-align : center;'>-</th>
							<th style='padding-left : 2px; padding-right : 2px;text-align : center;'>-</th>
							<th style='padding-left : 2px; padding-right : 2px;text-align : center;'>tidak ada</th>
						</tr>";
					}else {
						foreach ($favorite as $value){
							echo "
							<tr>
								<th style='padding-left : 2px; padding-right : 2px;text-align : center;'>".$value[0]."</th>
								<th style='padding-left : 2px; padding-right : 2px;text-align : center;'>".$value[1]."</th>
								<th style='padding-left : 2px; padding-right : 2px;'>".$value[2]."</th>
								<th style='padding-left : 2px; padding-right : 2px;text-align : center;'>
									<div style='text-align : center;'>
										<div class='col-md-12'>
											<button class='btn btn-clean btn-danger' onclick='beNotMyFavorThisGuys(".'"'.$value[1].'"'.",1);' title='Dosen Favorit : Ya'>
												<span class='icon-remove pointer' style='color: red'> batalkan</span>
											</button>
										</div>
									</div>
								</th>
							</tr>";
						}
					}
					?>
					</tbody>
					
				</table>
			</div>
		</div>
	</div>
</div>