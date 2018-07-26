var varObjectForm = {
};
varObjectForm['tempWindowOnMessage'] = function(e){

};

window.onmessage = function(event) {
 console.log(event.data);
  varObjectForm['tempWindowOnMessage'](event.data);
};





function ObjectForm(){
  if(document.getElementById('hiddenform') == null){
      var y = document.createElement('div');
      y.setAttribute('id',"hiddenform");
      y.style.display = 'none';
      document.body.appendChild(y);
  }
  if(document.getElementById('hiddenframe') == null){
      var y = document.createElement('div');
      y.setAttribute('id',"hiddenframe");
      y.style.display = 'none';
      document.body.appendChild(y);
  }
  //form conctructor
  this.idForm = "form-layout-"+document.getElementById('hiddenform').childElementCount;
  //frame conctructor
  this.idFrame = "frame-layout-"+document.getElementById('hiddenframe').childElementCount;
  this.idVar = "var-func-"+document.getElementById('hiddenframe').childElementCount;
  varObjectForm[this.idVar]={};
  varObjectForm[this.idVar]['frame-func-resp']=function(a){ alert(a)};
  var b = this.idVar;
  varObjectForm[this.idVar]['frame-func']=function(){
    try{
      varObjectForm[b+""]['frame-func-resp'](this.contentWindow.document.querySelector('body').innerHTML);
    }catch(e){
      varObjectForm['tempWindowOnMessage'] = function(e){
        varObjectForm[b+""]['frame-func-resp'](e);  
      };
      this.contentWindow.postMessage('','*');
    }
      
    
  };
  varObjectForm[this.idVar]['form-func']=function(){
    alert('form');
  };
  varObjectForm[this.idVar]['allow-automa']=false;
  varObjectForm[this.idVar]['kode-filter']=false;
  varObjectForm[this.idVar]['event-message']=function(event){
    alert("kokok"+event.data);
  };


  var x = document.createElement('iframe');
  x.setAttribute('id',this.idFrame);
  x.setAttribute('name',this.idFrame);
  document.getElementById('hiddenframe').appendChild(x);
  x = document.createElement('form');
  x.setAttribute('id',this.idForm);
  x.setAttribute('name',this.idForm);
  x.setAttribute('target',this.idFrame);
  document.getElementById('hiddenform').appendChild(x);
  document.getElementById(this.idFrame).addEventListener('load',varObjectForm[this.idVar+""]['frame-func']);
  document.getElementById(this.idForm).addEventListener('submit',varObjectForm[this.idVar+""]['form-func']);
  document.getElementById(this.idForm).addEventListener('message',varObjectForm[this.idVar+""]['event-message']);
  this.reset = function(){
	var x = document.getElementById(this.idForm);
	document.getElementById('hiddenform').removeChild(x);
	x = document.createElement('form');
    x.setAttribute('id',this.idForm);
    x.setAttribute('name',this.idForm);
    x.setAttribute('target',this.idFrame);
    document.getElementById('hiddenform').appendChild(x);
  };
  this.setFrameResponse = function(a){
    varObjectForm[this.idVar+""]['frame-func-resp']=a;
  };
  this.setAllowAutoma = function(a){
	if(a === true || a === false)
		varObjectForm[this.idVar+""]['allow-automa']=a;
  };
  this.setProperty = function(attr,value){
    document.getElementById(this.idForm).setAttribute(attr,value);
  };
  this.addText = function(name, value){
    var x = document.createElement('input');
    x.setAttribute('name',name);
    document.getElementById(this.idForm).appendChild(x);
    this.setText(name, value);
  };
  this.addFile = function(name, accept){
    var x = document.createElement('input');
    x.setAttribute('name',name);
	x.setAttribute('id',name);
	x.setAttribute('type',"file");
	x.setAttribute('accept',accept);
    document.getElementById(this.idForm).appendChild(x);
  };
  this.setFile = function(name){
	  $("#"+name).trigger('click');
  }
  this.setText = function(name, value){
    document.getElementById(this.idForm).querySelector("input[name='"+name+"']").value = value;
  };
  this.getText = function(name){
    return document.getElementById(this.idForm).querySelector("input[name='"+name+"']").value;
  };
  this.tryPost = function(){
    var event = document.createEvent('HTMLEvents');
    event.initEvent('submit', true, false);
    document.getElementById(this.idForm).submit();
  };
}
function OutputControl(){
	this.errorCore = {
		symbol : "6",
		run : function(a){
			alert('Error');
		}
	};
	this.reloadCore = {
		symbol : "&",
		run : function(){
			if(baseUrl == 'undefined') window.location.reload(true);
			else window.location = baseUrl;
		}
	};
	this.trueCore = {
		symbol : "0",
		run : function(a){
			alert('True');
		}
	};
	this.run = function(a){
		if(a[0] == this.errorCore.symbol){
			this.errorCore.run(a.substr(1,a.length-1));
		}else if(a[0] == this.reloadCore.symbol){
			this.reloadCore.run();
		}else if(a[0] == this.trueCore.symbol){
			this.trueCore.run(a.substr(1,a.length-1));
		}
	};
	return this;
};