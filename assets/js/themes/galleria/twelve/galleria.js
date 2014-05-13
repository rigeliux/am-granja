(function($) {

/*global jQuery, Galleria */

Galleria.addTheme({
	name: 'twelve',
	author: 'Galleria',
	version: '2.2',
	css: 'galleria.css',
	defaults:{
		transition:"pulse",
		transitionSpeed:500,
		imageCrop:true,
		thumbCrop:true,
		carousel:false,
		_locale:{
			show_thumbnails:"Show thumbnails",
			hide_thumbnails:"Hide thumbnails",
			play:"Play slideshow",
			pause:"Pause slideshow",
			enter_fullscreen:"Enter fullscreen",
			exit_fullscreen:"Exit fullscreen",
			popout_image:"Popout image",
			showing_image:"Showing image %s of %s"
		},
		_showFullscreen:true,
		_showPopout:true,
		_showProgress:true,
		_showTooltip:true
	},
	init:function(h) {
		Galleria.requires(1.28, "This version of Twelve theme requires Galleria version 1.2.8 or later");
		this.addElement("bar", "fullscreen", "play", "popout", "thumblink", "s1", "s2", "s3", "s4", "progress");
		this.append({stage:"progress", container:["bar", "tooltip"], bar:"fullscreen play popout thumblink info s1 s2 s3 s4".split(" ")});
		this.prependChild("info", "counter");
		var p = this;
		var K = this.$("thumbnails-container");
		var u = this.$("thumblink");
		var x = this.$("fullscreen");
		var t = this.$("play");
		var A = this.$("popout");
		var D = this.$("bar");
		var B = this.$("progress");
		var H = h.transition;
		var F = h._locale;
		var C = false;
		var L = false;
		var M = !!h.autoplay;
		var P = false;
		var $ = function() {
			K.height(p.getStageHeight()).width(p.getStageWidth()).css("top", C ? 0 : p.getStageHeight() + 30)
		};
		var V = function() {
			C && P ? p.play() : (P = M, p.pause());
			Galleria.utils.animate(K, {top:C ? p.getStageHeight() + 30 : 0}, {easing:"galleria", duration:400, complete:function() {
					p.defineTooltip("thumblink", C ? F.show_thumbnails : F.hide_thumbnails);
					u[C ? "removeClass" : "addClass"]("open");
					C = !C
				}
			});
		};
		$();
		h._showTooltip && p.bindTooltip({
			thumblink:F.show_thumbnails,
			fullscreen:F.enter_fullscreen,
			play:function() {
				return M ? F.pause : F.play
			},
			popout:F.popout_image,
			caption:function() {
				var e = p.getData();
				var h = "";
				e && (e.title && e.title.length && (h += "<strong>" + e.title + "</strong>"), e.description && e.description.length && (h += "<br>" + e.description));
				return h;
			},
			counter:function() {
				return F.showing_image.replace(/\%s/, p.getIndex() + 1).replace(/\%s/, p.getDataLength());
			}
		});
		h.showInfo || this.$("info").hide();
		
		this.bind("play", function() {
			M = true;
			t.addClass("playing")
		});
		
		this.bind("pause", function() {
			M = false;
			t.removeClass("playing");
			B.width(0)
		});
		
		h._showProgress && this.bind("progress", function(e) {
			B.width(e.percent / 100 * this.getStageWidth())
		});
		
		this.bind("loadstart", function(e) {
			e.cached || this.$("loader").show()
		});
		this.bind("loadfinish", function() {
		  B.width(0);
		  this.$("loader").hide();
		  this.refreshTooltip("counter", "caption")
		});
		
		this.bind("thumbnail", function(h) {
			jQuery(h.thumbTarget).hover(function() {
				p.setInfo(h.thumbOrder);
				p.setCounter(h.thumbOrder)
			},function() {
				p.setInfo();
				p.setCounter()
			}).click(function() {
				V();
			});
		});
		
		this.bind("fullscreen_enter", function() {
			L = true;
			//p.setOptions("transition", false);
			x.addClass("open");
			D.css("bottom", 0);
			this.defineTooltip("fullscreen", F.exit_fullscreen);
			Galleria.TOUCH || this.addIdleState(D, {bottom:-31})
		});
		
		this.bind("fullscreen_exit", function() {
			L = false;
			Galleria.utils.clearTimer("bar");
			p.setOptions("transition", H);
			x.removeClass("open");
			D.css("bottom", 0);
			this.defineTooltip("fullscreen", F.enter_fullscreen);
			Galleria.TOUCH || this.removeIdleState(D, {bottom:-31})
		});
		
		this.bind("rescale", $);
		
		Galleria.TOUCH || (this.addIdleState(this.get("image-nav-left"), {left:-36}), this.addIdleState(this.get("image-nav-right"), {right:-36}));
		u.click(V);
		h.thumbnails || (u.hide(), t.css("left", 0), this.$("s2").hide(), this.$("info").css("left", 41));
		h._showPopout ? A.click(function(e) {
			p.openLightbox();
			e.preventDefault()
		}) : (A.remove(), h._showFullscreen && (this.$("s4").remove(), this.$("info").css("right", 40), x.css("right", 0)));
		
		t.click(function() {
			M ? p.pause() : (C && u.click(), p.play())
		});
		
		h._showFullscreen ? x.click(function() {
			L ? p.exitFullscreen() : p.enterFullscreen()
		}) : (x.remove(), h._show_popout && (this.$("s4").remove(), this.$("info").css("right", 40), A.css("right", 0)));
		
		h._showFullscreen || h._showPopout || (this.$("s3,s4").remove(), this.$("info").css("right", 10));
		h.autoplay && this.trigger("play")
	}
});

})(jQuery);