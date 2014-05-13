var _base;

var putLoad = function(_element){
	if( $('.loading',_element).length > 0 ){
		$('.loading',_element).fadeIn();
	} else {
		_element.append('<div class="loading" style="width:100%; height:100%;"></div>');
	}
}

var removeLoad = function(_element){
	setTimeout(function(){
		$('.loading',_element).fadeOut();
	},500);
}

/*Set VALIDATOR default values */
//var _showToolTip = ( $('input[name="showTooltip"]').length>0 ? true:false);
var _showToolTip = true;
jQuery.validator.addMethod("inCart",function(){
	var _cartTable = $('table.cart'),
		_items = $('a[title="Eliminar"]',_cartTable).length;
		//console.log(_items);
	if(_items>0){
		return true;
	}
	return false;
},"Debe haber almenos 1 item en tu carrito.");

jQuery.validator.setDefaults({
	errorPlacement: function(error, element) {
		error.appendTo(element.parent().parent()).addClass('errorHidden');
	},
	success: function(label) {
		label.html("&nbsp;").addClass("checked");
	},
	showErrors: function(errorMap, errorList) {
		// Clean up any tooltips for valid elements
		$.each(this.validElements(), function (index, element) {
			var $element = $(element);
			if( _showToolTip ){
				$element.data("title", "") // Clear the title - there is no error associated anymore
						.removeClass("error")
						.tooltip("destroy");
			}
			$element.parent().parent().removeClass('error');
		});
	 
		// Create new tooltips for invalid elements
		$.each(errorList, function (index, error) {
			var $element = $(error.element);
			if( _showToolTip ){
				$element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
						.data("title", error.message)
						.addClass("error")
						.tooltip(); // Create a new tooltip based on the error messsage we just set in the title
			}
			$element.parent().parent().addClass('error');
		});
	},
	messages:{
		nombre: {required: " "},
		apellido: {required: " "},
		tel: {required: " "},
		mensaje: {required: " "},
		email: {required: " ", email: " "},
		qty: {required: " "}
	},
	ignore: []
});

var bootboxHelper = {
	inform: function(_args){
		bootbox.dialog(_args.msg, [
					{
						"label" : "Ok",
						"class" : "btn-primary",
						callback: function() {
							_args.callback();
						}
					}
				],
				{
					"header": _args.header
				}
			)
	}
}

jQuery(function($){
	var _filter;
	var _filterO;
	_base = $('.baseweb').attr('href');
	
	
	/*$('.flexslider').flexslider({
		animation: "slide",
		pauseOnHover: true,
		directionNav: false
	});*/
	//initialize();
	
	$('.add-carrito').on('click',function(e){
		e.preventDefault();
		var _this = $(this),
			_padre = _this.parents('.producto'),
			_id = _this.data('item'),
			_argus = {};

		$.ajax({
			url:'carrito/agregar',
			data:{'item[id]':_id},
			type:'POST',
			dataType:'JSON',
			beforeSend: function(jqXHR,settings){
				//console.log(_padre);
				putLoad(_padre);
			},
			error: function(jqXHR,textStatus,errorThrown){
				if(jqXHR['status']!='200'){
					_argus.header = 'Hubo un problema';
					_argus.msg = jqXHR['status']+' - '+errorThrown;
					_argus.callback = function(){removeLoad(_padre)};

					bootboxHelper.inform(_argus);
				}
					
			},
			success: function(data,textStatus,jqXHR){
				switch(data['error']){
					case '0':
						_argus.header = 'Agregar al carrito';
						_argus.msg = 'El prodcuto <strong>'+data['data']['item']['nombre']+'</strong> se ha agreado a su carrito.';
						_argus.callback = function(){
							removeLoad(_padre);
							$('.total-cart').html(data['data']['total_items']+' libros: $'+data['data']['total']);
						};
					
						bootboxHelper.inform(_argus);
						break;
					default:
					case '1':
						_argus.header = 'Hubo un problema';
						_argus.msg = data['msg'];
						_argus.callback = function(){removeLoad(_padre)}
					
						/*
						_tipo = defineTipo(_argus);
						bootbox.alert(_tipo.msg);
						*/
						bootboxHelper.inform(_argus);
						break;
				}
			},
			complete: function(event, xhr, settings){
				if(event.status==404){
					$('.loading').fadeOut('normal',function(){ 
						$('.loading',_padre).remove();
					});
				}
			}

		});
	});
	
	
	if($('.targetSimple').length>0){
		$('.targetSimple').each(function(index) {
			$(this).validate();
		});
	}

	if($('.target').length>0){
		$('.target').each(function(index) {
			$(this).validate({
				submitHandler: function(form) {
					var _url = $('input[name="funcion"]',form).val(),
						_form = $(form),
						_argus = {};
					//$.ajax
					_form.ajaxSubmit({
						url: _base+'funcion/'+_url,
						type: 'POST',
						dataType: 'json',
						beforeSend: function(jqXHR){
							myXHR = jqXHR;
							myXHR.done(function(data,textStatus,jqXHR){
								if(jqXHR.status==404){
									$('.loading').fadeOut('normal',function(){ 
										$('.loading',_form).remove();
									});
								}
							});
							putLoad(_form);
						},
						error: function(jqXHR,textStatus,errorThrown){
							if(jqXHR['status']!='200'){
								_argus.header = 'Hubo un problema';
								_argus.msg = jqXHR['status']+' - '+errorThrown;
								_argus.callback = function(){removeLoad(_form)};

								bootboxHelper.inform(_argus);
							}
						},
						success: function(data,textStatus,jqXHR){
							switch(data['error']){
								case '0':
									_argus.header = data['header'];
									_argus.msg = data['msg'];
									_argus.callback = function(){
										removeLoad(_form);
										_form.clearForm();
										if("result" in data){
											eval(data["result"]);
										}
									};
								
									bootboxHelper.inform(_argus);
									break;
								default:
								case '1':
									_argus.header = 'Hubo un problema';
									_argus.msg = data['msg'];
									_argus.callback = function(){removeLoad(_form)}

									bootboxHelper.inform(_argus);
									break;
							}
						}
					});
				}
			});
		});
	}

	if($('.producto-info .producto-titulo h4').length>0){
		$('.producto-info .producto-titulo h4').equalHeights();
	}

	if($('.producto-info .producto-desc p').length>0){
		$('.producto-info .producto-desc p').equalHeights();
	}

	if($('.galeria a').length>0){
		$('.galeria').galleria({lightbox: true, thumbnails:'empty', showCounter:false});
	}

	if( $('#slider').length > 0 ){
		$('#slider').nivoSlider({
    		//effect: 'fade',
    		pauseTime: 4000,
    		animSpeed: 1000,
    		pauseOnHover: true
    		//directionNav: false
    		//controlNav: false
    	});
	}

	$('a.nofollow,a[rel="nofollow"]').on('click',function(e){return false;});
	
});