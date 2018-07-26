function mainListDosen(){
	refreshListDosen();
}
function beNotMyFavorThisGuys(v,cc){
	openLoadingBar("proses men-non-favorit-kan");
	j('#setAjax').setAjax({
		methode : "POST",
		url : base_url+"Classdosenpreview/setNotLikeThisGuys",
		bool : true,
		content : "kode=JASERVTECH-KODE&nip="+v,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("proses berhasil  ...");
				setTimeout(function(){
					closeLoadingBar();
					hideModalContact(function(){
						refreshListDosen();
					});
					if(cc == 1)
						seeThisGuys(dataActive);
				},750);
			}else{
				setLoadingBarMessage("proses gagal  ...");
				setTimeout(function(){
					setLoadingBarMessage(a.substr(1,a.length-1));
					setTimeout(function(){
						closeLoadingBar();
					},750);
				},500);
			}
		},
		sucEr : function(a,b){
			template(a,b,"sesi proses non-favor");
		}
	});
}
function beMyFavorThisGuys(v,cc){
	openLoadingBar("proses men-favorit-kan");
	j('#setAjax').setAjax({
		methode : "POST",
		url : base_url+"Classdosenpreview/setLikeThisGuys",
		bool : true,
		content : "kode=JASERVTECH-KODE&nip="+v,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("proses berhasil  ...");
				setTimeout(function(){
					closeLoadingBar();
					hideModalContact(function(){
						refreshListDosen();
					});
					if(cc == 1)
						seeThisGuys(dataActive);
				},750);
			}else{
				setLoadingBarMessage("proses gagal  ...");
				setTimeout(function(){
					setLoadingBarMessage(a.substr(1,a.length-1));
					setTimeout(function(){
						closeLoadingBar();
					},750);
				},500);
			}
		},
		sucEr : function(a,b){
			template(a,b,"sesi proses favor");
		}
	});
}
function refreshListDosen(){
	openLoadingBar("mengambil data");
	j('#setAjax').setAjax({
		methode : "POST",
		url : base_url+"Classdosenpreview/getTableListDosen",
		bool : true,
		content : "kode=JASERVTECH-KODE",
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				j('#tabel-list-dosen').setInHtml(a.substr(1,a.length-1));
			}else{
				setLoadingBarMessage("response gagal  ...");
			}
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"sesi list table");
		}
	});
}
var dataActive = 0;
function seeThisGuys(a){
	dataActive = a;
	openLoadingBar("mengambil data dosen");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : base_url+'Classdosenpreview/getInfoDosenFull',
		bool : true,
		content : "kode=JASERVTECH-KODE&nip="+a,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				openModalContact(a.substr(1,a.length-1),"Tentang Dosen");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"sesi info dosen");
		}
	});
}