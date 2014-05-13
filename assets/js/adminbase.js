$(window).resize(function() {
	// chosen resize bug
	"use strict";
	$('.chzn-container').each(function() {
		$(this).css('width', $('.chzn-container').parent().width()+'px');
		$(".chzn-drop").css('width', ($('.chzn-container').parent().width()-2)+'px');
		$(".chzn-search input").css('width', ($('.chzn-container').parent().width()-37)+'px');
	});
	
	/*if($(window).width() > 767){*/
		$('.main-nav > li').each(function(i, el) {
			if($(window).width() <= 800){
				if( $(el).is(':visible') && !$(el).hasClass('active') ){
					$(el).hide();
				}
			} else {
				if( !$(el).is(':visible') ){
					$(el).show();
				}
			}
    	});
	/*}*/
	//
	
	if($('#dialog').length>0){
		$('#dialog').dialog('option', 'position', 'center');
	}
	if($('#alertDialog').length>0){
		$('#alertDialog').dialog('option', 'position', 'center');
	}
	
	
});
$(document).ready(function() {
	"use strict";
	// ------ DO NOT CHANGE ------- //

	function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css( {
			top: y + 5,
			left: x + 10
		}).appendTo("body").show();
	}
	
	$(".mini > li > a").hover(function(e){
	e.stopPropagation();
	if(!$(this).parent().hasClass("open")){
		$(this).find(".label").stop().animate({
			top: '-10px'
		},200, function(){
			$(this).stop().animate({top: '-6px'},100);
		});
	}
	}, function(){});


	$('.main-nav > li.active > a').click(function(e){
		/*767*/
		if($(window).width() <= 800){
			e.preventDefault();
			if($(this).hasClass('open') && (!$(this).hasClass('toggle-collapsed'))){
				$(this).removeClass('open');
				$(this).parents('.main-nav').find('li').each(function(){
					$(this).find('.collapsed-nav').addClass('closed');
					$(this).hide();
				});
				$(this).parent().show();
				$(this).parent().removeClass('open');
			} else {
				if($(this).hasClass('toggle-collapsed')){
					$(this).parent().addClass('open');
				}
				if($(this).hasClass("open")){
					$(this).parents('.main-nav').find('li').not('.active').each(function(){
						$(this).find('.collapsed-nav').addClass('closed');
						$(this).hide();
					});
					$(this).removeClass("open");
				} else {
					$(this).addClass('open');
					$(this).parents('.main-nav').find('li').show();
				}
			}
		}
	});

	$('.toggle-collapsed').each(function(){
		if($(this).hasClass('on-hover')){
			$(this).click(function(e){e.preventDefault();});
			$(this).parent().hover(function(){
				$(this).addClass("open");
				$(this).find('.collapsed-nav').slideDown();
				$(this).find('img').attr("src", 'assets/img/toggle-subnav-up-white.png');
			}, function(){
				$(this).removeClass("open");
				$(this).find('.collapsed-nav').slideUp();
				$(this).find('img').attr("src", 'assets/img/toggle-subnav-down.png');
			});
		} else {
			$(this).click(function(e){
				e.preventDefault();
				if($(this).parent().find('.collapsed-nav').is(":visible")){
					$(this).parent().removeClass("open");
					$(this).parent().find('.collapsed-nav').slideUp();
					$(this).find('img').attr("src", 'assets/img/toggle-subnav-down.png');
				} else {
					$(this).parent().addClass("open");
					$(this).parent().find('.collapsed-nav').slideDown();
					$(this).find('img').attr("src", 'assets/img/toggle-subnav-up-white.png');
				}
			});
		}
	});

	$('.collapsed-nav li a').hover(function(){
		if(!$(this).parent().hasClass('active')){
			$(this).stop().animate({
				marginLeft: '5px'
			}, 300);
		}
	}, function(){
		if(!$(this).parent().hasClass('active')){
			$(this).stop().animate({
				marginLeft: '0'
			}, 100);
		}
	});
	
	$('a.preview').on('mouseover mouseout mousemove click',function(e){
			if(e.type === 'mouseover'){
				$('body').append('<div id="image_preview"><img src="'+$(this).attr('href')+'" width="150"></div>');
				$("#image_preview").fadeIn();
			} else if(e.type === 'mouseout') {
				$("#image_preview").remove();
			} else if(e.type === 'mousemove'){
				$("#image_preview").css({
					top:e.pageY+10+"px",
					left:e.pageX+10+"px"
				});
			} else if(e.type === 'click'){
				$("#image_preview").remove();
			}
		});

	$('.sel_all').click(function(){
		$(this).parents('table').find('.selectable-checkbox').attr('checked', this.checked);
	});
	// ------ END DO NOT CHANGE ------- //

	// ------ PLUGINS ------- //
	// - validation
	if($('.validate').length > 0){
		$('.validate').validate({
			errorPlacement:function(error, element){
					element.parents('.controls').append(error);
			},
			highlight: function(label) {
				$(label).closest('.control-group').removeClass('error success').addClass('error');
			},
			success: function(label) {
				label.addClass('valid').closest('.control-group').removeClass('error success').addClass('success');
			},
			meta: 'validate'
		});
	}
	// - tooltips
	$(".tip").tooltip();
	// - popover
	$(".pover").popover({
		delay: { show: 100, hide: 500 }
	});
	$(".pover").click(function(e){
		e.preventDefault();
		if($(this).data('trigger') === "manual"){
			$(this).popover('toggle');
		}
	});
	$(".table-has-pover").on('mouseenter', function(){
		$('.pover').popover();
	});
	// - growl-like notification
	if($('.opengrowl').length > 0){
		$(".opengrowl").click(function(e){
			e.preventDefault();
			var content = $(this).data('content');
			if($(this).hasClass("hasheader")){
				var head = $(this).data('header');
				$.jGrowl(content, { header: head });
			} else {
				$.jGrowl(content);
			}
		});
	}
	
	// - counter
	if($('.counter').length > 0){
		$('.counter').each(function(){
			var max = $(this).data('max');
			if(!max){
				max = 100;	
			} 
			$(this).textareaCount({
				'maxCharacterSize': max,
				'displayFormat' : 'Characters left: #left'
			});
		});
	}
	// - uniform
	if($('.uniform').length > 0){
		$('.uniform').uniform({
			radioClass: 'uniRadio'
		});
	}
	// - chosen
	if($('.cho').length > 0){
		$(".cho").chosen({no_results_text: "No results matched"});
	}
	// - cleditor
	if($('.cleditor').length > 0){
		$(".cleditor").cleditor({width:'auto'});
	}
	// - spinner
	if($('.spinner').length > 0){
		$('.spinner').spinner();
	}
	// - timepicker
	if($('.timepicker').length > 0){
		$('.timepicker').timepicker({
			defaultTime: 'current',
			minuteStep: 1,
			disableFocus: true,
			template: 'dropdown'
		});
	}
	// - tagsinput
	if($(".tagsinput").length > 0){
		$('.tagsinput').tagsInput({width:'auto', height:'auto'});
	}
	// - datepicker
	if($('.datepick').length > 0){
		$('.datepick').datepicker();	
	}
	// - masked inputs
	if($('.mask_date').length > 0){
		$(".mask_date").inputmask("9999/99/99");	
	}
	if($('.mask_phone').length > 0){
		$(".mask_phone").inputmask("(999) 999-9999",{ 
			clearIncomplete: true,
			clearMaskOnLostFocus: true,
			onincomplete: function(){
				var _form = $(this).closest('.validate');
				_form.validate().element(this);
				console.log($(this).closest('.validate'));
			} 
		});
	}
	if($('.mask_serialNumber').length > 0){
		$(".mask_serialNumber").inputmask("9999-9999-99");	
	}
	if($('.mask_productNumber').length > 0){
		$(".mask_productNumber").inputmask("AAA-9999-A");	
	}
	// - slider
	if($('.slider').length > 0){
		$(".slider").each(function(){
			var orient = $(this).data('orientation');
			var min = $(this).data('min');
			var max = $(this).data('max');
			var step = $(this).data('step');
			var range = $(this).data('range');
			var rangestart = $(this).data('rangestart');
			var rangestop = $(this).data('rangestop');


			if(orient === ""){
				orient = "horizontal";
			}

			var el = $(this);

			if(range !== undefined){
				$(this).find('.slide').slider({
					range:true,
					values:[rangestart, rangestop],
					orientation: orient,
					min: min,
					max: max,
					step: step,
					slide: function( event, ui ) {
						el.parent().find('.amount').html( ui.values[0]+" - "+ui.values[1] );
					}
				});
				$( this ).find('.amount').html( $(this).parent().find('.slide').slider( "values",0 )+" - "+$(this).parent().find('.slide').slider( "values",1 ) );
			} else {
				$(this).find('.slide').slider({
					orientation: orient,
					min: min,
					max: max,
					step: step,
					slide: function( event, ui ) {
						el.parent().find('.amount').html( ui.value );
					}
				});
				$( this ).find('.amount').html( $(this).parent().find('.slide').slider( "value" ) );
			}

		});
	}
});