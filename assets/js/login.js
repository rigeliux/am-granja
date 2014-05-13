var hola = function(){
	$.ajax({
					url: 'funcion/micasa',
					type: 'POST',
					data: {funcion:'hiii'},
					dataType: 'json',
					error:function(jqXHR, textStatus, errorThrown){
						if(jqXHR['status']!='200'){
							creaDialog('Problemo Peroblemooo.','Error de XHR','alert-error');
							$('.loading').fadeOut('normal');
						}
					},
					success: function(data, txtStatus){
						setTimeout(function(){ 
							switch(data['error']){
								case 104: //no encontro usiaro o pass
									$('.alert',form).html(data['desc']).fadeIn();
									break;
								case 0: //no hubo error
									$('.alert',form).removeClass('alert-error').addClass('alert-success').fadeIn().html(data['desc']);
									setTimeout(function(){ parent.location.reload(); },1500);
									break;
								case 203: //problema
									$('.alert',form).html(data['desc']).fadeIn();
									break;
								default: //cualquier otra cosa
								case 1:
									creaDialog(data['desc'],'Error General');
									break;
							}
							$('.loading').fadeOut('normal');
						},800);
					}
				});
};

function creaDialog(msg,titulo,clases){
		if(!titulo){
			titulo = 'Heads UP!';
		}
		var _cuerpo ='\
		<div id="modal" class="modal hide fade '+clases+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
			<div class="modal-header">\
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
				<h3 id="myModalLabel">'+titulo+'</h3>\
			</div>\
			<div class="modal-body">\
				<p>'+msg+'</p>\
			</div>\
			<div class="modal-footer">\
				<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>\
			</div>\
		</div>\
		';
		modal = $(_cuerpo).appendTo('body');
		//modal.html($msg+$form);
		modal.modal({
			keyboard: false,
			backdrop: 'static'
		});
		modal.on('hidden',function(e){
			modal.remove();
		});
		//modal.modal('toggle');
	}
jQuery(function($){
	var _redir = $('input[name="redirectTo"]').val();
	$('#usuario').focus();
	
  	if($('.error').length > 0){
  		$('.error').fitText(0.4);
  		$('.desc').fitText(8, {minFontSize: '16px'});
  	}
	
	if($('.validate').length > 0){
		$('.validate').validate({
			errorPlacement:function(error, element){
				element.parent().parent().append(error);
				error.addClass('errorHidden');
	 		},
	 		// Bootstrap style error highlight
	 		highlight: function(label, a) {
		    	$(label).closest('.control-group').removeClass('error success').addClass('error');
		    },
			success: function(label) {
		    	label.addClass('valid').closest('.control-group').removeClass('error success').addClass('success');
		    },
			meta: 'validate',
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					url: 'admin/funcion/doLogin',
					//data: {funcion:'buscar'},
					type: 'POST',
					dataType: 'json',
					beforeSubmit: function(){
						$('.alert',form).fadeOut(function(){
							if($('.loading').length > 0){
								$('.loading').fadeIn('normal');
							} else {
								$('<div class="loading" style="width:100%;height:100%;"></div>').insertAfter(form);
							}
						});
					},
					error:function(jqXHR, textStatus, errorThrown){
						if(jqXHR['status']!='200'){
							creaDialog('Problemo Peroblemooo.','Error de XHR','alert-error');
							$('.loading').fadeOut('normal');
						}
					},
					success: function(data, txtStatus){
						setTimeout(function(){ 
							switch(data['error']){
								case 104: //no encontro usiaro o pass
									$('.alert',form).html(data['desc']).fadeIn();
									break;
								case 0: //no hubo error
									$('.alert',form).removeClass('alert-error').addClass('alert-success').fadeIn().html(data['desc']);
									setTimeout(function(){
										if(_redir!=''){
											location.href=_redir;
										}else{
											parent.location.reload();
										}
									},1500);
									break;
								case 203: //problema
									$('.alert',form).html(data['desc']).fadeIn();
									break;
								default: //cualquier otra cosa
								case 1:
									creaDialog(data['desc'],'Error General');
									break;
							}
							$('.loading').fadeOut('normal');
						},800);
					}
				});
				return false;
			}
		});
	}
});