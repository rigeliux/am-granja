/* <![CDATA[ */
hs.graphicsDir = 'assets/js/highslide/graphics/';
hs.showCredits = false;
hs.align = 'center';
hs.allowSizeReduction = false;
hs.captionEval = 'this.a.title';

hs.dimmingOpacity = 0.5;
hs.easing = 'linearTween';
hs.outlineWhileAnimating = 0;
//hs.align = 'center';
hs.allowMultipleInstances = false;
hs.enableKeyListener = false;
hs.numberOfImagesToPreload = 2;
hs.onDimmerClick = function() { return false; }

hs.lang = {
	cssDirection: 'ltr',
	loadingText: 'Cargando...',
	loadingTitle: 'Click para cancelar',
	focusTitle: 'Click para traer al frente',
	fullExpandTitle: 'Expandir al tamaño actual',
	creditsText: 'Potenciado por <i>Highslide JS</i>',
	creditsTitle: 'Ir al home de Highslide JS',
	previousText: 'Anterior',
	nextText: 'Siguiente',
	moveText: 'Mover',
	closeText: 'Cerrar',
	closeTitle: 'Cerrar (esc)',
	resizeTitle: 'Redimensionar',
	playText: 'Iniciar',
	playTitle: 'Iniciar slideshow (barra espacio)',
	pauseText: 'Pausar',
	pauseTitle: 'Pausar slideshow (barra espacio)',
	previousTitle: 'Anterior (flecha izquierda)',
	nextTitle: 'Siguiente (flecha derecha)',
	moveTitle: 'Mover',
	fullExpandText: 'Tamaño real',
	number: 'Imagen %1 de %2',
	restoreTitle: 'Click para cerrar la imagen, click y arrastrar para mover. Usa las flechas del teclado para avanzar o retroceder.'
};

if (hs.ie && window == window.top) { /// IE but not iframes
   (function () {
      try {
         document.documentElement.doScroll('left');
      } catch (e) {
         setTimeout(arguments.callee, 50);
         return;
      }
      hs.ready();
   })();
}
hs.addEventListener(document, 'DOMContentLoaded', hs.ready); /// Moz, Opera, Webkit
hs.addEventListener(window, 'load', hs.ready); /// Safe fallback


var config2 = {
	slideshowGroup: "imagen",
	wrapperClassName: "borderless floating-caption",
	outlineType: "rounded-white",
	cacheAjax: false
}

//$( window ).on( 'resize', $.debounce( 250, HS_justreFlow ) );

/* ]]> */