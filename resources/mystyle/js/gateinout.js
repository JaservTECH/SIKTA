/**
 * Author : Jafar Abdurrahan Albasyir
 * nama file : gateinout.js
 * file module : jquery.min.js
 */
//variabel global
var daftar = {};
var daftarMessage = {};
var daftarId = {
		0:'daftar-nim',
		1:'daftar-nama',
		2:'daftar-kunci',
		3:"daftar-kuncire",
		4:'daftar-apes',
		5:'daftar-ntelp',
		6:'daftar-foto',
		7:'daftar-trans',
		8:'login-nim',
		9:'login-password'
};
var tempInitILoopGlobal = 0;
var daftarIdMessage = {
		0:'Nim anda belum dimasukan',
		1:'Nama anda belum di masukan',
		2:'Kata kunci anda belum di masukan',
		3:"Kata kunci konfirmasi harus di masukan",
		4:'Alamat email anda belum dimasukan',
		5:'No telefon anda belum dimasukan',
		6:'Anda belum memilih foto Apapun',
		7:'Transkrip belum anda sertakan',
		8:'nim anda belum dimasukan',
		9:'password anda belum dimasukan'
};
//initializing global
//animation effect
$(document).ready(function(){
	//initializingMasuk();
	//initializingDaftar();
	j('#signin-layout-active').setOnClick(function(){
		$('#signInLayout').slideDown('slow');
		$('#signUpLayout').slideUp('slow');
	});
	j('#signup-layout-active').setOnClick(function(){
		$('#signInLayout').slideUp('slow');
		$('#signUpLayout').slideDown('slow');
	});
	//
	/*
	var i = 0;
	for(i = 0; i< 10; i++){
		if(i != 6 || i != 7){
			$("#"+daftarId[i]).keyup(function(event){
				if(event.keyCode == 13){
					$(this).blur();
				}
			});	
		}
	}
	for(i = 0; i< 10; i++){
		if(i != 6 || i != 7){		
			var tempI = i;
			$('#'+daftarId[tempI]).on('change',function(){
				checkInput($(this).attr('id'),$(this).val(),'Gateinout/getCheck',true);
				if(tempI == 2){
					compareValueInput("daftar-kunci","daftar-kuncire",'Kata Kunci harus sama dengan kata kunci konfirmasi');
				}
				if(tempI == 3){
					compareValueInput("daftar-kuncire","daftar-kunci",'Kata Kunci konfirmasi harus sama dengan kata kunci');
				}
			});	
		}
	}

	*/
	
	/*blur*/
	/*foto dan trans*/
	$('#daftar-foto').on('click',function(){
		$('#daftar-foto-exe').trigger('click');
	});
	$('#daftar-trans').on('click',function(){
		$('#daftar-trans-exe').trigger('click');
	});
	$("#daftar-foto-exe").change(function () {
        if (typeof (FileReader) != "undefined") {
            var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.png|.jpg)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 0.5){
						daftar['daftar-foto'] = 0;
						daftarMessage['daftar-foto'] = file[0].name+" , memiliki ukuran lebih dari 500kb";
						j('#daftar-foto-exe').setValue(null);
						openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
						return false;
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							j("#preview-foto").getObject().src = e.target.result;
							daftar['daftar-foto'] = 1;
							daftarMessage['daftar-foto'] = "Valid";
							return true;
						}
						reader.readAsDataURL(file[0]);	
					}
                } else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.JPG' || t.toLowerCase()==".jpg" || t=='.PNG' || t.toLowerCase()==".png"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 0.5){
								daftar['daftar-foto'] = 0;
								daftarMessage['daftar-foto'] = file[0].name+" , memiliki ukuran lebih dari 500kb";
								j('#daftar-foto-exe').setValue(null);
								openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
								return false;
							}else{							
								j("#preview-foto").getObject().src = e.target.result;
								daftar['daftar-foto'] = 1;
								daftarMessage['daftar-foto'] = "Valid";
								return true;	
							}
						}else{
							daftar['daftar-foto'] = 0;
							daftarMessage['daftar-foto'] = file[0].name+" , format file yang di dukung jpg atau png";
							j('#daftar-foto-exe').setValue(null);
							openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
							return false;
						}
                }
            });
        } else {
			daftar['daftar-foto'] = 0;
			daftarMessage['daftar-foto'] = "Browser anda tidak mendukung HTML5 FileReader";
			j('#daftar-foto-exe').setValue(null);
			openAlertDialogWithClick(daftarMessage['daftar-foto'],'daftar-foto-exe');
			return false;
        }
    });

	$("#daftar-trans-exe").change(function () {
        if (typeof (FileReader) != "undefined") {
            var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						daftar['daftar-trans'] = 0;
						daftarMessage['daftar-trans'] = file[0].name+" , memiliki ukuran lebih dari 1 mb";
						j('#daftar-trans-exe').setValue(null);
						openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
						return false;
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							
							daftar['daftar-trans'] = 1;
							daftarMessage['daftar-trans'] = "Valid";
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
                } else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.PDF' || t.toLowerCase()==".pdf"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
								daftar['daftar-trans'] = 0;
								daftarMessage['daftar-trans'] = file[0].name+" , memiliki ukuran lebih dari 1 mb";
								j('#daftar-trans-exe').setValue(null);
								openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
								return false;
							}else{
								daftar['daftar-trans'] = 1;
								daftarMessage['daftar-trans'] = "Valid";
								return true;
							}
						}else{
							daftar['daftar-trans'] = 0;
							daftarMessage['daftar-trans'] = file[0].name+" , format file yang di dukung pdf";
							j('#daftar-trans-exe').setValue(null);
							openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
							return false;
						}
                }
            });
        } else {
			daftar['daftar-trans'] = 0;
			daftarMessage['daftar-trans'] = "Browser anda tidak mendukung HTML5 FileReader";
			j('#daftar-trans-exe').setValue(null);
			openAlertDialogWithClick(daftarMessage['daftar-trans'],'daftar-trans-exe');
			return false;
        }
    });
	/**/
	//=>>>>executor of login
	//trigger
	$("#login-nim, #login-password").keyup(function(event){
		if(event.keyCode == 13){
			$('#login-exe').trigger('click');
		}
	});
	$("#daftar-nim, #daftar-nama, #daftar-apes, #daftar-ntelp, #daftar-kunci, #daftar-kuncire").keyup(function(event){
		if(event.keyCode == 13){
			$('#daftar-exe').trigger('click');
		}
	});
	//default
	$('#login-exe').on('click',function(){
		$(this).prop('disabled','true');
		$('#login-nim, #login-password').css('border-color',"green");
		removeAlertValidateInput(j('#login-nim').getObject());
		removeAlertValidateInput(j('#login-password').getObject());
		$('#masuk-form-validation').trigger('submit');

	});
	//<<<<<=
	$('#daftar-exe').on('click',function(){
		$(this).prop('disabled','true');
		$('#daftar-nim, #daftar-nama, #daftar-kunci, #daftar-kuncire, #daftar-apes, #daftar-ntelp, #daftar-foto, #daftar-trans').css('border-color',"green");
		removeAlertValidateInput(j('#daftar-nim').getObject());
		removeAlertValidateInput(j('#daftar-nama').getObject());
		removeAlertValidateInput(j('#daftar-kunci').getObject());
		removeAlertValidateInput(j('#daftar-kuncire').getObject());
		removeAlertValidateInput(j('#daftar-apes').getObject());
		removeAlertValidateInput(j('#daftar-ntelp').getObject());
	

		if($('#daftar-check-exe div').attr('aria-checked') == "true"){
			$('#daftar-form-validation').trigger('submit');
		}else{
			$(this).removeAttr('disabled');
			qq="Anda harus menyutujui peraturan yang berlaku, jika anda belum membaca peraturan tersebut, silahkan baca baca <a id='peraturan-link' class='text-center pointer'>disini</a>"
			openAlertDialog(qq);
			$('#peraturan-link').on('click',function(){
				$('#user-alert').modal('hide');
				$('#user-term').modal('show');
			});
		}
	});
	$('#masuk-form-validation').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnReponse = response.html();
			iframe.unbind('load');
			
			$('#login-exe').removeAttr('disabled');
			if(parseInt(returnReponse[0]) == 1){
				initializingMasuk();
				if(baseroomGoNow){	
					$('body').slideUp('slow',function(){
						$(location).attr('href',base_url+"Errororredirect/goToBaseroom");
					});
				}else{				
					$('body').slideUp('slow',function(){
						$(location).attr('href', base_url+returnReponse.substr(1,returnReponse.length-1));
					});	
				}
			}else{
				if(parseInt(returnReponse[1]) == 3){
					returnReponse = returnReponse.substr(2,returnReponse.length-2).split("|");
					addAlertValidasiInput(returnReponse[1],j('#'+returnReponse[0]).getObject());
					$('#'+returnReponse[0]).focus().css('border-color','red');
				}else{
					openAlertDialog(returnReponse.substr(1,returnReponse.length-1));
				}
			}
			setTimeout(function ()
			{
				response.html('');
			}, 1);
		});
	});
	$('#daftar-form-validation').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnReponse = response.html();
			iframe.unbind('load');
			$('#daftar-exe').removeAttr('disabled');
			if(parseInt(returnReponse[0]) == 1){
				openAlertDialog(returnReponse.substr(1,returnReponse.length-1));
				$('#signInLayout').slideDown('slow');
				$('#signUpLayout').slideUp('slow');
				initializingDaftar();
			}else{
				if(parseInt(returnReponse[1]) == 3){
					returnReponse = returnReponse.substr(2,returnReponse.length-2).split("|");
					addAlertValidasiInput(returnReponse[1],j('#'+returnReponse[0]).getObject());
					$('#'+returnReponse[0]).focus().css('border-color','red');
				}else{
					openAlertDialog(returnReponse.substr(1,returnReponse.length-1));
				}
			}
			setTimeout(function ()
			{
				response.html('');
			}, 1);
		});
	});
});
/*function*/
//count validity of total input
function totalValiditySignIn(){
	var temp = 0;
	for(var i=8;i<10;i++){
		temp += daftar[daftarId[i]];
	}
	if(temp == 2)
		return true;
	else
		return false;
	
}
function totalValidity(){
	var temp = 0;
	for(var i=0;i<8;i++){
		temp += daftar[daftarId[i]];
	}
	if(temp == 8)
		return true;
	else
		return false;
}
function initializingMasuk(){
	for(var i=8;i<10;i++){
		daftar[daftarId[i]]=0;
		daftarMessage[daftarId[i]]=daftarIdMessage[i];
		j("#"+daftarId[i]).setValue("");
		$('#'+daftarId[i]).css('border-color',"#d2d6de");
	}
}
function initializingDaftar(){
	for(var i=0;i<6;i++){
		daftar[daftarId[i]]=0;
		daftarMessage[daftarId[i]]=daftarIdMessage[i];
		j("#"+daftarId[i]).setValue("");
		$('#'+daftarId[i]).css('border-color',"#d2d6de");
	}
	j("#preview-foto").getObject().src = base_url+"Filesupport/getFotoUserDefault";
	j('#daftar-foto-exe').setValue(null);
	daftar[daftarId[6]] = 0;
	daftarMessage[daftarId[6]]=daftarIdMessage[6];
	j('#daftar-trans-exe').setValue(null);
	daftar[daftarId[7]] = 0;
	daftarMessage[daftarId[7]]=daftarIdMessage[7];
}

