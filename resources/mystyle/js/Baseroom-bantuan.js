function bantuanLayout(){
	baseBantuanLayout();
}
function baseBantuanLayout(){
	modalStaticSingleInformation("Bantuan",
	"<div class='accordion accordion-transparent'>"+
		"<h3>Pengaturan dan halaman kalender acara</h3>"+
		'<div>'+
			'<iframe style="width : 100%; height : 315px;" src="https://www.youtube.com/embed/558ZA8CNrU4" frameborder="0" allowfullscreen></iframe>'+
		'</div>'+
	"</div>"
	);
	if($(".accordion").length>0){
		$(".accordion").accordion({heightStyle:"content"});
		$(".accordion .ui-accordion-header:last").css("border-bottom","0px");
	}
}