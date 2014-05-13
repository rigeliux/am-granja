/* <![CDATA[ */

/*
 * var args = {} Son los argumentos principales, es decir los que se generan en la primera interaccion
 * var otrosArgs = {} Son los argumentos secundarios, es decir, estos están presentes cuando se necesite pasar otras variables a otra funcion.
 *
*/

$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
    _title: function(title) {
        if (!this.options.title ) {
            title.html("&#160;");
        } else {
            title.html(this.options.title);
        }
    }
}));

	
abreDialog = function(args){
	var dialog;
	var resp = defineTipo(args);
	
	if('dialogID' in args){
		dialog = $('<div id="'+args.dialogID+'"></div>').appendTo('body');
	} else {
		if($('#dialog').length < 1){
			dialog = $('<div id="dialog"></div>').appendTo('body');
		} else {
			dialog = $('<div id="alertDialog"></div>').appendTo('body');
		}
	}
	
	dialog.html(resp.msg);
	dialog.dialog({
		modal: true,
		title: resp.titulo,
		width: "auto",
		maxWidth: 750,
		show: "fade",
		hide: "fade",
		modal: true,
		fluid: true,
		resizable:false,
		closeOnEscape: false,
		position: { my: 'top center', at: 'center', of: 'body' },
		//position: "center",
		buttons: resp.btns,
		create: resp.create,
		open: function( event, ui ){
			$.each($('.ui-dialog-buttonpane button'),function(i,e){
				var str;
				var patt=/(btn\-[a-z]+)+/gi;
				var final;
				str = $(e).attr('class');
				final = str.match(patt);
				
				if(final==null){
					final = 'btn';
				} else {
					final = 'btn '+final[0];
				}
				
				$(e).removeClass().attr('class',final);
			});
			//$('.ui-dialog-buttonpane button').blur();
			//$('.ui-dialog').css('width','');
			//dialog.dialog('option', 'position', 'center');
			setTimeout(function(){$('.ui-dialog-buttonpane button:first').blur();},500);
			justreFlow();
		},
		beforeClose: function( event, ui ){
		},
		close: function(event,ui) { 
			dialog.remove();
			//$('.ui-dialog-content').remove();
			$(window).off("resize.responsive");
			//$('#high-cont .ui-state-focus').removeClass('ui-state-focus');
			$('.loading').fadeOut('normal'); 
		}
	});
};

defineTipo = function(args){
	var raspuesta = {}
	switch(args.tipo){
		case "subseccion":
			respuesta = {
				'titulo': args.titulo,
				'msg'	: args.msg,
				'create': function(){
					$(this).closest(".ui-dialog").addClass(args.dialogID);
				}
			}
			break;
		case "eliminar":
			respuesta = {
				'titulo': 'ELIMINAR',
				'msg'	: '<div class="dialog-content"><p>¿Estas seguro que quieres eliminar este elemento?:<br><strong>'+args.nombre+'</strong></p></div>',
				'btns'	: {
							"Si": { 
								text: "Si",
								"class": "btn-danger",
								click: function() { 
									var otrosArgs = {
										//funcion	:'elimina',
										grid	:true,
										id		:args.id,
										info	:args.seccion,
										url		:'doDelete'
									}
									sendAjax(otrosArgs);
								}
							},
							"No":{ 
								text: "No",
								class: 'btn',
								click: function() { $(this).dialog("close"); }
							}
				},
				'create': function(){
					//$(this).closest(".ui-dialog").find(".ui-button").eq(0).addClass("ui-button-error");
				}
			}
			break;
		
		case "cancelar":
			respuesta = {
				'titulo': 'CANCELAR',
				'msg'	: '<div class="dialog-content"><p>¿Seguro que deseas <strong>Cancelar</strong>?</p></div>',
				'btns'	: {
							"Si": { 
								text: "Si",
								"class": 'btn-primary',
								click: function() {
									if( typeof _imgsSubidasBorrar !== "undefined" && _imgsSubidasBorrar.length > 0){
										var otrosArgs = {
											funcion	:'elimina_images',
											nomsg	:true,
											images	:JSON.stringify(_imgsSubidasBorrar),
											//url		:'asd',
											tipo	:args.seccion
										}
										sendAjax(otrosArgs);
									}
									//$(this).dialog("close");
									setTimeout(function(){ $('.ui-dialog-content').dialog("close"); },300);
								}
							},
							"No":{ 
								text: "No",
								class: 'btn',
								click: function() { $(this).dialog("close"); }
							}
						},
				'create': function(event, ui){
					//$(this).closest(".ui-dialog").find(".ui-button").eq(0).addClass("ui-button-primary");
				}
			}
			break;
			
		case "logout":
			respuesta = {
			}
			break;
		
		case "alerta-error":
			respuesta = {
				'titulo': args.titulo,
				'msg'	: '<div class="ui-widget"><div class="ui-state-error ui-corner-all"><p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span><strong>Hubo un problema con el servidor.</strong> Intente nuevamente.</p></div></div><p><strong>Error</strong>: '+args.error+'</p><p class="muted">Si el problema persiste, favor de contactar al WebMaster.</p>',
				'btns'	: {
							"Ok":{ 
								text: "Ok",
								//class: 'btn-danger',
								click: function() { $(this).dialog("close"); }
							}
						  },
				'create': function(){
							//$(this).closest(".ui-dialog").find(".ui-button").eq(0).addClass("ui-button-primary");
						  }
			}
			break;
		
		case "info":
			respuesta = {
				'titulo': args.titulo,
				'msg'	: args.msg,
				'btns'	: {
						"Ok":{ 
								text: "Ok",
								//class: 'btn-danger',
								click: function() { $(this).dialog("close"); args.extraFunc(); }
							}
				},
				'create': function(){
					//$(this).closest(".ui-dialog").find(".ui-button").eq(0).addClass("ui-button-primary");
				}
			}
			break;
	}
	
	return respuesta;
};

