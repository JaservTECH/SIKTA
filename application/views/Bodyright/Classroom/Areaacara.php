<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>

<div class="block">
	
	<div class="header"> 
		<h2>Kalender Penggunaan Ruang</h2> 
	</div> 
	<div class="content" style="">
		<div class="form-row">
			<div class="block"> 
				<ul class="nav nav-tabs"> 
					<li class="active">
						<a href="#tab5" data-toggle="tab" id="lingk-TA1"><span title="Lingkungan Informatika" class="icon-calendar pointer"> Ruang Seminar</span></a>
					</li> 
					<li class=""><a href="#tab6" data-toggle="tab" id="lingk-TA2"><span title="Lingkungan Informatika" class="pointer icon-calendar"> Ruang Sidang</span></a></li> 
					<li class=""><a href="#tab8" data-toggle="tab" id="lingk-PUS"><span title="Lingkungan Informatika" class="pointer icon-calendar"> Ruang Puspital</span></a></li> 
				</ul> 
				<div class="content content-transparent tab-content"> 
					<div class="tab-pane active" id="tab5"> 
						<div class="form-row">
							<div class="block"> 
								<div class="header"> 
									<h2>Ruang Seminar Tugas Akhir ( <span style=' color : blue;'><a id="REF-TA1" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span> )</h2> 
								</div> 
								<div class="content" style="">
									<div id='calendar-ta-1'>
									<!--Belong calender TA 1-->
									</div>
								</div> 
								<div class="footer" style="display: none;">
								</div> 
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab6"> 
						<div class="form-row">
							<div class="block"> 
								<div class="header"> 
									<h2>Ruang Sidang Tugas Akhir ( <span style='color : blue;'><a id="REF-TA2" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span> )</h2> 
								</div> 
								<div class="content" style="">
									<div id='calendar-ta-2'>
									<!--Belong calender TA 1-->
									</div>
								</div> 
								<div class="footer" style="display: none;">
								</div> 
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab8"> 
						<div class="form-row">
							<div class="block"> 
								<div class="header"> 
									<h2>Ruang Puspital ( <span style=' color : blue;'><a id="REF-PUS" style="cursor:pointer;"><i class="icon-refresh" title="refresh calender"></i></a></span> )</h2> 
									
								</div> 
								<div class="content" style="">
									<div id='calendar-pu-s'>
									<!--Belong calender TA 1-->
									</div>
								</div> 
								<div class="footer" style="display: none;">
								</div> 
							</div>
						</div>
					</div> 
				</div> 
			</div>
		</div>
	</div> 
	<div class="footer" style="display: none;">
	</div> 
</div>
