<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>
<div class="col-md-2" id="setting-left-1" style="display : none;">
	<div class="block block-drop-shadow"> 
		<div class="head bg-dot30 npb"> 
			<h2>foto profil</h2> 			
			<div class="pull-right"> 
				<button class="btn btn-default btn-clean" id="ubah-gambar" onclick="ubahGambarFoto()"><span><i class="icon-upload-alt"></i></span></button>
			</div>
		</div>
		<div class="head bg-dot30 np tac"> 
			<img src=<?php echo $image;?> class="img-thumbnail img-circle" id="gambar-upload"> 
		</div> 
		<div class="content controls"> 
			<div class="form-row"> 
				<div class="col-md-12"> 
					<input type="text" class="form-control" id="support-nama" placeholder="Nama Mahasiswa" disabled> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-12"> 
					<input type="text" class="form-control" id="support-nim" placeholder="Nim Mahasiswa" disabled> 
				</div> 
			</div> 
		</div> 
	</div>
</div>
		