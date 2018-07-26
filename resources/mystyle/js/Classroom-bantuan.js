function bantuanLayout(){
	baseBantuanLayout();
}
function baseBantuanLayout(){
	modalStaticSingleInformation("Bantuan",
	"<div class='accordion accordion-transparent'>"+
		"<h3>Registrasi baru dan melanjutkan</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/ynrLq7EME18" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
		"<h3>Pendaftaran Seminar dan Sidang</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/9wRwM_vXzrA" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
		"<h3>Pengaturan, Pinjam, Lihat, Dosen dan Bimbingan</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/y2KzLTXOw9s" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
	"</div>"
	);
	if($(".accordion").length>0){
		$(".accordion").accordion({heightStyle:"content"});
		$(".accordion .ui-accordion-header:last").css("border-bottom","0px");
	}
}