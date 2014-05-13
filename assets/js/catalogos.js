/* <![CDATA[ */
var imagen,
	_listaImgsUp,
	_listadeSubidas,
	_imgsSubidas = new Array(),
	_imgsSubidasBorrar = new Array(),
	_imgsPool=new Array(),
	$filesext;

$.fn.modal.Constructor.prototype.enforceFocus = function () {};

var loadingLayer = {
	put: function(_element){
		if( $('.loading',_element).length > 0 ){
			$('.loading',_element).fadeIn();
		} else {
			_element.append('<div class="loading" style="width:100%; height:100%;"></div>');
		}
	},
	remove: function(_element){
		setTimeout(function(){
			$('.loading',_element).fadeOut();
		},500);
	}
}

var selectAnidadoHelper = {
	devuelveInfo: function( obj,id ){
		var _devuelto = Array();
		$.each(obj,function(i,v){
			if(v.pertenece == id){
				_devuelto.push(v);
			}
		});
		return _devuelto;
	},

	devuelveHtml: function(colleccion){
		var _html='<option value="">Seleccione una</option>';
		$.each(colleccion,function(i,v){
			_html+='<option value="'+v.id+'">'+v.nombre+'</option>';
		});
		
		return _html;
	},

	selectChange: function(e){
		
		var _jsonData = e.data.valores;								//array con todos los arrays
		var _select = $(this).val();								//valor seleccionado
		var _anidado = $('select[name="'+e.data.anidado+'"]');		//nombre del select a modificar
		var _nombre_anidado = e.data.nombre_anidado; 				//nombre del array que vamos a iterar.
		var _nombreTemp = e.data.nombre_temp; 						//valor que se pondra en el select anidado cuando no se selccione nada.
		var _subanidado_nombre = e.data.subanidado || '';			//si hay subanidado.
		
		if(_select!=''){
			var _selArray = _jsonData[_nombre_anidado];				//este es el array que vamos a iterar.
			
			var _arrayCondensado = devuelveInfo(_selArray,_select);	//este es el array de solo los valores que si correspondieron
			var _html= devuelveHtml(_arrayCondensado);
			
			_anidado.empty().append(_html);
		} else {
			_anidado.empty().append('<option value="">'+_nombreTemp+'</option>');
			if(_subanidado_nombre!=''){
				var _subanidado_temp = e.data.subanidado_temp;
				$.each(_subanidado_nombre,function(i,v){
					var _subanidado = $('select[name="'+v+'"]');
					_subanidado.empty().append('<option value="">'+_subanidado_temp[i]+'</option>');
				});
			}
		}
	}
}



var uploadDefaults = {
	auto			: false,
	buttonClass		: 'upldf',
	buttonText		: 'Agregar Foto',
	fileType		: 'image',
	multi			: false,
	queueID			: 'upload-queue',
	removeCompleted	: true,
	simUploadLimit	: 1,
	truncateLength	: 35,
	uploadScript	: 'admin/upload',

	onInit: function(){
		_imgsSubidas.length = 0;
		_imgsSubidasBorrar.length = 0;
		_imgsPool.length = 0;
	},

	onAddQueueItem: function(file){
		reader = new FileReader();
		reader.onload = (function(theFile) {
			return function(e) {
				// Render thumbnail.
				var _queue = $('.uploadifive-queue-item');
				
				$('.uploadifive-queue-item').filter(function() {
					return $(this).data('file').name == theFile.name;
				}).find('.preview').find('img').attr('src',e.target.result);
			};
		})(file);
		reader.readAsDataURL( file );
		$('#guardar').removeClass('btn-primary').addClass('disabled').prop('disabled',true);
	},

	onCancel: function() {
		
		if($('#upload-queue').children().length<=1){
			
			$('#guardar').removeClass('disabled').addClass('btn-primary').prop('disabled',false);
		}
	},

	onUploadComplete: function(file, data) { 
		var _newData = $.parseJSON(data),
			_objData = {};

		_objData.nombre = _newData.file_name;
		_objData.raw = _newData.raw_name;
		_objData.esVideo = false;

		_imgsSubidas.push(_objData);
		_imgsSubidasBorrar.push(_newData.file_name);	//ingresa al array todas las imagenes subidas, que se borraran si se cancela.
		_imgsPool.push(_newData.file_name);				//ingresa al array de imagenes que se implosionaran y agregaran al campo para enviar
	}
}

var arrayRecursive = function(_obj,_srchString){

	for (_i = 0; _i < _obj.length; ++_i) {
		if(_obj[_i].id ==_srchString){
			//console.log(_obj[_i]);
			return _obj[_i];
		}
	}
}

