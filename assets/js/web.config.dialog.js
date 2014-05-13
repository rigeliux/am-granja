

defineTipo = function(args){
	var raspuesta = {}
	switch(args.tipo){
		case "addCarrito":
			respuesta = {
				header: '',
				msg: ''
			}
			break;
			
		case "alerta-error":
			respuesta = {
				'msg'	:	'<div class="modal-header"><h3>'+args.titulo+'</h3></div>'+
							'<div class="row-fluid margin-top-2x">'+
							'	<div class="span16">'+
							'		<div class="alert alert-error">'+
							'			<p><strong>Hubo un problema con el servidor.</strong> Intente nuevamente.</p>'+
							'		</div>'+
							'		<p><strong>Error:</strong> '+args.error+'</p>'+
							'	</div>'+
							'</div>',
				'callback':	function(){
					var padre = args.padre;
					$('.loading',padre).fadeOut(function(){$('.loading',padre).remove()});
				}
			}
			break;
			
		case "general":
			respuesta = {
				'msg'	:	'<div class="modal-header no-padding"><h3>'+args.titulo+'</h3></div>'+
							'<div class="row-fluid margin-top-2x">'+
							'	<div class="span16">'+
							'		<p>'+args.msg+'</p>'+
							'	</div>'+
							'</div>',
				'callback':	function(){
					var padre = args.padre;
					$('.loading',padre).fadeOut(function(){$('.loading',padre).remove()});
				}
			}
			break;
	}
	
	
	return respuesta;
}