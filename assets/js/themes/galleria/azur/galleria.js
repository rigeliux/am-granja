(function($) {

/*global jQuery, Galleria */

Galleria.addTheme({
	name: 'azur',
	author: 'Galleria',
	version: '2.2',
	css: 'galleria.css',
	defaults:{
		transition:"fade",
		transitionSpeed:500,
		imageCrop:false,
		thumbCrop:"height",
		idleMode:"hover",
		idleSpeed:500,
		fullscreenTransition:"slide",
		_locale:{
			show_captions:"Show captions",
			hide_captions:"Hide captions",
			play:"Play slideshow",
			pause:"Pause slideshow",
			enter_fullscreen:"Enter fullscreen",
			exit_fullscreen:"Exit fullscreen",
			next:"Next image",
			prev:"Previous image",
			showing_image:"Showing image %s of %s"
		},
		_toggleCaption:true,
		_showCaption:true,
		_showTooltip:true
	},
	init:function(h) {
		Galleria.requires(1.28, "This version of Azur theme requires Galleria version 1.2.8 or later");
		this.addElement("bar", "fullscreen", "play", "progress")
			.append({
				stage:"progress",
				container:"bar",
				bar:["fullscreen", "play", "thumbnails-container"]
			})
			.prependChild("stage", "info")
			.appendChild("container", "tooltip");
		var p = this;
		var K = window.document;
		var u = h._locale;
		var x = "getContext" in K.createElement("canvas");
		var H = h.transition;
		//var e;
		
		(function() {
			if(x) {
				var h = K.createElement("canvas");
				var t = h.getContext("2d");
				h.width = 24;
				h.height = 24;
				$(h).css({zIndex:1E4, position:"absolute", right:10, top:10}).appendTo(p.get("container"));
				p.bind("progress", function(p) {
					$(h).fadeIn(200);
					p = 3.6 * p.percent;
					t.strokeStyle = "rgba(255,255,255,.7)";
					t.lineWidth = 3;
					t.clearRect(0, 0, 24, 24);
					t.beginPath();
					t.arc(12, 12, 10, -90 * (Math.PI / 180), (p - 90) * (Math.PI / 180), false);
					t.stroke();
					t.closePath()
				});
				p.bind("pause", function() {
					$(h).fadeOut(200, function() {
						t.clearRect(0, 0, 24, 24)
					});
				});
			} else {
				p.addElement("progressbar").appendChild("progress", "progressbar");
				p.$("progress").addClass("nocanvas");
				var u = p.$("progress").width();
				p.bind("progress", function(e) {
					p.$("progressbar").width(e.percent / 100 * u);
				});
			}
		})();
		
		(function() {
			if(x) {
				var h = K.createElement("canvas");
				var t = h.getContext("2d");
				var u = Math;
				var A = function(e, h, p) {
					p = p ? -2 : 2;
					e.translate(h / p, h / p);
				};
				var C = 28;
				$(h).hide().appendTo(p.get("loader")).fadeIn(500);
				window.setInterval(function() {
					var e = C, h;
					t.clearRect(0, 0, 48, 48);
					t.lineWidth = 1.5;
					for(var p = 0;28 > p;p++) {
						h = 28 <= p + e ? p - 28 + e : p + e, t.strokeStyle = "rgba(255,255,255," + u.max(0, h / 28) + ")", t.beginPath(), t.moveTo(24, 8), t.lineTo(24, 0), t.stroke(1), A(t, 48, !1), t.rotate(360 / 28 * u.PI / 180), A(t, 48, !0)
					}
					t.save();
					A(t, 48, false);
					t.rotate(-1 * (360 / 28 / 8) * u.PI / 180);
					A(t, 48, true);
					C = 0 === C ? 28 : C - 1
				}, 20)
			} else {
				p.$("loader").addClass("nocanvas")
			}
		})();
		
		var t = 9 > Galleria.IE ? {bottom:-100} : {bottom:-50, opacity:0};
		var A = 9 > Galleria.IE ? {top:-20} : {opacity:0, top:-20};
		
		this.bind("play", function() {
			this.$("play").addClass("pause");
			x || this.$("progress").show()
		});
		
		this.bind("pause", function() {
			this.$("play").removeClass("pause");
			x || this.$("progress").hide()
		});
		
		this.bind("loadstart", function(e) {
			e.cached || this.$("loader").show()
		});
		
		this.bind("loadfinish", function() {
			x ? this.$("loader").fadeOut(100) : this.$("loader").hide()
		});
		
		
		this.addIdleState(this.get("info"), t, 9 > Galleria.IE ? {} : {opacity:1}, true)
			.addIdleState(this.get("image-nav-left"), {opacity:0, left:0}, {opacity:1}, true)
			.addIdleState(this.get("image-nav-right"), {opacity:0, right:0}, {opacity:1}, true)
			.addIdleState(this.get("counter"), A, 9 > Galleria.IE ? {} : {opacity:0.9}, true);
		
		this.$("fullscreen").click(function(e) {
			e.preventDefault();
			p.toggleFullscreen()
		});
		
		this.$("play").click(function(e) {
			e.preventDefault();
			p.playToggle()
		});
		
		h._toggleCaption && (this.$("info").addClass("toggler"),
		this.addElement("captionopen").appendChild("stage", "captionopen"),
		this.addElement("captionclose").appendChild("info", "captionclose"),
		this.$("captionopen").click(function() {
			p.$("info").addClass("open");
			$(this).hide()
		}).html(u.show_captions),
		this.bind("loadstart", function() {
			this.$("captionopen").toggle(!p.$("info").hasClass("open") && this.hasInfo())
		}),
		this.$("captionclose").click(function() {
			p.$("info").removeClass("open");
			p.hasInfo() && p.$("captionopen").show()
		}).html("&#215;"),
		h._showCaption && this.$("captionopen").click());
		h._showTooltip && this.bindTooltip({
			fullscreen:function() {
				return p.isFullscreen() ? u.exit_fullscreen : u.enter_fullscreen;
			},
			play:function() {
				return p.isPlaying() ? u.pause : u.play
			},
			captionclose:u.hide_captions,
			"image-nav-right":u.next,
			"image-nav-left":u.prev,
			counter:function() {
				return u.showing_image.replace(/\%s/, p.getIndex() + 1).replace(/\%s/, p.getDataLength())
			}
		});
		
		this.bind("fullscreen_enter", function() {
			//L = true;
			p.setOptions("transition", "slide");
		});
		
		this.bind("fullscreen_exit", function() {
			//L = false;
			p.setOptions("transition", H);
		});
	}
});

})(jQuery);