var ajax  = {
	selectorName : 'form',
	selector: '',
	method: 'post',
	data: [],
	dataTyape: 'json',
	url:'',
	formObj:null,
	init: function(param=null){ alert("hello");
		ajax.formSubmit();
	},
	formSubmit:function(){
		$('button').on('click', function(e){
			ajax.clickButton = $(this).data('type');	
		});
	}

}