/* <![CDATA[ */
var src_activo = 0;

function tieneGrid(){
	if (typeof grid !== 'undefined') {
		grid.refresh(); 
		grid.commit();
	}
}

//function Handle_OnInit(sender,args){}
function Handle_OnInit(){
	if (src_activo == 0){ $('.kgrFilterCell').css('display','none'); } else { $('.kgrFilterCell').css('display','table-cell'); }
	$('.kgrFiEnTr').addClass('span12');
	placeHolder();
}

function placeHolder(){
	if($('.kgrTable tbody').children().size()<1){
		$('.kgrTable tbody').html('<tr class="kgrRow"><td colspan="7" class="kgrCell" style="height:32px;"><div style="white-space:normal;text-align:center;" class="kgrIn">No hay elementos.</div></td></tr>');
	}
}


jQuery(function($){
	$('.buscar').on('click',function(e){
		e.preventDefault();
		if (src_activo == 0){ src_activo = 1; } else { src_activo = 0; } $('.kgrFilterCell').toggle();
	});
	Handle_OnInit();

	
});

/* ]]> */