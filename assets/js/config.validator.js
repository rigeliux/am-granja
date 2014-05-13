/* <![CDATA[ */
jQuery.validator.setDefaults({
	errorPlacement: function(error,element) {
		error.appendTo(element.parent()).addClass('errorHidden');
		justreFlow();
	},
	success: function(label) {
		label.html("&nbsp;");//.addClass("checked");
	},
	ignore: '.ignore',
	messages:{
	},
	invalidHandler: function(form,validator) {
		var errors = validator.numberOfInvalids();
		
		if (errors) {
			//var invalidPanels = $(validator.invalidElements()).closest('.ui-tabs-panel', form);
			var invalidPanels = $(validator.invalidElements()).closest('.ui-tabs-panel', $(form));
			if (invalidPanels.size() > 0) {
				$.each($.unique(invalidPanels.get()), function(){
					//console.log( $('.ui-tabs-nav li a[href*="#'+this.id+'"]') );
					//$('.ui-tabs-nav').find('a[href="#'+this.id+'"]');
					$('.ui-tabs-nav li a[href*="#'+this.id+'"]')
						.parent('li').addClass('ui-state-error').effect("pulsate",{times: 3},1200);
					//$(this).siblings('.ui-tabs-nav').find('a[href="#'+this.id+'"]') ??????
				});
			}
		}
	},
	highlight: function(element, errorClass, validClass) {
		$(element).parent().addClass('error');
	},
	unhighlight: function(element, errorClass, validClass) {
		$(element).parent().removeClass('error');
		$(element.form).find("label[for=" + element.id + "]").removeClass('eerr');
		
		var $panel = $(element).closest(".ui-tabs-panel", element.form);
		if ($panel.size() > 0) {
			//if ($panel.find(".eerr:visible").size() === 0) {}
			if ($panel.find("div.error").size() === 0) {
				//$('.ui-tabs-nav').find('a[href="#'+$panel[0].id+'"]')
				$('.ui-tabs-nav li a[href*="#'+$panel[0].id+'"]')
					.parent().removeClass("ui-state-error");
			}
		}
	},
	submitHandler: function(form) {
		//$.ajax
		$(form).ajaxSubmit({
			//url: _base+'/funcion/doRegisterUsuario',
			type: 'POST',
			//data: {funcion:'hiii'},
			dataType: 'json',
			beforeSend: function(){
				$(form).validate().form();
				if($(form).valid()){
					$('#high-cont .loading').fadeIn();
				}
			},
			error: function(jqXHR,textStatus,errorThrown){
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
				switch(data['error']){
					case 0:
					case 102:
						//var expa = parent.window.hs.getExpander();
						setTimeout(function(){
							var _height = $('.target #contenido').height();
							$('.target #contenido').empty().css('height',_height).html('<div class="items">'+data['desc']+'</div>');
							$('.target .well div').html('<button type="button" id="cerrar" class="boton">Cerrar</button>');
							botonInit($('#cerrar')).on('click',cierraGrid);
							$('#high-cont .loading').fadeOut(function(){
								justreFlow();
								//botonInit($('#cerrar')).on('click',cierraGrid);
							});
							//setTimeout(function() { expa.close(); }, 2000);
						},1000);
						break;
					default:
					case 104:
						setTimeout(function(){
							$('#high-cont .loading').fadeOut();
						},1000);
						var args = { tipo:'alerta-error',titulo:data['titulo'],error:data['msg'] }
						abreDialog(args);
						//alert('Hubo un error.\n\rIntente nuevamente');
						break;
				}
			}
		});
	}
});
/* ]]> */