sendAjax = function(args){
	if(!$.isEmptyObject(args)){
		hasUrl = function(args){
			var base = 'admin/funcion';
			if('url' in args){
				//console.log('si ta');
				base+='/'+args.url;
			} else {
				//console.log('no ta');
			}
			return base;
		}
		$.ajax({
			url: hasUrl(args),
			type: 'POST',
			data: args,
			dataType: 'json',
			beforeSend: function(){
				
				if(!args.nomsg){
					if($('#dialog .loading').length > 0){
						$('#dialog .loading').fadeIn('normal');
					} else {
						$('<div class="loading" style="width:100%;height:100%;"></div>').insertAfter('#dialog');
					}
				}
			},
			error:function(jqXHR, textStatus, errorThrown){
				if(jqXHR['status']!='200'){
					var otrosArgs = {
						tipo:'alerta-error',
						titulo:'Error de XHR',
						error:jqXHR['status']+'-'+errorThrown
					}
					abreDialog(otrosArgs);
					$('#dialog .loading').fadeOut('normal');
				}
			},
			success: function(data, txtStatus){
				setTimeout(function(){ 
					
					switch(data['error']){
						case 200:
							if(!args.nomsg){
								$('#dialog .dialog-content').html(data['desc']);
								$('#dialog').dialog({ buttons: { "Cerrar": function() {
										args.grid ? tieneGrid() : '';
										$(this).dialog("close");  
								} } });
								$('#dialog').closest(".ui-dialog").find(".ui-button").eq(0).addClass("ui-button-primary");
							} else {
								console.log(data);
							}
							break;
						default:
						case 1:
							var otrosArgs = {
								tipo:'alerta-error',
								titulo:data['titulo'],
								error:data['desc']
							}
							abreDialog(otrosArgs);
							break;
					}
					$('.ui-dialog .loading').fadeOut('normal');
					
				},800);
			}
		});
	}
};

loadAsync = function(e){
	e.preventDefault();
	//var _url = _base+$(this).attr('href');
	var _url = $(this).attr('href');
	var _elem = $(this);
	var _titulo = getTituloAsync(this);
	$.ajax({
		url: _url,
		//type: 'POST',
		//data: args,
		dataType:'text',
		beforeSend: function(){
			$('#hs-source').fadeIn();
		},
		error:function(jqXHR, textStatus, errorThrown){
			if(jqXHR['status']!='200'){
				var otrosArgs = {
					tipo:'alerta-error',
					titulo:'Error de XHR',
					error:jqXHR['status']+'-'+errorThrown
				}
				abreDialog(otrosArgs);
				$('#hs-source').fadeOut('normal');
			}
		},
		success: function(data, txtStatus){
			setTimeout(function(){ 
				var otrosArgs = {
					dialogID:'content-loaded',
					tipo	:'subseccion',
					titulo	:_titulo,
					msg		:data
				}
				$('#hs-source').fadeOut('normal');
				abreDialog(otrosArgs);
			},800);
		}
	});
};

getTituloAsync = function(elem){
	var _clone = $(elem.children[0]).attr('class');
	/*
	_clone = _clone.replace('fuge-small','fuge-large');
	_clone = _clone.replace('fuge-medium','fuge-large');
	*/

	_clone = _clone.replace('fa-3x','fa-lg');

	var _newHTML = '<i class="'+_clone+'"></i> '+elem.title;
	
	return _newHTML;
};

justreFlow =  function() {
	var $visible = $(".ui-dialog:visible");
	// each open dialog
	$visible.each(function () {
		var $this = $(this);
		$this.css("width", "");
		//el nombre de DATA hay que cambiarlo dependiendo de la version de JQUERY UI
		var dialogFluid = $this.find(".ui-dialog-content").data("uiDialog");
		// if fluid option == true
		if (dialogFluid.options.maxWidth && dialogFluid.options.width) {
			// fix maxWidth bug
			$this.css("max-width", dialogFluid.options.maxWidth);
			//reposition dialog
			dialogFluid.option("position", dialogFluid.options.position);
		}

		if (dialogFluid.options.fluid) {
			// namespace window resize
			$(window).on("resize.responsive", function () {
				var wWidth = $(window).width();
				// check window width against dialog width
				if (wWidth < dialogFluid.options.maxWidth + 50) {
					// keep dialog from filling entire screen
					$this.css("width", "90%");
					
				}
			  //reposition dialog
			  dialogFluid.option("position", dialogFluid.options.position);
			});
		}

	});
};

cierraGrid = function(e){
	e.preventDefault();
	$('#content-loaded').dialog("close");
	tieneGrid();
}

/* ]]> */