var uploadHelper = {
	/*
	_lista = Array de imagenes
	_args = Variables que indican tipo de imagen y thumbs
	*/
	armaListaFotos: function(_lista,_args){
		var _self = this,
			_count = _lista.length,
			_html;

		if($('#fotos-lista').css('display')=='block'){  
			$('#fotos-lista').slideUp('fast'); 
		}
		if(_count > 0){
			_html ='<ul id="sortable">';
			$.each(_lista,function(i,v){
				_html += '<li id="'+v.raw+'" '+(v.extraData ? 'data-extra=\''+JSON.stringify(v.extraData)+'\'':'')+'>';
				_html += 	'<div class="fotos-lista">';
				_html += 		'<div class="eliminaImg"><a href="#'+v.nombre+'"></a></div>';
				if(v.esVideo){
					_html +=		'<img src="http://img.youtube.com/vi/'+v.nombre+'" data-esvideo="'+v.esVideo+'" class="fotos-img">';
				} else {
					_html +=		'<img src="assets/images/'+_args.tipo+'/thumb-80x80/'+v.nombre+'" data-esvideo="'+v.esVideo+'" class="fotos-img">';
				}
				_html += 	'</div>';
				_html += '</li>';	
			});
			
			_html += '</ul>';	
			
			setTimeout(function(){ 
				if($('.uploadify-queue').css('display')=='block'){ $('.uploadify-queue').slideUp('fast'); }
				if($('#fotos-lista').css('display')=='none'){  $('#fotos-lista').slideDown('fast'); }
				$('#fotos-lista').empty().append(_html);
				//$('#upfotos').val(_imgsPool.join());
				
				$('#guardar').prop('disabled',false);
			},500);
			
			setTimeout(function(){ 
				//justreFlow();
				_self.eliminarImagen();
				_self.activarSorteable();
			},900);
		}
	},

	/*
	_args = Variables que indican tipo de imagen y thumbs. Se origina de la funcion al completar la cola de subidas
	*/ 
	eliminarImagen: function(){
		$('.eliminaImg a').on('click',function(e){
			e.preventDefault();
			
			var _elemPadre = $(this).parents('li'),
				_idElem = _elemPadre.attr('id'),
				_contFoto = _elemPadre,
				_imagen = arrayRecursive(_imgsSubidas,_idElem),
				_args = {};
				
			var postData = {
					imagen : {
						funcion:'elimina_imagen_once_new',
						imagen: _imagen,
						tipo:_args.tipo || false
					}
				}

			var _bootboxConfig = {
				header: "Eliminar Imagen",
				msg: "¿Desea quitar la imagen: <strong>"+_imagen.nombre+"</strong>?",
				procede: function(){
					_contFoto.fadeOut('fast',function(){ 
						_contFoto.remove();
						uploadHelper.creaArraydeSortable( $('#sortable') );
					});
					return true;
					/*
					$.post('admin/funcion/',postData,function(data){
						$contFoto.fadeOut('fast',function(){ 
							$(this).remove();
							creaArraydeSortable( $('#sortable') );
						});
						return true;
					},'JSON');
					*/

				}
			}

			bootboxHelper.confirmarAlt(_bootboxConfig);

		});
	},

	activarSorteable: function(_input='#upfotos'){
		var _self = this;

		$('#sortable').sortable({
			placeholder: "ui-state-highlight",
			create: function( event, ui ) {
				_self.creaArraydeSortable( $(this),_input );
			},
			stop:function(i) {
				_self.creaArraydeSortable( $(this),_input );
			}
		});
		//cortable = $('#sortable').sortable('toArray');							
		$('#sortable').disableSelection();
	},

	creaArraydeSortable: function(obj,_input='#upfotos'){
		var cortable = obj.sortable('toArray'),
			_this = obj,
			_inputElem = $(_input);

		_imgsSubidas.length = 0;
		_imgsPool.length = 0;

		$.each(cortable,function(index,data){
			var _id = data.replace('.jpg',''),
				_padre = $('#'+_id,_this),
				_esVid = _padre.find('img').data('esvideo') || false,
				_nombre,
				_extraData = _padre.data('extra') || false;
			
			if(_esVid){
				_nombre = _id.replace('__','/')+'.jpg';
			} else {
				_nombre = data+'.jpg';
			}
			
			var imageData = {
				'nombre': _nombre,
				'id': _id,
				'raw':_id,
				'esVideo': _esVid,
				'extraData': _extraData
			};
			
			_imgsSubidas.push(imageData);
			_imgsPool.push(_nombre);
		});

		_inputElem.val(_imgsPool.join());
	}


}