function compareValueInput(id1,id2,message){
	if($('#'+id2).val()!=""){
		if($('#'+id1).val()!=$('#'+id2).val()){
			daftar[id1]=0;
			daftarMessage[id1]=message;
			openAlertDialogWithFunc(daftarMessage[id1],function(){$('#'+id1).focus().css('border-color','red');});
		}else{
			daftar[id1]=1;
			daftarMessage[id1]='valid';
			$('#'+id1).css('border-color',"green");
			daftar[id2]=1;
			daftarMessage[id2]='valid';
			$('#'+id2).css('border-color',"green");
		}
	}
}
function openAlertDialog(message){
	j("#user-alert-message").setInHtml(message);
	$('#user-alert').modal({backdrop:'static'});
	var dataCloseAlert = function(){
		$("#user-alert").modal('hide');
		j("#user-alert-message").setInHtml("");
		$('#user-alert-close').unbind('click',dataCloseAlert);
	}
	$('#user-alert-close').bind('click',dataCloseAlert).focus();
}
function openAlertDialogWithFunc(message,func){
	j("#user-alert-message").setInHtml(message);
	$('#user-alert').modal({backdrop:'static'});
	var dataCloseAlert = function(){
		$("#user-alert").modal('hide');
		setTimeout(function(){
			func();
			$('#user-alert-close').unbind('click',dataCloseAlert);
			j("#user-alert-message").setInHtml("");
		},100);
	}
	$('#user-alert-close').bind('click',dataCloseAlert).focus();
}
function openAlertDialogWithClick(message,id){
	j("#user-alert-message").setInHtml(message);
	$('#user-alert').modal({backdrop:'static'});
	var dataCloseAlert = function(){
		$("#user-alert").modal('hide');
		$('#'+id).trigger('click');
		$('#user-alert-close').unbind('click',dataCloseAlert);
		j("#user-alert-message").setInHtml("");
	}
	$('#user-alert-close').bind('click',dataCloseAlert).focus();
}
function addAlertValidasiInput(message,object){
	var a=object.parentNode;
	a.childNodes[1].innerHTML = 
		"<div style='opacity: 0.87; position: absolute; top: 0px; left: 10px; margin-top: -27px;' class='alert-validation-content'>"+
		"<div class='formErrorConten'>"+message+"<br>"+
		"</div>"+
	"</div>";
}
function removeAlertValidateInput(object){
	var a=object.parentNode;
	a.childNodes[1].innerHTML = "";
}
function checkInput(switchs,value,url,kodealert){
	j("#setAjax").setAjax({
		methode : 'POST',
		url : base_url+url+".jsp",
		bool : true,
		content : "variabel="+switchs+"&value="+value,
		sucOk : function(a){
			daftar[switchs]= parseInt(a[0]);
			daftarMessage[switchs]=a.substr(1,a.length-1);
			if(daftar[switchs] == 0){
				if(kodealert){
					addAlertValidasiInput(daftarMessage[switchs],j('#'+switchs).getObject());
					$('#'+switchs).focus().css('border-color','red');
				}
				else
					$('#'+switchs).css('border-color',"red");
			}else{
				removeAlertValidateInput(j('#'+switchs).getObject());
				$('#'+switchs).css('border-color',"green");
			}
		}
	});
}
function openResetNim(){
	$('#succes-option-info').css({
		'display' : 'none'
	});
	$('#failed-option-info').css({
		'display' : 'none'
	});
	$('#user-forgot').modal('show');
}
function resetPassword(){
	$('#reset-password-form-exe').attr('disabled','true');
	if($('#reset-password-form').val() == ''){
		$('#reset-password-form-exe').removeAttr('disabled');
		return;
	}
	j("#setAjax").setAjax({
		methode : 'POST',
		url : base_url+"Gateinout/resetPassword",
		bool : true,
		content : "nim="+$('#reset-password-form').val(),
		sucOk : function(a){
			//alert(a);
			if(a[0]=='0'){
				$('#succes-option-info').css({
					'display' : 'none'
				});
				$('#failed-option-info').css({
					'display' : 'block'
				});
				$('#failed-message-info').html(a.substr(1,a.length-1));
			}else{
				//document.domain = "jafartechalgorithm.000webhostapp.com";
				var urlNow = a;
				if(RoomEmail.ajax == null){
					RoomEmail.ajax = new ObjectForm();
					RoomEmail.ajax.setProperty('method',"POST");
					RoomEmail.ajax.setProperty('action',"https://jafartechalgorithm.000webhostapp.com/index.php/Sikta/Mail");
					RoomEmail.ajax.setProperty('enctype',"multipart/form-data");
					RoomEmail.ajax.addText('kode',"");
					RoomEmail.io = new OutputControl();
					RoomEmail.io.errorCore = {
						symbol : '0',
						run : function(a){
							$('#succes-option-info').css({
								'display' : 'none'
							});
							$('#failed-option-info').css({
								'display' : 'block'
							});
							$('#failed-message-info').html(a);
						}
					};
					RoomEmail.io.trueCore = {
						symbol : '1',
						run : function(a){
							$('#succes-option-info').css({
								'display' : 'block'
							});
							$('#failed-option-info').css({
								'display' : 'none'
							});
							$('#succes-message-info').html(a);
							$('#reset-password-form').val("");
						}
					};
					RoomEmail.ajax.setFrameResponse(function(a){
						RoomEmail.io.run(a);
						$('#reset-password-form-exe').removeAttr('disabled');
						//document.domain = RoomEmail.RoomTemp;
					});
					
				}
				RoomEmail.ajax.setText("kode", urlNow);
				RoomEmail.ajax.tryPost();

			}
		}
	});
}

var RoomEmail = {
	ajax : null,
	io : null,
	RoomTemp : document.domain+""
};