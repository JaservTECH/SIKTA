var initializingNewChart = false;
var chacheJavascriptChart = null;
var tahunForPemerataan = null;
var semesterForPemerataan = null;
var namaForPemerataan = null;
var pageApprove = 1;
var totalListPemerataanAktive = 0;
var nimListPemerataanAktive = "";
var initChangeColumn = false;
var chacheRegistrasiControlGlobal = {
	eventOnLoad : 0,
	eventDetail : {
		loadTable : false,
		loadChart : false,
	}
};
function reloadRegistrasiPemerataan(){
	if(tabControl.registrasi == null){
		tabControl.registrasi = {
			registrasi : false,
			status : false,
			operasi : false
		};
	}
	if(tahunForPemerataan!=null)
		$("#tahun-ajaran").val(tahunForPemerataan);
	if(semesterForPemerataan != null)
		$("#semester-ajaran").val(semesterForPemerataan);
	if(namaForPemerataan != null)
		$("#search-name-pemerataan").val(namaForPemerataan);
	initChangeColumn = true;
	initializingNewChart = false;
	refreshTablePemerataanDanChart();
	$("#search-name-pemerataan").keyup(function(event){
		if(!chacheRegistrasiControlGlobal.eventDetail.loadTable && !chacheRegistrasiControlGlobal.eventDetail.loadChart){
			if(event.keyCode == 13){
				pageApprove = 1;
				initializingNewChart = false;
				chacheChartVariabelGlobal.eventOnLoad=0;
				refreshTablePemerataanDanChart();
			}
		}
		else{
			modalStaticSingleWarning("Diagram dan tabel pemerataan sedang dalam proses, silahkan ulangi beberapa waktu lagi");
		}
	});
}
function refreshTablePemerataanDanChart(){
	tahunForPemerataan = $("#tahun-ajaran").val();
	semesterForPemerataan = $("#semester-ajaran").val();
	namaForPemerataan = $("#search-name-pemerataan").val();
	reloadChart();
	reloadTable();
}
function showPesan(ctv){
	modalStaticSingleInformation("Pesan Perubahan",
	"<div style='padding : 10px; text-align : center;'>"+$(ctv).attr('data-pesan')+"</div>"
	);
}
function filterRow(ctv){
	if(ctv.value == 'all'){
		$('.all-row').fadeIn('slow');
	}else{
		$('.all-row').fadeOut('slow');
		var tempChooseFilterRow = ctv.value;
		$('.data-distribusi').each(function(){
			if(this.value == tempChooseFilterRow){
				var tt = this.parentNode;
				var tt = tt.parentNode;
				var tt = tt.parentNode;
				var tt = tt.parentNode;
				$(tt).fadeIn('slow');
				//console.log(tt);
			}
		});
	}
}
function reloadChart(){
	chacheRegistrasiControlGlobal.eventOnLoad+=1;
	chacheRegistrasiControlGlobal.eventDetail.loadChart=true;
	openLoadingBar("mengambil diagram ...");
	if(!initializingNewChart){
		initializingNewChart = true;
		j('#setAjax').setAjax({
			methode : 'POST',
			url : base_url+'Controlresultregistrasi/getJsonTableNow',
			bool : true,
			content : "kode=JASERVCONTROL&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan,
			sucOk : function(a){
				if(a[0]=='1'){
					setLoadingBarMessage("response diagram diproses ...");
					chacheJavascriptChart = JSON.parse(a.substr(1,a.length-1));
					reloadTableChart();
				}else{
					setLoadingBarMessage("response diagram gagal  ...");
				}
				setTimeout(function(){
					chacheRegistrasiControlGlobal.eventOnLoad-=1;
					chacheRegistrasiControlGlobal.eventDetail.loadChart=false;
					if(chacheRegistrasiControlGlobal.eventOnLoad == 0)
						closeLoadingBar();
				},800);
			},
			sucEr : function(a,b){
				
			}
		});
		return;
	}
	//setLoadingBarMessage("response diagram diproses ...");
	//closeLoadingBar();
}
function reloadTableChart(){
	j('#controller-diagram').setInHtml("");
	chacheChartVariabelGlobal.title.text = "Diagram Pemerataan Distribusi";
	chacheChartVariabelGlobal.xAxis.categories = chacheJavascriptChart.data[0];
	chacheChartVariabelGlobal.yAxis.title.text = "Total bimbingan";
	chacheChartVariabelGlobal.series = [{
		name : "Total Bimbingan",
		data : chacheJavascriptChart.data[1]
	}];
	Highcharts.chart('controller-diagram',chacheChartVariabelGlobal);
}
var randomScalingFactor = function(){ 
	return Math.round(Math.random()*100)
};
var lineChartData = {
	labels : ["Adit","February","john","jojo","May","June","July","Adit","February","john","jojo","May","June","July","Adit","February","john","jojo","May","June","July"],
	datasets : [
	{
		label: "My First dataset",
		fillColor : "rgba(20,20,20,0.1)",
		strokeColor : "#666",
		pointColor : "rgba(20,20,220,0.8)",
		pointStrokeColor : "#fff",
		pointHighlightFill : "#fff",
		pointHighlightStroke : "rgba(220,220,220,1)",
		data : [89,67,23,54,56,21,24,89,67,23,54,56,21,24,89,67,23,54,56,21,24]
	}]
}
function openXLForm(url){
	var year = $('#tahun-ajaran').val();
	var semester = $('#semester-ajaran').val();
	var xx = document.createElement("a");
	xx.target = "_blank";
	xx.href = url+"/"+year+""+semester;
	xx.click();
}
function resetDiagram(){
	j('#controller-diagram').setInHtml("");
	//j('#controller-diagram').setInHtml("<canvas id='canvas' height='450' width='2048' style='color: rgba(220,220,200,1);'></canvas>");
}
function reloadTable(){
	chacheRegistrasiControlGlobal.eventOnLoad+=1;
	chacheRegistrasiControlGlobal.eventDetail.loadTable=true;
	$('.tab-registrasi').fadeIn('slow');
	$('.tab-operasi').fadeIn('slow');
	$('.tab-status').fadeIn('slow');
	openLoadingBar("refresh tabel ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : base_url+"Controlresultregistrasi/getPemerataanListMahasiswa",
		bool : true,
		content : "kode=controlroom&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&key="+namaForPemerataan+"&page="+pageApprove,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage('proses data ...');
				a=a.split("|");
				j('#tabel-pemerataan-mahasiswa').setInHtml(a[0].substr(1,a[0].length-1));
				//j('#table-pemerataan-next-prev').setInHtml(a[1]);
				totalListPemerataanAktive = parseInt(a[2]);
				nimListPemerataanAktive = "";
				if(totalListPemerataanAktive > 0){
					nimListPemerataanAktive = a[3].split(",");
				}
				if(initChangeColumn){
					initChangeColumn = false;
					$("#tahun-ajaran").on('change',function(){
						pageApprove = 1;
						initializingNewChart = false;
						refreshTablePemerataanDanChart();
					});
					$("#semester-ajaran").on('change',function(){
						pageApprove = 1;
						initializingNewChart = false;
						refreshTablePemerataanDanChart();
					});
				}
				$('#filter-row').trigger('change');
				if(tabControl.registrasi.registrasi) $('.tab-registrasi').fadeOut('slow');
				if(tabControl.registrasi.operasi) $('.tab-operasi').fadeOut('slow');
				if(tabControl.registrasi.status) $('.tab-status').fadeOut('slow');
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				chacheRegistrasiControlGlobal.eventOnLoad-=1;
				chacheRegistrasiControlGlobal.eventDetail.loadTable=false;
				if(chacheRegistrasiControlGlobal.eventOnLoad == 0)
					closeLoadingBar();
				//reloadChart();
			},600);
		}
	});
}
function previousPageRegistrasiBase(){
	pageApprove-=1;
	reloadTable();
}
function nextPageRegistrasiBase(){
	pageApprove+=1;
	reloadTable();
}
function changeValueOfDosenOnChart(nip,cat){
	tempI = 0;
	while(chacheJavascriptChart.data[2][tempI]){
		//alert(chacheJavascriptChart.data[2][tempI]+" "+nip);
		if(chacheJavascriptChart.data[2][tempI] == nip){
			switch(cat){
				case '+' : chacheJavascriptChart.data[1][tempI] = (parseInt(chacheJavascriptChart.data[1][tempI]) + 1); break;
				case '-' : chacheJavascriptChart.data[1][tempI] = (parseInt(chacheJavascriptChart.data[1][tempI]) - 1); break;
			}
		}
		tempI++;
	}
}
function changeDospem(nim,id,tempRight){
	//console.log(id.oldvalue+" "+id.value);
	//alert(id.value+" "+id.oldvalue);
	var tempNama = id.parentNode;
	var tempDosenS = "";
	var tempDosenD = "";
	tempNama = tempNama.parentNode;
	tempNama = tempNama.parentNode;
	tempNama = tempNama.parentNode;
	tempNama = tempNama.childNodes[3].innerHTML;
	console.log(id.selectedIndex);
	if(parseInt(id.value) == 0){
		if(tempRight.value == "-"){
			tempRight.value = id.oldvalue;
			if(parseInt(id.oldvalue) == 0)
				openLoadingBar("Dosen pebimbing "+tempNama+" dihapuskan");
			else{
				tempDosenS = $(id).find("option[value="+id.oldvalue+"]").text();
				openLoadingBar("Dosen pebimbing "+tempNama+", "+tempDosenS+" dihapuskan");
			}
		}else{
			if(parseInt(id.oldvalue) == 0)
				openLoadingBar("Dosen pebimbing "+tempNama+" dihapuskan");
			else{
				tempDosenS = $(id).find("option[value="+id.oldvalue+"]").text();
				openLoadingBar("Dosen pebimbing "+tempNama+", "+tempDosenS+" dihapuskan");
			}
		}
	}else{
		if(tempRight.value == "-"){
			tempRight.value = id.oldvalue;
			if(parseInt(id.oldvalue) == 0){
				tempDosenS = $(id).find("option[value="+id.value+"]").text();
				openLoadingBar(tempDosenS+" dipilihkan sebagai dosen pembimbing "+tempNama);
			}else{
				tempDosenS = $(id).find("option[value="+id.oldvalue+"]").text();
				tempDosenD = $(id).find("option[value="+id.value+"]").text();
				openLoadingBar(tempDosenD+" dipilihkan sebagai dosen pembimbing "+tempNama+" pengganti "+tempDosenS);
			}
		}else if(tempRight.value == id.value){
			tempRight.value = "-";
			tempDosenS = $(id).find("option[value="+id.value+"]").text();
			openLoadingBar(tempDosenS+" dijadikan kembali dosen pembimbing "+tempNama);
		}
	}
	setTimeout(function(){
		closeLoadingBar();
	},5000);
	
	
	/* 
	if(parseInt(id.value) == 0){
		if(parseInt(tempRight.value) == 0 || tempRight.value == "-"){
			//tempRight.value = id.oldvalue;
			if(parseInt(id.oldvalue) == 0)
				tempRight.value = "-";
			else
				tempRight.value = id.oldvalue;
		}
	}else{
		changeValueOfDosenOnChart(id.value,"+");
		if(parseInt(tempRight.value) == 0 || tempRight.value == "-"){
			if(parseInt(id.oldvalue) == 0)
				tempRight.value = "-";
			else
				tempRight.value = id.oldvalue;
		}else if(tempRight.value == id.value){
			tempRight.value = 0;
		}
		/* if(parseInt(tempRight.value) == 0){
			tempRight.value = id.oldvalue;
		}else if(tempRight.value == id.value){
			tempRight.value = 0;
		}*
	} */
	if(parseInt(id.oldvalue) != 0){
		changeValueOfDosenOnChart(id.oldvalue,"-");
		if(parseInt(id.value) != 0){
			changeValueOfDosenOnChart(id.value,"+");
		}
	}else{
		if(parseInt(id.value) != 0){
			changeValueOfDosenOnChart(id.value,"+");
		}
	}
	id.oldvalue = id.value;
	//after some change dospem we need to refresh list may be filter active in one account but data dosen different
	$('#filter-row').trigger('change');
	reloadTableChart();
}
function saveAllPemerataanList(){
	openLoadingBar("Merespon permintaan penyimpanan perubahan dosen pembimbing ...");
	if(totalListPemerataanAktive <= 0){
		setLoadingBarMessage("Daftar tabel registrasi tidak tersedia");
		setTimeout(function(){
			closeLoadingBar();
		},800);
		return;
	}
	nim = "";
	nip = "";
	dataNimNip = 0;
	for(tempI = 1; tempI <= totalListPemerataanAktive;tempI++){
		if(document.getElementById('select-satu-'+tempI)){
			if(document.getElementById('select-dua-'+tempI)){
				if(document.getElementById('select-dua-'+tempI).value != "-"){
					nim += nimListPemerataanAktive[tempI-1]+",";
					nip += document.getElementById('select-satu-'+tempI).value+",";
					dataNimNip++;
				}
			}
			/* if(document.getElementById('select-dua-'+tempI).value != 0){
				
			} */
		}
	}
	//alert(nim+" "+nip+" "+dataNimNip);
	nim = nim.substr(0,nim.length-1);
	nip = nip.substr(0,nip.length-1);
	if(dataNimNip>1){
		tempSenDospem(nim,nip,'two');
	}else if(dataNimNip == 1){
		tempSenDospem(nim,nip,'one');
	}else{
		setLoadingBarMessage("Tidak ada perubahan dosen pembimbing");
		setTimeout(function(){
			closeLoadingBar();
		},800);
	}
	return;
}
function tempSenDospem(nim,nip,kode){
	chacheRegistrasiControlGlobal.eventDetail.loadTable=true;
	chacheRegistrasiControlGlobal.eventDetail.loadChart=true;
	openLoadingBar("Merespon permintaan perubahan dosen pembimbing ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : base_url+"Controlresultregistrasi/setDospem",
		content : "nim="+nim+"&nip="+nip+"&kode=JASERVCONTROL&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&kodes="+kode,
		bool : true,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage("Proses perubahan dosen pembimbing berhasil dilakukan ...");
				setTimeout(function(){
					closeLoadingBar();
					initializingNewChart = false;
					reloadChart();
					reloadTable();
				},800);	
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+' ...');
				setTimeout(function(){
					closeLoadingBar();
					initializingNewChart = false;
					reloadChart();
					reloadTable();
				},800);	
			}
		},
		sucEr : function(a,b){
			chacheRegistrasiControlGlobal.eventDetail.loadTable=false;
			chacheRegistrasiControlGlobal.eventDetail.loadChart=false;
		}
	});
}
function setOnThisPageAsJustOne(tempKodeSTM){
	openLoadingBar("Merespon permintaan perubahan halaman yang tampil ...");
	if(totalListPemerataanAktive <= 0){
		setLoadingBarMessage("Daftar tabel registrasi tidak tersedia ...");
		setTimeout(function(){
			closeLoadingBar();
		},800);
		return;
	}
	nipFilter = $("#filter-row").val();
	nim = "";
	messageReturn = "Daftar tabel registrasi tidak tersedia ...";
	dataNimNip = 0;
	for(tempILoopNow = 1; tempILoopNow <= totalListPemerataanAktive;tempILoopNow++){
		if(document.getElementById('select-satu-'+tempILoopNow)){
			if(document.getElementById('select-dua-'+tempILoopNow)){
				if(nipFilter == "all" || nipFilter == document.getElementById('select-satu-'+tempILoopNow).value){
					if(document.getElementById('select-dua-'+tempILoopNow).value == "-"){
						nim += nimListPemerataanAktive[tempILoopNow-1]+",";
						dataNimNip++;
					}else{
						messageReturn = "Terdapat perubahan dosen pembimbing yanng belum disimpan ...";
					}
				}
			}
		}else{
			//exception if ditolak because select id has hidden
			nim += nimListPemerataanAktive[tempILoopNow-1]+",";
			dataNimNip++;
		}
	}
	//alert(nim+" "+nip+" "+dataNimNip);
	nim = nim.substr(0,nim.length-1);
	if(dataNimNip == 0){
		setLoadingBarMessage(messageReturn);
		setTimeout(function(){
			closeLoadingBar();
		},800);
		return;
	}
	j("#setAjax").setAjax({
		methode:"POST",
		url : base_url+"Controlresultregistrasi/setStatus",
		bool : true,
		content : "nim="+nim+"&kodeS="+tempKodeSTM,
		sucOk : function(a){
			if(a[0] == '1'){
				modalStaticSingleInformation("Hasil Perubahan","<div style='padding : 10px;'>"+a.substr(1,a.length-1)+"</div>");
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				pageApprove = 1;
				initializingNewChart = false;
				chacheChartVariabelGlobal.eventOnLoad=0;
				refreshTablePemerataanDanChart();
			},1500);
		}
	});
}