var bootboxHelper = {
	confirmar: function(_args){
		return bootbox.dialog(_args.msg, [
					{
						"label" : "Si",
						"class" : "btn-primary",
						"callback": _args.procede || false
					},
					{
						"label": "No",
						"class": "btn-danger",
						"callback":  _args.denega || false
					}
				],
				{
					"header": _args.header
				}
			)
	},
	confirmarAlt: function(_args){
		return bootbox.dialog(_args.msg, [
					{
						"label" : "Si",
						"class" : "btn-danger",
						"callback": _args.procede || false
					},
					{
						"label": "No",
						//class: "btn-danger",
						"callback": _args.denega || false
					}
				],
				{
					"header": _args.header
				}
			)
	},
	alertar: function(){
		return bootbox.alert('hi');
	}
}
	
jQuery(function($){
	
	$(document).on('dialogopen',function( event, ui ){
		var _this;
		var _ee = event;
		_this = event.target;
		$('.target',_this).validate();
		
		$('.direccion',_this).validate({
			submitHandler: function(form) {
				var txt,
					input,
					inputval,
					delBoton,
					dir = $('input[name="dir"]',form).val(),
					estado = $('select[name="estado"]',form).val(),
					estado_nom = $('select[name="estado"] option:selected').text(),
					ciudad = $('select[name="ciudad"]',form).val(),
					ciudad_nom = $('select[name="ciudad"] option:selected').text(),
					cp = $('input[name="cp"]',form).val();
				
				var _padre = $('.dir-resul table'),
					_newElem = $('tr',_padre).length;
					//_dial = _this.parents('.ui-dialog-content');
				
				inputval = {
					direccion: dir,
					estado: estado,
					estado_nom: estado_nom,
					ciudad: ciudad,
					ciudad_nom: ciudad_nom,
					cp: cp
				}
				
				input = "<input type='hidden' name='usuarios[direccion][]' value='"+JSON.stringify(inputval)+"'>";
				delBoton = '<button type="button" class="btn btn-danger remove" ><i class="icon icon-trash"></i></button>';
				txt = '<tr><td>'+dir+'. '+ciudad_nom+', '+estado_nom+'. C.P:'+cp+input+'</td><td>'+delBoton+'</td></tr>';
				
				_padre.append(txt);
				//$(delBoton,_padre).on('click',activaRemove);
				$(_this).dialog("close");
				
				return false;
				
			}
		});
		
		$('.cancelar').off('click').on('click',function(e){
			var _tthis = $(this);
			var seccion = _tthis.data('identificador').seccion;
			var aCerrar = _tthis.parents('.ui-dialog-content') || 0;
			//console.log(_tthis);
			var args = {
					tipo:'cancelar',
					seccion: seccion
				}
			if(aCerrar!=0){
				args.elemACerrar = aCerrar;
			}
			abreDialog(args);
			return false;
		});
		
		$('.cerrar').off('click').on('click',function(e){
			var aCerrar = $(this).parents('.ui-dialog-content') || 0;
			//console.log(seccion);
			
			if(aCerrar!=0){
				aCerrar.dialog("close");
			}
			
			return false;
		});
		
		if($('input[name="ciudadesVals"]').length>0){
			var _elem = $('input[name="ciudadesVals"]'),
				_values = $.parseJSON(_elem.val());
			
			$('select[name="usuarios[estado]"]').on('change',{
				valores			:_values,
				anidado			:'usuarios[ciudad]',
				nombre_anidado	:'ciudades',
				nombre_temp		:'Seleccione un estado'
			},selectChange);
			
		}
		
		if($('select[name="descuento[tipo]"]').length>0){
			$('select[name="descuento[tipo]"]').on('change',function(e){
				var _this = $(this),
					_val = $('option:selected',_this).text(),
					_padre = $(this).parents('.row-fluid'),
					_newVal;
				
				_newVal = _val.substr( (_val.length-3),1);
				_padre.find('.add-on').html(_newVal);
			});
			
		}
		
		/*if($('select.minSel').length>0){
			$('select.minSel').each(function() {
				$(this).rules('add', {
					minSel: 1
				});
			});
		}*/
		 
		$('.rButton').buttonset();
		
		setTimeout(function(){	$('#high-cont .loading').fadeOut(); },1000);
	});
	
	$(document).on('dialogopen','#content-loaded',function( event, ui ){
		$('.addAddress').on('click',{loading:true},loadAsync);

		$('#contenido').tabs({
			create: function( event, ui ){
				$('#contenido ul').removeClass('ui-corner-all');
			}
		});
		
		if($('.addPass').length>0){
			$('.addPass').on('click',function(e){
				var _pass = $.password(6,false),
					inpt = $(this).parents('div.control-group').find('input');
				inpt.val(_pass);
			});
		}
		
		$('#content-loaded').on('click','.remove',function(e){
			var _this = $(this),
				_elemRemove = _this.parents('tr'),
				_nombre = _elemRemove.find('td').eq(0).text();
			
			var args = {
				nombre: _nombre,
				tipo: 'eliminar-simple',
				callback: function(){
					_elemRemove.fadeOut(function(){ _elemRemove.remove(); });
				}
			}
			abreDialog(args);
		});
		
		if( $('#high-cont .slim').length>0 && $('#high-cont .slim').height()>250 ){
			
			$('#high-cont .slim').slimScroll({
				//height: '330px',
				//allowPageScroll: true
				//alwaysVisible: true,
				//disableFadeOut: true
			});
		}
		
		if($('.raty').length>0){
			$('.raty').raty({
				score: function() { return $(this).attr('data-score'); },
				scoreName: function() { return $(this).attr('data-name'); },
				path: 'assets/images/admin/',
				halfShow: false,
				size: 24,
				starOff: 'star-big-off.png',
				starOn : 'star-big-on.png'
			});
		}
		
		if($('#bannerfoto').length>0){

			var _upload = uploadDefaults;
			_upload.multi = true;
			_upload.formData = {
					'thumbs': ['720x137','940x440'],
					'tipo'	: 'slides'
			};

			_upload.onQueueComplete = function(uploads){
				
				var html ='<img src="assets/images/slides/thumb-720x137/'+_imgsPool[0]+'">';
				setTimeout(function(){ 
					$('#upfotos').val(_imgsPool.join());
					$('#fotos-lista').empty().append(html);
					//$('#high-cont .loading').fadeOut(); 
					
				},500);
				setTimeout(function(){ 
					$('#guardar').removeClass('disabled').addClass('btn-primary').prop('disabled',false);
					justreFlow();
				},900);
			};

			$('#bannerfoto').uploadifive(_upload);

			$('.fotos-btn').on('click',function(e){
				e.preventDefault();
				$('#bannerfoto').uploadifive('upload');
			});
			
		}
		
		if($('#productofoto').length>0){

			var _upload = uploadDefaults;
			_upload.multi = true;
			_upload.formData = {
					'thumbs': ['80x80','300x300','620x320'],
					'tipo'	: 'productos'
			};

			_upload.onQueueComplete = function(uploads){
				uploadHelper.armaListaFotos(_imgsSubidas,_upload.formData);
			};

			$('#productofoto').uploadifive(_upload);

			$('.fotos-btn').on('click',function(e){
				e.preventDefault();
				$('#productofoto').uploadifive('upload');
			});
		}

		if( $('#sortable li').length>0 ){
			uploadHelper.eliminarImagen();
			uploadHelper.activarSorteable();
		}
		
		if( $('.minSel').length>0){
			$('.minSel').each(function(index, element) {
				$(element).multiselect({
					includeSelectAllOption: true,
					selectAllText: 'Todos',
					enableFiltering: true,
					enableCaseInsensitiveFiltering : true,
					filterPlaceholder: 'Buscar',
					nonSelectedText: 'Seleccione alguno',
					nSelectedText: 'seleccionados',
					buttonContainer: '<div class="btn-group input-block-level no-margin">',
					buttonClass: 'btn span12 text-left no-margin',
					buttonWidth: false,
					maxHeight: 250
				});
            });
		}

		if( $('.strtoslugText').length > 0 ){
			$('.strtoslugText').on('keyup',function(e){
				var _this = $(this);
				delay(function(){
					var _padre = _this.parents('.row-fluid'),
						_target = _padre.find('.strtoslugSlug'),
						_val = string_to_slug(_this.val());

					_target.val(_val);
				}, 100 );
			});
		}

		if( $('.selectTags').length > 0 ){
			$('.selectTags').select2({
				tags:function(){
					var _this = $('.selectTags'),
						_elem = _this.parent().find('.available'),
						_values = $.parseJSON(Base64.decode(_elem.val())),
						_final = [];

					$.each(_values,function(i,v){
						_final.push(v.categoria_nombre);
					});
					return _final;
				}/*,
				tokenSeparators: [","]
				*/
			});
		}

	});
});
/* ]]> */