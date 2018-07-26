var NextPreVar = [];
NextPreControlClass = function(a){
	this.id = a.id;
	this.func = function(b){
		a.func(b);
	};
	this.getString = function(a){
		var j = "";
		if(a.left)
			j += '<a title="sebelumnya" class="paginate_enabled_previous" tabindex="0" role="button" id="'+this.id+'_previous" aria-controls="DataTables_Table_0">sebelumnya</a>';
		else
			j += '<a title="sebelumnya" class="paginate_disabled_previous" tabindex="0" role="button" id="'+this.id+'_previous" aria-controls="DataTables_Table_0">sebelumnya</a>';
		
		if(a.right)
			j += '<a title="selanjutnya" class="paginate_enabled_next" tabindex="0" role="button" id="'+this.id+'_next" aria-controls="DataTables_Table_0">selanjutnya</a>';
		else
			j += '<a title="selanjutnya" class="paginate_disabled_next" tabindex="0" role="button" id="'+this.id+'_next" aria-controls="DataTables_Table_0">selanjutnya</a>';
		return j;
			
	}
	NextPreVar[this.id+"_page"] = 1;
	this.getPage = function(){
		return NextPreVar[this.id+"_page"];
	};
	this.setPage = function(a){
		NextPreVar[this.id+"_page"] = parseInt(a);
	};
	this.initialize = function(a){
		var temp = this;
		$("#"+temp.id).html("");
		$("#"+temp.id).html(temp.getString(a));
		if(a.left){
			$("#"+temp.id+"_previous").on("click",function(){
				NextPreVar[temp.id+"_page"] -= 1;
				temp.func(temp.getPage());
			});
		}
		if(a.right){
			$("#"+temp.id+"_next").on("click",function(){
				NextPreVar[temp.id+"_page"] += 1;
				temp.func(temp.getPage());
			});
		}
		
	};
	
};