function setOnThisPageAsForAll(tempKodeSTM){
	openLoadingBar("Merespon permintaan perubahan semua status registrasi ...");
	if(totalListPemerataanAktive <= 0){
		setLoadingBarMessage("Daftar tabel registrasi tidak tersedia ...");
		setTimeout(function(){
			closeLoadingBar();
		},800);
		return;
	}
	nim = "";
	messageReturn = "Daftar tabel registrasi tidak tersedia ...";
	dataNimNip = 0;
	for(tempILoopNowAll = 1; tempILoopNowAll <= totalListPemerataanAktive;tempILoopNowAll++){
		var ghj = document.getElementById('select-satu-'+tempILoopNowAll);
		if(document.getElementById('select-satu-'+tempILoopNowAll)){
			if(document.getElementById('select-dua-'+tempILoopNowAll)){
				if(document.getElementById('select-dua-'+tempILoopNowAll).value == "-"){
					nim += nimListPemerataanAktive[tempILoopNowAll-1]+",";
					dataNimNip++;
				}else{
					messageReturn = "Terdapat perubahan dosen pembimbing yanng belum disimpan ...";
				}
			}
		}else{
			//exception if ditolak because select id has hidden
			nim += nimListPemerataanAktive[tempILoopNowAll-1]+",";
			dataNimNip++;
		}
	}
	//alert(nim+" "+nip+" "+dataNimNip);
	nim = nim.substr(0,nim.length-1);
	if(dataNimNip == 0){
		setLoadingBarMessage(messageReturn);
		setTimeout(function(){
			closeLoadingBar();
		},800);
		return;
	}
	j("#setAjax").setAjax({
		methode:"POST",
		url : base_url+"Controlresultregistrasi/setStatus",
		bool : true,
		content : "nim="+nim+"&kodeS="+tempKodeSTM,
		sucOk : function(a){
			if(a[0] == '1'){
				modalStaticSingleInformation("Hasil Perubahan","<div style='padding : 10px;'>"+a.substr(1,a.length-1)+"</div>");
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				pageApprove = 1;
				initializingNewChart = false;
				chacheChartVariabelGlobal.eventOnLoad=0;
				refreshTablePemerataanDanChart();
			},1500);
		}
	});
	/* openLoadingBar("Merespon permintaan perubahan semua status registrasi ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : "Controlresultregistrasi/setAllEveryRegister",
		bool : true,
		content : "kode=controlroom&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&key="+namaForPemerataan+"&page="+pageApprove+"&kodeS="+tempKodeSTM,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage("Proses perubahan status registrasi berhasil dilakukan ...");
				modalStaticSingleInformation("Hasil Perubahan","<div style='padding : 10px;'>"+a.substr(1,a.length-1)+"</div>");
				reloadTable();
			}else
				setLoadingBarMessage('Terjadi kesalahan saat melakukan perubahan status registrasi ...');
			setTimeout(function(){
				closeLoadingBar();
			},800);
		}
	}); */
}
/*
openLoadingBar("Merespon permintaan data mahasiswa yang dipilih ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : base_url+'Controlresultregistrasi/getInfoMahasiswaFull',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+a+"&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("Data mahasiswa berhasil dimuat ...");
				openModalContactWide(a.substr(1,a.length-1),"Tentang Mahasiswa");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"sesi info mahasiswa");
		}
	});
*/
var tempChacheDetailOfThisGuys = {
	data : [],
	indexActive : 0,
	temp : {
		nim : "",
		before : "",
		change : false
	}
}
function refreshDataDetailOfThisGuys(){
	var tempNim = tempChacheDetailOfThisGuys.data[tempChacheDetailOfThisGuys.indexActive];
	$('#button2-poiter-control').attr('disabled',true);
	$('.button-poiter-control').addClass('disabled');
	$('#nim-active-detail').html(tempNim);
	$("#template-krs").html('');
	$("#template-krs").html('<embed style="width : 100%; height : 450px;" src="'+base_url+"Filesupport/getKRS/"+tempNim+"/"+tahunForPemerataan+""+semesterForPemerataan+".jsp"+'" >');
	$("#template-transkrip").html('');
	$("#template-transkrip").html('<embed style="width : 100%; height : 450px;" src="'+base_url+"Filesupport/getTranskrip/"+tempNim+".jsp"+'" >');
	$("#image-detail-this-guy").attr("src", base_url+'filesupport/getPhotoMahasiswaProfil/'+tempNim+".aspx");
	$('#button2-poiter-control').attr('idmhs',tempNim);
	$('#button2-poiter-control').val($("#"+tempNim+"-status").val());
	tempChacheDetailOfThisGuys.temp.before = $("#"+tempNim+"-status").val();
	j('#setAjax').setAjax({
		methode : 'POST',
		url : base_url+'Controlresultregistrasi/getInfoMahasiswaFull',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+tempNim+"&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan,
		sucOk : function(a){
			//alert(a);
			$('.button-poiter-control').removeClass('disabled');
			//$('#button2-poiter-control').removeAttr('disabled');
			if(a[0]=='1'){
				setLoadingBarMessage("Data mahasiswa berhasil dimuat ...");
				var ggJK = JSON.parse(a.substr(1,a.length-1));
				$('#nama-detail-this-guy').val(ggJK.nama);
				$('#nim-detail-this-guy').val(ggJK.nim);
				$('#peminatan-detail-this-guy').val(ggJK.minat);
				$('#nohp-detail-this-guy').val(ggJK.notelp);
				$('#email-detail-this-guy').val(ggJK.email);
				$('#status-detail-this-guy').val(ggJK.statusTA);
				$('#judul-detail-this-guy').html(ggJK.judulTA);
			}else{
				
			}
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"sesi info mahasiswa");
		}
	});
}
function reloadDataDetail(vBn){
	
	switch(vBn){
		case '+' :
		tempChacheDetailOfThisGuys.indexActive+=1;
		if(tempChacheDetailOfThisGuys.indexActive == tempChacheDetailOfThisGuys.data.length){
			tempChacheDetailOfThisGuys.indexActive = 0;
		}
		break;
		case '-' :
		tempChacheDetailOfThisGuys.indexActive-=1;
		if(tempChacheDetailOfThisGuys.indexActive == tempChacheDetailOfThisGuys.data.length){
			tempChacheDetailOfThisGuys.indexActive = 0;
		}
		break;
		default:
		alert("you're suck man hehe peace jaserv");
	}
	refreshDataDetailOfThisGuys();
}
function linkToChangeState(cGht){
	var tempNimS = $(cGht).attr('idmhs');
	$("#"+tempNimS+"-status").val(cGht.value);
	$("#"+tempNimS+"-status").trigger('change');
	tempChacheDetailOfThisGuys.temp.change = true;
	tempChacheDetailOfThisGuys.temp.nim = tempNimS;
}
function detailThisGuys(a){
	var idMHSChoose = a;
	var tempChooseFilterRow = $('#filter-row').val();
	tempChacheDetailOfThisGuys.indexActive = 0;
	tempChacheDetailOfThisGuys.data = [];
	var indexEd = 0;
	$('.data-distribusi').each(function(){
		if(this.value == tempChooseFilterRow || tempChooseFilterRow == 'all'){
			tempChacheDetailOfThisGuys.data.push($(this).attr('idmhs'));
			if($(this).attr('idmhs') == idMHSChoose){
				tempChacheDetailOfThisGuys.indexActive = indexEd;
			}
			indexEd++;

		}
	});
	//alert(tempChacheDetailOfThisGuys.data);
	var xLK = 
	'<div class="list list-contacts" id="content-contact-wide">'+
		'<div class="block">'+
			'<div class="container">'+
				'<div class="row" style="margin-bottom : 4px;">'+
					'<div class="col-md-12">'+
						"<div class='text-center'>"+
							'<ul class="pagination">'+
								'<li class=" button-poiter-control"><a class="pointer" onclick="reloadDataDetail('+"'-'"+')"><span class="icon-angle-left"></span></a></li>'+
								'<li class="active"><a id="nim-active-detail"></a></li>'+
								'<li class=" button-poiter-control"><a class="pointer" onclick="reloadDataDetail('+"'+'"+')"><span class="icon-angle-right"></span></a></li>'+
							'</ul>'+
						"</div>"+
					'</div>'+
					'<div class="col-md-2">'+
						'<img style="max-height : 100%; width: 100%;" id="image-detail-this-guy" src="">'+
					'</div>'+
					'<div class="col-md-4">'+
						'<div class="row" style="margin-bottom : 4px;">'+
							'<div class="col-md-2">Nama </div>'+
							'<div class="col-md-10"><input type="text" disabled style="border : none;" id="nama-detail-this-guy" placeholder="Nama mahasiswa"></div>'+
						'</div>'+
						'<div class="row" style="margin-bottom : 4px;">'+
							'<div class="col-md-2">Nim </div>'+
							'<div class="col-md-10"><input type="text" disabled style="border : none;" id="nim-detail-this-guy" placeholder="Nim mahasiswa"></div>'+
						'</div>'+
						'<div class="row" style="margin-bottom : 4px;">'+
							'<div class="col-md-2">Peminatan </div>'+
							'<div class="col-md-10"><input type="text" disabled style="border : none;" id="peminatan-detail-this-guy" placeholder="Peminatan mahasiswa"></div>'+
						'</div>'+
						'<div class="row" style="margin-bottom : 4px;">'+
							'<div class="col-md-2">Peminatan </div>'+
							'<div class="col-md-10"><input type="text" disabled style="border : none;" id="email-detail-this-guy" placeholder="Email mahasiswa"></div>'+
						'</div>'+
						'<div class="row" style="margin-bottom : 4px;">'+
							'<div class="col-md-2">Peminatan </div>'+
							'<div class="col-md-10"><input type="text" disabled style="border : none;" id="nohp-detail-this-guy" placeholder="Nohp mahasiswa"></div>'+
						'</div>'+
						'<div class="row" style="margin-bottom : 4px;">'+
							'<div class="col-md-2">Status TA </div>'+
							'<div class="col-md-10"><input type="text" disabled style="border : none;" id="status-detail-this-guy" placeholder="Status ta"></div>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-4">'+
						'<div class="row" style="margin-bottom : 4px;">'+
							'<div class="col-md-2">Judul TA </div>'+
							'<div class="col-md-10"><textarea type="text" disabled style="border : none; height : 80px; resize : none;" id="judul-detail-this-guy">Judul ta</textarea></div>'+
						'</div>'+
						'<div class="row" style="margin-bottom : 4px; text-align : center;" >'+
							'<div class="col-md-2"> </div>'+
							'<div class="col-md-10">'+
								'<select style="min-width : 70px;" onchange="linkToChangeState(this);" idmhs="" id="button2-poiter-control"><option value="1">Menunggu</option><option selected="" value="2">Disetujui</option><option value="3">Ditolak</option>'+
								'</select>'+
							'</div>'+
						'</div>'+
					'</div>'+
				"</div>"+
				'<div class="row">'+
					'<div class="col-md-6">'+
						'<div><h6 style="text-align : center;">KRS</h6></div>'+
						'<div id="template-krs">'+
							'<embed src="" >'+
						'</div>'+
					"</div>"+
					'<div class="col-md-6">'+
						'<div><h6 style="text-align : center;">Transkrip</h6></div>'+
						'<div id="template-transkrip">'+
							'<embed src="" >'+
						'</div>'+
					"</div>"+
				"</div>"+
			"</div>"+
		"</div>"+
	"</div>"
	;
	openModalContactWide(xLK,"Info Pengecekan Mahasiswa");
	refreshDataDetailOfThisGuys();
}
function detailThisDospem(a,x){
	nip = document.getElementById('select-satu-'+x).value;
	if(nip == "0")
		return;
	openLoadingBar("Merespon permintaan data dosen yang dipilih ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : base_url+'Controlresultregistrasi/getInfoDosenFull',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+a+"&nip="+nip,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("Data dosen berhasil dimuat ...");
				openModalContact(a.substr(1,a.length-1),"Tentang Mahasiswa");
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
function detailCompareThisGuysWithDospem(a,x){
	
	nip = document.getElementById('select-satu-'+x).value;
	if(nip == "0")
		return;
	openLoadingBar("Merespon permintaan data perbandingan ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : base_url+'Controlresultregistrasi/getInfoDosenAndMahasiswaComparasiFull',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+a+"&nip="+nip+"&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("Data permintaan berhasil dimuat ...");
				openModalContact(a.substr(1,a.length-1),"Tentang Mahasiswa");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"info data perbandingan");
		}
	});
}
function changeDataProses(aaa,b){
	openLoadingBar("Merespon perubahan status registrasi yang dipilih ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : base_url+'Controlresultregistrasi/setStatus',
		//url : 'Controlresultregistrasi/setStatusMahasiswaRegister',
		bool : true,
		content : "nim="+aaa+"&kodeS="+b,
		sucOk : function(a){
			if(a[0]=='1'){
				if(!tempChacheDetailOfThisGuys.temp.change)
					modalStaticSingleInformation("Hasil Perubahan","<div style='padding : 10px;'>"+a.substr(1,a.length-1)+"</div>");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			if(tempChacheDetailOfThisGuys.temp.change){
				tempChacheDetailOfThisGuys.temp.change = false;
				var jkjk = a.search("gagal dirubah");
				if(jkjk != -1){
					if( $('#button2-poiter-control').length )         // use this if you are using id to check
					{
						$('#button2-poiter-control').val(tempChacheDetailOfThisGuys.temp.before);
					}
					
				}
			}
			setTimeout(function(){
				pageApprove = 1;
				initializingNewChart = false;
				chacheChartVariabelGlobal.eventOnLoad=0;
				refreshTablePemerataanDanChart();
			},1050);
		},
		sucEr : function(a,b){
			template(a,b,"sesi status register");
		}
	});
}