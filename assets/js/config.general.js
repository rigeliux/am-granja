/* <![CDATA[ */
var _base;
var botonInit = function(jQueryObj){
	jQueryObj.button().on({
		mouseleave: function(){
			$(this).removeClass('ui-state-focus');
		},
		mousedown: function(){
			$(this).removeClass('ui-state-focus');
		}
	});
	
	return jQueryObj;
};

var recargaGrid = function(jQueryObj){
	
}

if (typeof console === "undefined"){
    console={};
    console.log = function(){
        return;
    }
}

var recarga = function(){
	 parent.location.reload();
}

jQuery(function($){

	_base = $('.sitebase').attr('href');
	var _loadingBody = $('body .first-loading');
	setTimeout(function(){ _loadingBody.fadeOut(); },800);
	$('.addNew').on('click',loadAsync);
	$(document).on('click','.nofollow',function(e){ return false; });
	$(document).on('click','.ui-state-disabled',function(e){ return false; });
	$(document).on('click','.high-img',function(e){ e.preventDefault(); return hs.expand (this, config2); });
	//$('.addNew').on('click',function(e){ e.preventDefault(); return hs.htmlExpand(this, config1); });
	$(document).on('click','.btn-group .editar',loadAsync);
	$(document).on('click','.btn-group .eliminar',function(e){
		var _data = $(this).data('identificador');
		var args = { 
			tipo:	'eliminar',
			nombre:	_data.nombre,
			id:		_data.id,
			seccion:_data.seccion
		}
		abreDialog(args);
	});
	$('.logout').on('click',function(e){
		e.preventDefault();
		$.ajax({
			url: 'admin/funcion/doLogout',
			type: 'POST',
			dataType:'json',
			beforeSend: function(){
				_loadingBody.fadeIn('normal');
			},
			error:function(jqXHR, textStatus, errorThrown){
				if(jqXHR['status']!='200'){
					var args = { tipo:'alerta-error',titulo:data['titulo'],error:data['msg'] }
					abreDialog(args);
				}
			},
			success: function(data, txtStatus){
				setTimeout(function(){ 
					switch(data['error']){
						case 104: //no encontro usiaro o pass
							var args = { tipo:'alerta-error',titulo:data['titulo'],error:data['msg'] }
							abreDialog(args);
							break;
						case 0: //no hubo error
							var args = { 
								tipo:	'info',
								titulo:	'Salir del sistema',
								msg:	data['msg'],
								extraFunc: recarga
							}
							abreDialog(args);
							break;
						case 203: //problema
							var args = { tipo:'alerta-error',titulo:data['titulo'],error:data['msg'] }
							abreDialog(args);
							break;
						default: //cualquier otra cosa
						case 1:
							var args = { tipo:'alerta-error',titulo:data['titulo'],error:data['msg'] }
							abreDialog(args);
							break;
					}
					_loadingBody.fadeOut('normal');
				},800);
			}
		});
	});
});

/* ]]> */