function bantuanLayout(){
	baseBantuanLayout();
}
function baseBantuanLayout(){
	modalStaticSingleInformation("Bantuan",
	"<div class='accordion accordion-transparent'>"+
		"<h3>Acara</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/-QeAQ9H4MjQ" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
		"<h3>Dosen</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/2IfiBMIAioU" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
		"<h3>Kelola Registrasi</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/SP7e4yc1Jls" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
		"<h3>Kelola Seminar dan Sidang</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/3njcLvul1gA" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
		"<h3>Kelola Mahasiswa</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/yMdqeZ8iX_Q" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
		"<h3>Pengaturan</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/nCA9IxwbCw0" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
	"</div>"
	);
	if($(".accordion").length>0){
		$(".accordion").accordion({heightStyle:"content"});
		$(".accordion .ui-accordion-header:last").css("border-bottom","0px");
	}
}