var navbarNavigation = {};
var processSomething = true;
var barSettingProfile = false;
$(document).ready(function(){
	if($(".datepickers").length>0)$(".datepickers").datepicker({nextText:"",prevText:""});
	
	/*
	navbarNavigation['form-control']=0;
	navbarNavigation['beranda'] = 1;
	setNewContentIntern("Baseberanda/getLayoutBeranda",function(){
		baseBeranda();
	},function(){},function(){});	
	*/



	$('#keluar-local').on('click',function(){
		modalStaticMultipleButton('Apakah anda yakin ingin keluar',function(){
			$(location).attr('href', base_url+"Baseroom/signOutLocalLogin");
		});
	});
	setTimeout(function(){
		if(nama_user.length > 5){
			noty({text:'Hai '+nama_user+', Selamat datang di Sistem Informasi Kegiatan Tugas Akhir ^_^'});
			setTimeout(function(){
				$.noty.closeAll();
			},5000);
		}
	},3000);
	$('#beranda-layout').on('click',function(){
		setBreadCrumb({0:'Beranda'});
		if(navbarNavigation['beranda'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['beranda']=1;
				setBreadCrumb({0:'Beranda'});
				history.pushState({},"",base_url);
				setNewContentIntern("Baseberanda/getLayoutBeranda",function(){
					baseBeranda();
				},function(){},function(){});	
			}
		}
	});
	$('#registrasi-layout').on('click',function(){
		setBreadCrumb({0:'Registrasi'});
		if(navbarNavigation['registrasi'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['registrasi']=1;
				setBreadCrumb({0:'Registrasi'});
				history.pushState({},"",base_url+"Baseroom/index/Registrasi");
				setNewContentIntern("Baseregistrasi/getLayoutRegistrasi",function(){
					baseRegistrasi();
				},function(){},function(){});	
			}
		}
	});
	$('#bantuan-layout').on('click',function(){
		bantuanLayout();
	});
	$('#seminar-layout').on('click',function(){
		setBreadCrumb({0:'Seminar'});
		if(navbarNavigation['seminar'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['seminar']=1;
				setBreadCrumb({0:'Seminar'});
				history.pushState({},"",base_url+"Baseroom/index/Seminar");
				setNewContentIntern("Baseseminar/getLayoutSeminar",function(){
					baseSeminar();
				},function(){},function(){});	
			}
		}
	});
	//routing
	resetControlNavigasi();
	switch(pageShowCore){
		case 'Seminar' :
		$('#seminar-layout').trigger('click');
		break;
		case 'Registrasi' :
		$('#registrasi-layout').trigger('click');
		break;
		default :
		$('#beranda-layout').trigger('click');
		break;
	};
	return;
});
function resetControlNavigasi(){
	navbarNavigation['beranda'] = 0;
	navbarNavigation['seminar'] = 0;
	navbarNavigation['registrasi'] = 0;
}
function openLoadingBar(a){
	setLoadingBarMessage(a);
	$('#statusbar-loading').fadeIn('slow');
}
function setLoadingBarMessage(a){
	j('#loading-pesan').setInHtml(a);
}
function closeLoadingBar(){
	$('#statusbar-loading').fadeOut('slow');
}

function setNewContentIntern(data,aa,yes,not){
	openLoadingBar("mengganti layout ...");
	$("#content-intern").slideUp('slow',function(){
		j("#content-intern").setInHtml();
		j("#setAjax").setAjax({
			methode : 'POST',
			url : base_url+data+".jsp",
			bool : true,
			content : "",
			sucOk : function(a){
				j("#content-intern").setInHtml(a.substr(1,a.length-1));
				if(a[0] == '1'){
					$('#content-intern').slideDown('slow',function(){
						aa();
					});
				}else if(a[0] == '3'){
					$('#force').on('click',function(){
						yes();
					});
					$('#next').on('click',function(){
						not();
					});
					$('#content-intern').slideDown('slow');
				}else if(a[0] == '4'){
					$('#next').on('click',function(){
						not();
					});
					$('#content-intern').slideDown('slow');
				}else{
					$('#content-intern').slideDown('slow');
				}
				closeLoadingBar()
			}
		});
	});
}