var productContactIcon, productContactIframe;
typeof Object.create != "function" && (Object.create = function(n) {
        function t() {}
        return t.prototype = n, new t
    }),
    function(n) {
        var t = {
            init: function(t, i) {
                var r = this;
                r.elem = i;
                r.$elem = n(i);
                r.imageSrc = r.$elem.data("zoom-image") ? r.$elem.data("zoom-image") : r.$elem.attr("src");
                r.options = n.extend({}, n.fn.elevateZoom.options, t);
                r.options.tint && (r.options.lensColour = "none", r.options.lensOpacity = "1");
                r.options.zoomType == "inner" && (r.options.showLens = !1);
                r.$elem.parent().removeAttr("title").removeAttr("alt");
                r.zoomImage = r.imageSrc;
                r.refresh(1);
                n("#" + r.options.gallery + " a").click(function(t) {
                    return r.options.galleryActiveClass && (n("#" + r.options.gallery + " a").removeClass(r.options.galleryActiveClass), n(this).addClass(r.options.galleryActiveClass)), t.preventDefault(), r.zoomImagePre = n(this).data("zoom-image") ? n(this).data("zoom-image") : n(this).data("image"), r.swaptheimage(n(this).data("image"), r.zoomImagePre), !1
                })
            },
            refresh: function(n) {
                var t = this;
                setTimeout(function() {
                    t.fetch(t.imageSrc)
                }, n || t.options.refresh)
            },
            fetch: function(n) {
                var t = this,
                    i = new Image;
                i.onload = function() {
                    t.largeWidth = i.width;
                    t.largeHeight = i.height;
                    t.startZoom();
                    t.currentImage = t.imageSrc;
                    t.options.onZoomedImageLoaded(t.$elem)
                };
                i.src = n;
                return
            },
            startZoom: function() {
                var t = this,
                    i;
                t.nzWidth = t.$elem.width();
                t.nzHeight = t.$elem.height();
                t.isWindowActive = !1;
                t.isLensActive = !1;
                t.isTintActive = !1;
                t.overWindow = !1;
                t.options.imageCrossfade && (t.zoomWrap = t.$elem.wrap('<div style="height:' + t.nzHeight + "px;width:" + t.nzWidth + 'px;" class="zoomWrapper" />'), t.$elem.css("position", "absolute"));
                t.zoomLock = 1;
                t.scrollingLock = !1;
                t.changeBgSize = !1;
                t.currentZoomLevel = t.options.zoomLevel;
                t.nzOffset = t.$elem.offset();
                t.widthRatio = t.largeWidth / t.currentZoomLevel / t.nzWidth;
                t.heightRatio = t.largeHeight / t.currentZoomLevel / t.nzHeight;
                t.options.zoomType == "window" && (t.zoomWindowStyle = "overflow: hidden;background-position: 0px 0px;text-align:center;background-color: " + String(t.options.zoomWindowBgColour) + ";width: " + String(t.options.zoomWindowWidth) + "px;height: " + String(t.options.zoomWindowHeight) + "px;float: left;background-size: " + t.largeWidth / t.currentZoomLevel + "px " + t.largeHeight / t.currentZoomLevel + "px;display: none;z-index:100;border: " + String(t.options.borderSize) + "px solid " + t.options.borderColour + ";background-repeat: no-repeat;position: absolute;");
                t.options.zoomType == "inner" && (i = t.$elem.css("border-left-width"), t.zoomWindowStyle = "overflow: hidden;margin-left: " + String(i) + ";margin-top: " + String(i) + ";background-position: 0px 0px;width: " + String(t.nzWidth) + "px;height: " + String(t.nzHeight) + "px;float: left;display: none;cursor:" + t.options.cursor + ";px solid " + t.options.borderColour + ";background-repeat: no-repeat;position: absolute;");
                t.options.zoomType == "window" && (lensHeight = t.nzHeight < t.options.zoomWindowWidth / t.widthRatio ? t.nzHeight : String(t.options.zoomWindowHeight / t.heightRatio), lensWidth = t.largeWidth < t.options.zoomWindowWidth ? t.nzWidth : t.options.zoomWindowWidth / t.widthRatio, t.lensStyle = "background-position: 0px 0px;width: " + String(t.options.zoomWindowWidth / t.widthRatio) + "px;height: " + String(t.options.zoomWindowHeight / t.heightRatio) + "px;float: right;display: none;overflow: hidden;z-index: 999;-webkit-transform: translateZ(0);opacity:" + t.options.lensOpacity + ";filter: alpha(opacity = " + t.options.lensOpacity * 100 + "); zoom:1;width:" + lensWidth + "px;height:" + lensHeight + "px;background-color:" + t.options.lensColour + ";cursor:" + t.options.cursor + ";border: " + t.options.lensBorderSize + "px solid " + t.options.lensBorderColour + ";background-repeat: no-repeat;position: absolute;");
                t.tintStyle = "display: block;position: absolute;background-color: " + t.options.tintColour + ";filter:alpha(opacity=0);opacity: 0;width: " + t.nzWidth + "px;height: " + t.nzHeight + "px;";
                t.lensRound = "";
                t.options.zoomType == "lens" && (t.lensStyle = "background-position: 0px 0px;float: left;display: none;border: " + String(t.options.borderSize) + "px solid " + t.options.borderColour + ";width:" + String(t.options.lensSize) + "px;height:" + String(t.options.lensSize) + "px;background-repeat: no-repeat;position: absolute;");
                t.options.lensShape == "round" && (t.lensRound = "border-top-left-radius: " + String(t.options.lensSize / 2 + t.options.borderSize) + "px;border-top-right-radius: " + String(t.options.lensSize / 2 + t.options.borderSize) + "px;border-bottom-left-radius: " + String(t.options.lensSize / 2 + t.options.borderSize) + "px;border-bottom-right-radius: " + String(t.options.lensSize / 2 + t.options.borderSize) + "px;");
                t.zoomContainer = n('<div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:' + t.nzOffset.left + "px;top:" + t.nzOffset.top + "px;height:" + t.nzHeight + "px;width:" + t.nzWidth + 'px;"><\/div>');
                n("body").append(t.zoomContainer);
                t.options.containLensZoom && t.options.zoomType == "lens" && t.zoomContainer.css("overflow", "hidden");
                t.options.zoomType != "inner" && (t.zoomLens = n("<div class='zoomLens' style='" + t.lensStyle + t.lensRound + "'>&nbsp;<\/div>").appendTo(t.zoomContainer).click(function() {
                    t.$elem.trigger("click")
                }), t.options.tint && (t.tintContainer = n("<div/>").addClass("tintContainer"), t.zoomTint = n("<div class='zoomTint' style='" + t.tintStyle + "'><\/div>"), t.zoomLens.wrap(t.tintContainer), t.zoomTintcss = t.zoomLens.after(t.zoomTint), t.zoomTintImage = n('<img style="position: absolute; left: 0px; top: 0px; max-width: none; width: ' + t.nzWidth + "px; height: " + t.nzHeight + 'px;" src="' + t.imageSrc + '">').appendTo(t.zoomLens).click(function() {
                    t.$elem.trigger("click")
                })));
                t.zoomWindow = isNaN(t.options.zoomWindowPosition) ? n("<div style='z-index:999;left:" + t.windowOffsetLeft + "px;top:" + t.windowOffsetTop + "px;" + t.zoomWindowStyle + "' class='zoomWindow'>&nbsp;<\/div>").appendTo("body").click(function() {
                    t.$elem.trigger("click")
                }) : n("<div style='z-index:999;left:" + t.windowOffsetLeft + "px;top:" + t.windowOffsetTop + "px;" + t.zoomWindowStyle + "' class='zoomWindow'>&nbsp;<\/div>").appendTo(t.zoomContainer).click(function() {
                    t.$elem.trigger("click")
                });
                t.zoomWindowContainer = n("<div/>").addClass("zoomWindowContainer").css("width", t.options.zoomWindowWidth);
                t.zoomWindow.wrap(t.zoomWindowContainer);
                t.options.zoomType == "lens" && t.zoomLens.css({
                    backgroundImage: "url('" + t.imageSrc + "')"
                });
                t.options.zoomType == "window" && t.zoomWindow.css({
                    backgroundImage: "url('" + t.imageSrc + "')"
                });
                t.options.zoomType == "inner" && t.zoomWindow.css({
                    backgroundImage: "url('" + t.imageSrc + "')"
                });
                t.$elem.bind("touchmove", function(n) {
                    n.preventDefault();
                    var i = n.originalEvent.touches[0] || n.originalEvent.changedTouches[0];
                    t.setPosition(i)
                });
                t.zoomContainer.bind("touchmove", function(n) {
                    t.options.zoomType == "inner" && t.showHideWindow("show");
                    n.preventDefault();
                    var i = n.originalEvent.touches[0] || n.originalEvent.changedTouches[0];
                    t.setPosition(i)
                });
                t.zoomContainer.bind("touchend", function() {
                    t.showHideWindow("hide");
                    t.options.showLens && t.showHideLens("hide");
                    t.options.tint && t.options.zoomType != "inner" && t.showHideTint("hide")
                });
                t.$elem.bind("touchend", function() {
                    t.showHideWindow("hide");
                    t.options.showLens && t.showHideLens("hide");
                    t.options.tint && t.options.zoomType != "inner" && t.showHideTint("hide")
                });
                t.options.showLens && (t.zoomLens.bind("touchmove", function(n) {
                    n.preventDefault();
                    var i = n.originalEvent.touches[0] || n.originalEvent.changedTouches[0];
                    t.setPosition(i)
                }), t.zoomLens.bind("touchend", function() {
                    t.showHideWindow("hide");
                    t.options.showLens && t.showHideLens("hide");
                    t.options.tint && t.options.zoomType != "inner" && t.showHideTint("hide")
                }));
                t.$elem.bind("mousemove", function(n) {
                    t.overWindow == !1 && t.setElements("show");
                    (t.lastX !== n.clientX || t.lastY !== n.clientY) && (t.setPosition(n), t.currentLoc = n);
                    t.lastX = n.clientX;
                    t.lastY = n.clientY
                });
                t.zoomContainer.bind("mousemove", function(n) {
                    t.overWindow == !1 && t.setElements("show");
                    (t.lastX !== n.clientX || t.lastY !== n.clientY) && (t.setPosition(n), t.currentLoc = n);
                    t.lastX = n.clientX;
                    t.lastY = n.clientY
                });
                t.options.zoomType != "inner" && t.zoomLens.bind("mousemove", function(n) {
                    (t.lastX !== n.clientX || t.lastY !== n.clientY) && (t.setPosition(n), t.currentLoc = n);
                    t.lastX = n.clientX;
                    t.lastY = n.clientY
                });
                t.options.tint && t.options.zoomType != "inner" && t.zoomTint.bind("mousemove", function(n) {
                    (t.lastX !== n.clientX || t.lastY !== n.clientY) && (t.setPosition(n), t.currentLoc = n);
                    t.lastX = n.clientX;
                    t.lastY = n.clientY
                });
                t.options.zoomType == "inner" && t.zoomWindow.bind("mousemove", function(n) {
                    (t.lastX !== n.clientX || t.lastY !== n.clientY) && (t.setPosition(n), t.currentLoc = n);
                    t.lastX = n.clientX;
                    t.lastY = n.clientY
                });
                t.zoomContainer.add(t.$elem).mouseenter(function() {
                    t.overWindow == !1 && t.setElements("show")
                }).mouseleave(function() {
                    t.scrollLock || t.setElements("hide")
                });
                t.options.zoomType != "inner" && t.zoomWindow.mouseenter(function() {
                    t.overWindow = !0;
                    t.setElements("hide")
                }).mouseleave(function() {
                    t.overWindow = !1
                });
                t.options.zoomLevel != 1;
                t.minZoomLevel = t.options.minZoomLevel ? t.options.minZoomLevel : t.options.scrollZoomIncrement * 2;
                t.options.scrollZoom && t.zoomContainer.add(t.$elem).bind("mousewheel DOMMouseScroll MozMousePixelScroll", function(i) {
                    t.scrollLock = !0;
                    clearTimeout(n.data(this, "timer"));
                    n.data(this, "timer", setTimeout(function() {
                        t.scrollLock = !1
                    }, 250));
                    var r = i.originalEvent.wheelDelta || i.originalEvent.detail * -1;
                    return i.stopImmediatePropagation(), i.stopPropagation(), i.preventDefault(), r / 120 > 0 ? t.currentZoomLevel >= t.minZoomLevel && t.changeZoomLevel(t.currentZoomLevel - t.options.scrollZoomIncrement) : t.options.maxZoomLevel ? t.currentZoomLevel <= t.options.maxZoomLevel && t.changeZoomLevel(parseFloat(t.currentZoomLevel) + t.options.scrollZoomIncrement) : t.changeZoomLevel(parseFloat(t.currentZoomLevel) + t.options.scrollZoomIncrement), !1
                })
            },
            setElements: function(n) {
                var t = this;
                if (!t.options.zoomEnabled) return !1;
                n == "show" && t.isWindowSet && (t.options.zoomType == "inner" && t.showHideWindow("show"), t.options.zoomType == "window" && t.showHideWindow("show"), t.options.showLens && t.showHideLens("show"), t.options.tint && t.options.zoomType != "inner" && t.showHideTint("show"));
                n == "hide" && (t.options.zoomType == "window" && t.showHideWindow("hide"), t.options.tint || t.showHideWindow("hide"), t.options.showLens && t.showHideLens("hide"), t.options.tint && t.showHideTint("hide"))
            },
            setPosition: function(n) {
                var t = this;
                if (!t.options.zoomEnabled) return !1;
                if (t.nzHeight = t.$elem.height(), t.nzWidth = t.$elem.width(), t.nzOffset = t.$elem.offset(), t.options.tint && t.options.zoomType != "inner" && (t.zoomTint.css({
                        top: 0
                    }), t.zoomTint.css({
                        left: 0
                    })), t.options.responsive && !t.options.scrollZoom && t.options.showLens && (lensHeight = t.nzHeight < t.options.zoomWindowWidth / t.widthRatio ? t.nzHeight : String(t.options.zoomWindowHeight / t.heightRatio), lensWidth = t.largeWidth < t.options.zoomWindowWidth ? t.nzWidth : t.options.zoomWindowWidth / t.widthRatio, t.widthRatio = t.largeWidth / t.nzWidth, t.heightRatio = t.largeHeight / t.nzHeight, t.options.zoomType != "lens" && (lensHeight = t.nzHeight < t.options.zoomWindowWidth / t.widthRatio ? t.nzHeight : String(t.options.zoomWindowHeight / t.heightRatio), lensWidth = t.options.zoomWindowWidth < t.options.zoomWindowWidth ? t.nzWidth : t.options.zoomWindowWidth / t.widthRatio, t.zoomLens.css("width", lensWidth), t.zoomLens.css("height", lensHeight), t.options.tint && (t.zoomTintImage.css("width", t.nzWidth), t.zoomTintImage.css("height", t.nzHeight))), t.options.zoomType == "lens" && t.zoomLens.css({
                        width: String(t.options.lensSize) + "px",
                        height: String(t.options.lensSize) + "px"
                    })), t.zoomContainer.css({
                        top: t.nzOffset.top
                    }), t.zoomContainer.css({
                        left: t.nzOffset.left
                    }), t.mouseLeft = parseInt(n.pageX - t.nzOffset.left), t.mouseTop = parseInt(n.pageY - t.nzOffset.top), t.options.zoomType == "window" && (t.Etoppos = t.mouseTop < t.zoomLens.height() / 2, t.Eboppos = t.mouseTop > t.nzHeight - t.zoomLens.height() / 2 - t.options.lensBorderSize * 2, t.Eloppos = t.mouseLeft < 0 + t.zoomLens.width() / 2, t.Eroppos = t.mouseLeft > t.nzWidth - t.zoomLens.width() / 2 - t.options.lensBorderSize * 2), t.options.zoomType == "inner" && (t.Etoppos = t.mouseTop < t.nzHeight / 2 / t.heightRatio, t.Eboppos = t.mouseTop > t.nzHeight - t.nzHeight / 2 / t.heightRatio, t.Eloppos = t.mouseLeft < 0 + t.nzWidth / 2 / t.widthRatio, t.Eroppos = t.mouseLeft > t.nzWidth - t.nzWidth / 2 / t.widthRatio - t.options.lensBorderSize * 2), t.mouseLeft <= 0 || t.mouseTop < 0 || t.mouseLeft > t.nzWidth || t.mouseTop > t.nzHeight) {
                    t.setElements("hide");
                    return
                }
                t.options.showLens && (t.lensLeftPos = String(t.mouseLeft - t.zoomLens.width() / 2), t.lensTopPos = String(t.mouseTop - t.zoomLens.height() / 2));
                t.Etoppos && (t.lensTopPos = 0);
                t.Eloppos && (t.windowLeftPos = 0, t.lensLeftPos = 0, t.tintpos = 0);
                t.options.zoomType == "window" && (t.Eboppos && (t.lensTopPos = Math.max(t.nzHeight - t.zoomLens.height() - t.options.lensBorderSize * 2, 0)), t.Eroppos && (t.lensLeftPos = t.nzWidth - t.zoomLens.width() - t.options.lensBorderSize * 2));
                t.options.zoomType == "inner" && (t.Eboppos && (t.lensTopPos = Math.max(t.nzHeight - t.options.lensBorderSize * 2, 0)), t.Eroppos && (t.lensLeftPos = t.nzWidth - t.nzWidth - t.options.lensBorderSize * 2));
                t.options.zoomType == "lens" && (t.windowLeftPos = String(((n.pageX - t.nzOffset.left) * t.widthRatio - t.zoomLens.width() / 2) * -1), t.windowTopPos = String(((n.pageY - t.nzOffset.top) * t.heightRatio - t.zoomLens.height() / 2) * -1), t.zoomLens.css({
                    backgroundPosition: t.windowLeftPos + "px " + t.windowTopPos + "px"
                }), t.changeBgSize && (t.nzHeight > t.nzWidth ? (t.options.zoomType == "lens" && t.zoomLens.css({
                    "background-size": t.largeWidth / t.newvalueheight + "px " + t.largeHeight / t.newvalueheight + "px"
                }), t.zoomWindow.css({
                    "background-size": t.largeWidth / t.newvalueheight + "px " + t.largeHeight / t.newvalueheight + "px"
                })) : (t.options.zoomType == "lens" && t.zoomLens.css({
                    "background-size": t.largeWidth / t.newvaluewidth + "px " + t.largeHeight / t.newvaluewidth + "px"
                }), t.zoomWindow.css({
                    "background-size": t.largeWidth / t.newvaluewidth + "px " + t.largeHeight / t.newvaluewidth + "px"
                })), t.changeBgSize = !1), t.setWindowPostition(n));
                t.options.tint && t.options.zoomType != "inner" && t.setTintPosition(n);
                t.options.zoomType == "window" && t.setWindowPostition(n);
                t.options.zoomType == "inner" && t.setWindowPostition(n);
                t.options.showLens && (t.fullwidth && t.options.zoomType != "lens" && (t.lensLeftPos = 0), t.zoomLens.css({
                    left: t.lensLeftPos + "px",
                    top: t.lensTopPos + "px"
                }))
            },
            showHideWindow: function(n) {
                var t = this;
                n == "show" && (t.isWindowActive || (t.options.zoomWindowFadeIn ? t.zoomWindow.stop(!0, !0, !1).fadeIn(t.options.zoomWindowFadeIn) : t.zoomWindow.show(), t.isWindowActive = !0));
                n == "hide" && t.isWindowActive && (t.options.zoomWindowFadeOut ? t.zoomWindow.stop(!0, !0).fadeOut(t.options.zoomWindowFadeOut) : t.zoomWindow.hide(), t.isWindowActive = !1)
            },
            showHideLens: function(n) {
                var t = this;
                n == "show" && (t.isLensActive || (t.options.lensFadeIn ? t.zoomLens.stop(!0, !0, !1).fadeIn(t.options.lensFadeIn) : t.zoomLens.show(), t.isLensActive = !0));
                n == "hide" && t.isLensActive && (t.options.lensFadeOut ? t.zoomLens.stop(!0, !0).fadeOut(t.options.lensFadeOut) : t.zoomLens.hide(), t.isLensActive = !1)
            },
            showHideTint: function(n) {
                var t = this;
                n == "show" && (t.isTintActive || (t.options.zoomTintFadeIn ? t.zoomTint.css({
                    opacity: t.options.tintOpacity
                }).animate().stop(!0, !0).fadeIn("slow") : (t.zoomTint.css({
                    opacity: t.options.tintOpacity
                }).animate(), t.zoomTint.show()), t.isTintActive = !0));
                n == "hide" && t.isTintActive && (t.options.zoomTintFadeOut ? t.zoomTint.stop(!0, !0).fadeOut(t.options.zoomTintFadeOut) : t.zoomTint.hide(), t.isTintActive = !1)
            },
            setLensPostition: function() {},
            setWindowPostition: function(t) {
                var i = this;
                if (isNaN(i.options.zoomWindowPosition)) i.externalContainer = n("#" + i.options.zoomWindowPosition), i.externalContainerWidth = i.externalContainer.width(), i.externalContainerHeight = i.externalContainer.height(), i.externalContainerOffset = i.externalContainer.offset(), i.windowOffsetTop = i.externalContainerOffset.top, i.windowOffsetLeft = i.externalContainerOffset.left;
                else switch (i.options.zoomWindowPosition) {
                    case 1:
                        i.windowOffsetTop = i.options.zoomWindowOffety;
                        i.windowOffsetLeft = +i.nzWidth;
                        break;
                    case 2:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = (i.options.zoomWindowHeight / 2 - i.nzHeight / 2) * -1, i.windowOffsetLeft = i.nzWidth);
                        break;
                    case 3:
                        i.windowOffsetTop = i.nzHeight - i.zoomWindow.height() - i.options.borderSize * 2;
                        i.windowOffsetLeft = i.nzWidth;
                        break;
                    case 4:
                        i.windowOffsetTop = i.nzHeight;
                        i.windowOffsetLeft = i.nzWidth;
                        break;
                    case 5:
                        i.windowOffsetTop = i.nzHeight;
                        i.windowOffsetLeft = i.nzWidth - i.zoomWindow.width() - i.options.borderSize * 2;
                        break;
                    case 6:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = i.nzHeight, i.windowOffsetLeft = (i.options.zoomWindowWidth / 2 - i.nzWidth / 2 + i.options.borderSize * 2) * -1);
                        break;
                    case 7:
                        i.windowOffsetTop = i.nzHeight;
                        i.windowOffsetLeft = 0;
                        break;
                    case 8:
                        i.windowOffsetTop = i.nzHeight;
                        i.windowOffsetLeft = (i.zoomWindow.width() + i.options.borderSize * 2) * -1;
                        break;
                    case 9:
                        i.windowOffsetTop = i.nzHeight - i.zoomWindow.height() - i.options.borderSize * 2;
                        i.windowOffsetLeft = (i.zoomWindow.width() + i.options.borderSize * 2) * -1;
                        break;
                    case 10:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = (i.options.zoomWindowHeight / 2 - i.nzHeight / 2) * -1, i.windowOffsetLeft = (i.zoomWindow.width() + i.options.borderSize * 2) * -1);
                        break;
                    case 11:
                        i.windowOffsetTop = i.options.zoomWindowOffety;
                        i.windowOffsetLeft = (i.zoomWindow.width() + i.options.borderSize * 2) * -1;
                        break;
                    case 12:
                        i.windowOffsetTop = (i.zoomWindow.height() + i.options.borderSize * 2) * -1;
                        i.windowOffsetLeft = (i.zoomWindow.width() + i.options.borderSize * 2) * -1;
                        break;
                    case 13:
                        i.windowOffsetTop = (i.zoomWindow.height() + i.options.borderSize * 2) * -1;
                        i.windowOffsetLeft = 0;
                        break;
                    case 14:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = (i.zoomWindow.height() + i.options.borderSize * 2) * -1, i.windowOffsetLeft = (i.options.zoomWindowWidth / 2 - i.nzWidth / 2 + i.options.borderSize * 2) * -1);
                        break;
                    case 15:
                        i.windowOffsetTop = (i.zoomWindow.height() + i.options.borderSize * 2) * -1;
                        i.windowOffsetLeft = i.nzWidth - i.zoomWindow.width() - i.options.borderSize * 2;
                        break;
                    case 16:
                        i.windowOffsetTop = (i.zoomWindow.height() + i.options.borderSize * 2) * -1;
                        i.windowOffsetLeft = i.nzWidth;
                        break;
                    default:
                        i.windowOffsetTop = i.options.zoomWindowOffety;
                        i.windowOffsetLeft = i.nzWidth
                }
                i.isWindowSet = !0;
                i.windowOffsetTop = i.windowOffsetTop + i.options.zoomWindowOffety;
                i.windowOffsetLeft = i.windowOffsetLeft + i.options.zoomWindowOffetx;
                i.zoomWindow.css({
                    top: i.windowOffsetTop
                });
                i.zoomWindow.css({
                    left: i.windowOffsetLeft
                });
                i.options.zoomType == "inner" && (i.zoomWindow.css({
                    top: 0
                }), i.zoomWindow.css({
                    left: 0
                }));
                i.windowLeftPos = String(((t.pageX - i.nzOffset.left) * i.widthRatio - i.zoomWindow.width() / 2) * -1);
                i.windowTopPos = String(((t.pageY - i.nzOffset.top) * i.heightRatio - i.zoomWindow.height() / 2) * -1);
                i.Etoppos && (i.windowTopPos = 0);
                i.Eloppos && (i.windowLeftPos = 0);
                i.Eboppos && (i.windowTopPos = (i.largeHeight / i.currentZoomLevel - i.zoomWindow.height()) * -1);
                i.Eroppos && (i.windowLeftPos = (i.largeWidth / i.currentZoomLevel - i.zoomWindow.width()) * -1);
                i.fullheight && (i.windowTopPos = 0);
                i.fullwidth && (i.windowLeftPos = 0);
                (i.options.zoomType == "window" || i.options.zoomType == "inner") && (i.zoomLock == 1 && (i.widthRatio <= 1 && (i.windowLeftPos = 0), i.heightRatio <= 1 && (i.windowTopPos = 0)), i.largeHeight < i.options.zoomWindowHeight && (i.windowTopPos = 0), i.largeWidth < i.options.zoomWindowWidth && (i.windowLeftPos = 0), i.options.easing ? (i.xp || (i.xp = 0), i.yp || (i.yp = 0), i.loop || (i.loop = setInterval(function() {
                    i.xp += (i.windowLeftPos - i.xp) / i.options.easingAmount;
                    i.yp += (i.windowTopPos - i.yp) / i.options.easingAmount;
                    i.scrollingLock ? (clearInterval(i.loop), i.xp = i.windowLeftPos, i.yp = i.windowTopPos, i.xp = ((t.pageX - i.nzOffset.left) * i.widthRatio - i.zoomWindow.width() / 2) * -1, i.yp = ((t.pageY - i.nzOffset.top) * i.heightRatio - i.zoomWindow.height() / 2) * -1, i.changeBgSize && (i.nzHeight > i.nzWidth ? (i.options.zoomType == "lens" && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    })) : (i.options.zoomType != "lens" && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvalueheight + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                    })), i.changeBgSize = !1), i.zoomWindow.css({
                        backgroundPosition: i.windowLeftPos + "px " + i.windowTopPos + "px"
                    }), i.scrollingLock = !1, i.loop = !1) : (i.changeBgSize && (i.nzHeight > i.nzWidth ? (i.options.zoomType == "lens" && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    })) : (i.options.zoomType != "lens" && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                    })), i.changeBgSize = !1), i.zoomWindow.css({
                        backgroundPosition: i.xp + "px " + i.yp + "px"
                    }))
                }, 16))) : (i.changeBgSize && (i.nzHeight > i.nzWidth ? (i.options.zoomType == "lens" && i.zoomLens.css({
                    "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                }), i.zoomWindow.css({
                    "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                })) : (i.options.zoomType == "lens" && i.zoomLens.css({
                    "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                }), i.largeHeight / i.newvaluewidth < i.options.zoomWindowHeight ? i.zoomWindow.css({
                    "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                }) : i.zoomWindow.css({
                    "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                })), i.changeBgSize = !1), i.zoomWindow.css({
                    backgroundPosition: i.windowLeftPos + "px " + i.windowTopPos + "px"
                })))
            },
            setTintPosition: function(n) {
                var t = this;
                t.nzOffset = t.$elem.offset();
                t.tintpos = String((n.pageX - t.nzOffset.left - t.zoomLens.width() / 2) * -1);
                t.tintposy = String((n.pageY - t.nzOffset.top - t.zoomLens.height() / 2) * -1);
                t.Etoppos && (t.tintposy = 0);
                t.Eloppos && (t.tintpos = 0);
                t.Eboppos && (t.tintposy = (t.nzHeight - t.zoomLens.height() - t.options.lensBorderSize * 2) * -1);
                t.Eroppos && (t.tintpos = (t.nzWidth - t.zoomLens.width() - t.options.lensBorderSize * 2) * -1);
                t.options.tint && (t.fullheight && (t.tintposy = 0), t.fullwidth && (t.tintpos = 0), t.zoomTintImage.css({
                    left: t.tintpos + "px"
                }), t.zoomTintImage.css({
                    top: t.tintposy + "px"
                }))
            },
            swaptheimage: function(t, i) {
                var r = this,
                    u = new Image;
                r.options.loadingIcon && (r.spinner = n("<div style=\"background: url('" + r.options.loadingIcon + "') no-repeat center;height:" + r.nzHeight + "px;width:" + r.nzWidth + 'px;z-index: 2000;position: absolute; background-position: center center;"><\/div>'), r.$elem.after(r.spinner));
                r.options.onImageSwap(r.$elem);
                u.onload = function() {
                    r.largeWidth = u.width;
                    r.largeHeight = u.height;
                    r.zoomImage = i;
                    r.zoomWindow.css({
                        "background-size": r.largeWidth + "px " + r.largeHeight + "px"
                    });
                    r.zoomWindow.css({
                        "background-size": r.largeWidth + "px " + r.largeHeight + "px"
                    });
                    r.swapAction(t, i);
                    return
                };
                u.src = i
            },
            swapAction: function(t, i) {
                var r = this,
                    u = new Image,
                    f, e, o, s;
                u.onload = function() {
                    r.nzHeight = u.height;
                    r.nzWidth = u.width;
                    r.options.onImageSwapComplete(r.$elem);
                    r.doneCallback();
                    return
                };
                u.src = t;
                r.currentZoomLevel = r.options.zoomLevel;
                r.options.maxZoomLevel = !1;
                r.options.zoomType == "lens" && r.zoomLens.css({
                    backgroundImage: "url('" + i + "')"
                });
                r.options.zoomType == "window" && r.zoomWindow.css({
                    backgroundImage: "url('" + i + "')"
                });
                r.options.zoomType == "inner" && r.zoomWindow.css({
                    backgroundImage: "url('" + i + "')"
                });
                r.currentImage = i;
                r.options.imageCrossfade ? (f = r.$elem, e = f.clone(), r.$elem.attr("src", t), r.$elem.after(e), e.stop(!0).fadeOut(r.options.imageCrossfade, function() {
                    n(this).remove()
                }), r.$elem.width("auto").removeAttr("width"), r.$elem.height("auto").removeAttr("height"), f.fadeIn(r.options.imageCrossfade), r.options.tint && r.options.zoomType != "inner" && (o = r.zoomTintImage, s = o.clone(), r.zoomTintImage.attr("src", i), r.zoomTintImage.after(s), s.stop(!0).fadeOut(r.options.imageCrossfade, function() {
                    n(this).remove()
                }), o.fadeIn(r.options.imageCrossfade), r.zoomTint.css({
                    height: r.$elem.height()
                }), r.zoomTint.css({
                    width: r.$elem.width()
                })), r.zoomContainer.css("height", r.$elem.height()), r.zoomContainer.css("width", r.$elem.width()), r.options.zoomType == "inner" && (r.options.constrainType || (r.zoomWrap.parent().css("height", r.$elem.height()), r.zoomWrap.parent().css("width", r.$elem.width()), r.zoomWindow.css("height", r.$elem.height()), r.zoomWindow.css("width", r.$elem.width()))), r.options.imageCrossfade && (r.zoomWrap.css("height", r.$elem.height()), r.zoomWrap.css("width", r.$elem.width()))) : (r.$elem.attr("src", t), r.options.tint && (r.zoomTintImage.attr("src", i), r.zoomTintImage.attr("height", r.$elem.height()), r.zoomTintImage.css({
                    height: r.$elem.height()
                }), r.zoomTint.css({
                    height: r.$elem.height()
                })), r.zoomContainer.css("height", r.$elem.height()), r.zoomContainer.css("width", r.$elem.width()), r.options.imageCrossfade && (r.zoomWrap.css("height", r.$elem.height()), r.zoomWrap.css("width", r.$elem.width())));
                r.options.constrainType && (r.options.constrainType == "height" && (r.zoomContainer.css("height", r.options.constrainSize), r.zoomContainer.css("width", "auto"), r.options.imageCrossfade ? (r.zoomWrap.css("height", r.options.constrainSize), r.zoomWrap.css("width", "auto"), r.constwidth = r.zoomWrap.width()) : (r.$elem.css("height", r.options.constrainSize), r.$elem.css("width", "auto"), r.constwidth = r.$elem.width()), r.options.zoomType == "inner" && (r.zoomWrap.parent().css("height", r.options.constrainSize), r.zoomWrap.parent().css("width", r.constwidth), r.zoomWindow.css("height", r.options.constrainSize), r.zoomWindow.css("width", r.constwidth)), r.options.tint && (r.tintContainer.css("height", r.options.constrainSize), r.tintContainer.css("width", r.constwidth), r.zoomTint.css("height", r.options.constrainSize), r.zoomTint.css("width", r.constwidth), r.zoomTintImage.css("height", r.options.constrainSize), r.zoomTintImage.css("width", r.constwidth))), r.options.constrainType == "width" && (r.zoomContainer.css("height", "auto"), r.zoomContainer.css("width", r.options.constrainSize), r.options.imageCrossfade ? (r.zoomWrap.css("height", "auto"), r.zoomWrap.css("width", r.options.constrainSize), r.constheight = r.zoomWrap.height()) : (r.$elem.css("height", "auto"), r.$elem.css("width", r.options.constrainSize), r.constheight = r.$elem.height()), r.options.zoomType == "inner" && (r.zoomWrap.parent().css("height", r.constheight), r.zoomWrap.parent().css("width", r.options.constrainSize), r.zoomWindow.css("height", r.constheight), r.zoomWindow.css("width", r.options.constrainSize)), r.options.tint && (r.tintContainer.css("height", r.constheight), r.tintContainer.css("width", r.options.constrainSize), r.zoomTint.css("height", r.constheight), r.zoomTint.css("width", r.options.constrainSize), r.zoomTintImage.css("height", r.constheight), r.zoomTintImage.css("width", r.options.constrainSize))))
            },
            doneCallback: function() {
                var n = this;
                n.options.loadingIcon && n.spinner.hide();
                n.nzOffset = n.$elem.offset();
                n.nzWidth = n.$elem.width();
                n.nzHeight = n.$elem.height();
                n.currentZoomLevel = n.options.zoomLevel;
                n.widthRatio = n.largeWidth / n.nzWidth;
                n.heightRatio = n.largeHeight / n.nzHeight;
                n.options.zoomType == "window" && (lensHeight = n.nzHeight < n.options.zoomWindowWidth / n.widthRatio ? n.nzHeight : String(n.options.zoomWindowHeight / n.heightRatio), lensWidth = n.options.zoomWindowWidth < n.options.zoomWindowWidth ? n.nzWidth : n.options.zoomWindowWidth / n.widthRatio, n.zoomLens && (n.zoomLens.css("width", lensWidth), n.zoomLens.css("height", lensHeight)))
            },
            getCurrentImage: function() {
                var n = this;
                return n.zoomImage
            },
            getGalleryList: function() {
                var t = this;
                return t.gallerylist = [], t.options.gallery ? n("#" + t.options.gallery + " a").each(function() {
                    var i = "";
                    n(this).data("zoom-image") ? i = n(this).data("zoom-image") : n(this).data("image") && (i = n(this).data("image"));
                    i == t.zoomImage ? t.gallerylist.unshift({
                        href: "" + i + "",
                        title: n(this).find("img").attr("title")
                    }) : t.gallerylist.push({
                        href: "" + i + "",
                        title: n(this).find("img").attr("title")
                    })
                }) : t.gallerylist.push({
                    href: "" + t.zoomImage + "",
                    title: n(this).find("img").attr("title")
                }), t.gallerylist
            },
            changeZoomLevel: function(n) {
                var t = this;
                t.scrollingLock = !0;
                t.newvalue = parseFloat(n).toFixed(2);
                newvalue = parseFloat(n).toFixed(2);
                maxheightnewvalue = t.largeHeight / (t.options.zoomWindowHeight / t.nzHeight * t.nzHeight);
                maxwidthtnewvalue = t.largeWidth / (t.options.zoomWindowWidth / t.nzWidth * t.nzWidth);
                t.options.zoomType != "inner" && (maxheightnewvalue <= newvalue ? (t.heightRatio = t.largeHeight / maxheightnewvalue / t.nzHeight, t.newvalueheight = maxheightnewvalue, t.fullheight = !0) : (t.heightRatio = t.largeHeight / newvalue / t.nzHeight, t.newvalueheight = newvalue, t.fullheight = !1), maxwidthtnewvalue <= newvalue ? (t.widthRatio = t.largeWidth / maxwidthtnewvalue / t.nzWidth, t.newvaluewidth = maxwidthtnewvalue, t.fullwidth = !0) : (t.widthRatio = t.largeWidth / newvalue / t.nzWidth, t.newvaluewidth = newvalue, t.fullwidth = !1), t.options.zoomType == "lens" && (maxheightnewvalue <= newvalue ? (t.fullwidth = !0, t.newvaluewidth = maxheightnewvalue) : (t.widthRatio = t.largeWidth / newvalue / t.nzWidth, t.newvaluewidth = newvalue, t.fullwidth = !1)));
                t.options.zoomType == "inner" && (maxheightnewvalue = parseFloat(t.largeHeight / t.nzHeight).toFixed(2), maxwidthtnewvalue = parseFloat(t.largeWidth / t.nzWidth).toFixed(2), newvalue > maxheightnewvalue && (newvalue = maxheightnewvalue), newvalue > maxwidthtnewvalue && (newvalue = maxwidthtnewvalue), maxheightnewvalue <= newvalue ? (t.heightRatio = t.largeHeight / newvalue / t.nzHeight, t.newvalueheight = newvalue > maxheightnewvalue ? maxheightnewvalue : newvalue, t.fullheight = !0) : (t.heightRatio = t.largeHeight / newvalue / t.nzHeight, t.newvalueheight = newvalue > maxheightnewvalue ? maxheightnewvalue : newvalue, t.fullheight = !1), maxwidthtnewvalue <= newvalue ? (t.widthRatio = t.largeWidth / newvalue / t.nzWidth, t.newvaluewidth = newvalue > maxwidthtnewvalue ? maxwidthtnewvalue : newvalue, t.fullwidth = !0) : (t.widthRatio = t.largeWidth / newvalue / t.nzWidth, t.newvaluewidth = newvalue, t.fullwidth = !1));
                scrcontinue = !1;
                t.options.zoomType == "inner" && (t.nzWidth > t.nzHeight && (t.newvaluewidth <= maxwidthtnewvalue ? scrcontinue = !0 : (scrcontinue = !1, t.fullheight = !0, t.fullwidth = !0)), t.nzHeight > t.nzWidth && (t.newvaluewidth <= maxwidthtnewvalue ? scrcontinue = !0 : (scrcontinue = !1, t.fullheight = !0, t.fullwidth = !0)));
                t.options.zoomType != "inner" && (scrcontinue = !0);
                scrcontinue && (t.zoomLock = 0, t.changeZoom = !0, t.options.zoomWindowHeight / t.heightRatio <= t.nzHeight && (t.currentZoomLevel = t.newvalueheight, t.options.zoomType != "lens" && t.options.zoomType != "inner" && (t.changeBgSize = !0, t.zoomLens.css({
                    height: String(t.options.zoomWindowHeight / t.heightRatio) + "px"
                })), (t.options.zoomType == "lens" || t.options.zoomType == "inner") && (t.changeBgSize = !0)), t.options.zoomWindowWidth / t.widthRatio <= t.nzWidth && (t.options.zoomType != "inner" && t.newvaluewidth > t.newvalueheight && (t.currentZoomLevel = t.newvaluewidth), t.options.zoomType != "lens" && t.options.zoomType != "inner" && (t.changeBgSize = !0, t.zoomLens.css({
                    width: String(t.options.zoomWindowWidth / t.widthRatio) + "px"
                })), (t.options.zoomType == "lens" || t.options.zoomType == "inner") && (t.changeBgSize = !0)), t.options.zoomType == "inner" && (t.changeBgSize = !0, t.nzWidth > t.nzHeight && (t.currentZoomLevel = t.newvaluewidth), t.nzHeight > t.nzWidth && (t.currentZoomLevel = t.newvaluewidth)));
                t.setPosition(t.currentLoc)
            },
            closeAll: function() {
                self.zoomWindow && self.zoomWindow.hide();
                self.zoomLens && self.zoomLens.hide();
                self.zoomTint && self.zoomTint.hide()
            },
            changeState: function(n) {
                var t = this;
                n == "enable" && (t.options.zoomEnabled = !0);
                n == "disable" && (t.options.zoomEnabled = !1)
            }
        };
        n.fn.elevateZoom = function(i) {
            return this.each(function() {
                var r = Object.create(t);
                r.init(i, this);
                n.data(this, "elevateZoom", r)
            })
        };
        n.fn.elevateZoom.options = {
            zoomActivation: "hover",
            zoomEnabled: !0,
            preloading: 1,
            zoomLevel: 1,
            scrollZoom: !1,
            scrollZoomIncrement: .1,
            minZoomLevel: !1,
            maxZoomLevel: !1,
            easing: !1,
            easingAmount: 12,
            lensSize: 200,
            zoomWindowWidth: 400,
            zoomWindowHeight: 400,
            zoomWindowOffetx: 0,
            zoomWindowOffety: 0,
            zoomWindowPosition: 1,
            zoomWindowBgColour: "#fff",
            lensFadeIn: !1,
            lensFadeOut: !1,
            debug: !1,
            zoomWindowFadeIn: !1,
            zoomWindowFadeOut: !1,
            zoomWindowAlwaysShow: !1,
            zoomTintFadeIn: !1,
            zoomTintFadeOut: !1,
            borderSize: 4,
            showLens: !0,
            borderColour: "#888",
            lensBorderSize: 1,
            lensBorderColour: "#000",
            lensShape: "square",
            zoomType: "window",
            containLensZoom: !1,
            lensColour: "white",
            lensOpacity: .4,
            lenszoom: !1,
            tint: !1,
            tintColour: "#333",
            tintOpacity: .4,
            gallery: !1,
            galleryActiveClass: "zoomGalleryActive",
            imageCrossfade: !1,
            constrainType: !1,
            constrainSize: !1,
            loadingIcon: !1,
            cursor: "default",
            responsive: !0,
            onComplete: n.noop,
            onZoomedImageLoaded: function() {},
            onImageSwap: n.noop,
            onImageSwapComplete: n.noop
        }
    }(jQuery, window, document);
/*!
 * FitVids 1.1
 *
 * Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 */
(function(n) {
    "use strict";
    n.fn.fitVids = function(t) {
        var i = {
            customSelector: null,
            ignore: null
        };
        if (!document.getElementById("fit-vids-style")) {
            var u = document.head || document.getElementsByTagName("head")[0],
                r = document.createElement("div");
            r.innerHTML = '<p>x<\/p><style id="fit-vids-style">.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}<\/style>';
            u.appendChild(r.childNodes[1])
        }
        return t && n.extend(i, t), this.each(function() {
            var u = ["iframe[src*='player.vimeo.com']", "iframe[src*='youtube.com']", "iframe[src*='youtube-nocookie.com']", "iframe[src*='kickstarter.com'][src*='video.html']", "object", "embed"],
                r, t;
            i.customSelector && u.push(i.customSelector);
            r = ".fitvidsignore";
            i.ignore && (r = r + ", " + i.ignore);
            t = n(this).find(u.join(","));
            t = t.not("object object");
            t = t.not(r);
            t.each(function() {
                var t = n(this),
                    i;
                if (!(t.parents(r).length > 0) && (this.tagName.toLowerCase() !== "embed" || !t.parent("object").length) && !t.parent(".fluid-width-video-wrapper").length) {
                    t.css("height") || t.css("width") || !(isNaN(t.attr("height")) || isNaN(t.attr("width"))) || (t.attr("height", 9), t.attr("width", 16));
                    var u = this.tagName.toLowerCase() === "object" || t.attr("height") && !isNaN(parseInt(t.attr("height"), 10)) ? parseInt(t.attr("height"), 10) : t.height(),
                        f = isNaN(parseInt(t.attr("width"), 10)) ? t.width() : parseInt(t.attr("width"), 10),
                        e = u / f;
                    t.attr("id") || (i = "fitvid" + Math.floor(Math.random() * 999999), t.attr("id", i));
                    t.wrap('<div class="fluid-width-video-wrapper"><\/div>').parent(".fluid-width-video-wrapper").css("padding-top", e * 100 + "%");
                    t.removeAttr("height").removeAttr("width")
                }
            })
        })
    }
})(window.jQuery || window.Zepto);
FFAPI.variables.video = {};
FFAPI.methods.video = {};
FFAPI.variables.video.mediaPlayer = [];
FFAPI.variables.video.play = [];
FFAPI.variables.video.mediaPlayerLength = 0;
FFAPI.variables.video.playLength = 0;
FFAPI.variables.video.playing = !1;
FFAPI.variables.video.loaded = !1;
FFAPI.variables.video.originalHtml = "";
FFAPI.methods.video.checkVideoSupport = function() {
    "use strict";
    return document.getElementsByClassName("js-video-element") && Modernizr.video && FFAPI.methods.video.getVideoFromCaroussel(), !0
};
FFAPI.methods.video.resetVideo = function() {
    var n = this.getAttribute("clickedID");
    FFAPI.methods.video.exitFullScreen(n);
    FFAPI.methods.video.setCurrentTime(n)
};
FFAPI.methods.video.exitFullScreen = function(n) {
    FFAPI.variables.video.mediaVideoElements[n].webkitExitFullscreen()
};
FFAPI.methods.video.setCurrentTime = function(n) {
    setTimeout(function() {
        FFAPI.variables.video.mediaVideoElements[n].currentTime = 4
    }, 2e3)
};
FFAPI.methods.video.getVideoFromCaroussel = function() {
    "use strict";
    var n = 0,
        t = document.getElementsByClassName("js-video-element"),
        f = t[0].getAttribute("src"),
        r = t[0].getAttribute("data-video-id"),
        e = t[0].getAttribute("data-video-controls"),
        o = t[0].getAttribute("data-video-mp4"),
        s = t[0].getAttribute("data-video-webm"),
        h = t[0].getAttribute("data-video-ogg"),
        u = document.getElementsByClassName("js-video"),
        c = u.length,
        i = "";
    if (i = FFAPI.variables.touchSupported ? '<video class="' + r + '" width="100%" height="100%" poster="' + f + '" controls="controls" preload="auto">' : '<video class="' + r + '" width="100%" height="100%" poster="' + f + '" controls="false" preload="auto">', u && (FFAPI.variables.video.originalHtml = u[0].innerHTML), o && (i += '<source src="' + o + '" type="video/mp4">'), s && (i += '<source src="' + s + '" type="video/wbm">'), h && (i += '<source src="' + h + '" type="video/ogg">'), i += '<\/video><div class="media-controls"><div id="play-pause-button" class="play"><span class="icon-play glyphs"><\/span><\/div><\/div>', c) {
        for (n; n < c; n++) u[n].innerHTML = i;
        if (FFAPI.variables.video.loaded = !0, FFAPI.variables.touchSupported)
            for (FFAPI.variables.video.mediaVideoElements = document.getElementsByClassName("media-video"), FFAPI.variables.video.mediaVideoElementsLength = FFAPI.variables.video.mediaVideoElements.length, n = 0; n < FFAPI.variables.video.mediaVideoElementsLength; n++) FFAPI.variables.video.mediaVideoElements[n].setAttribute("clickedId", n), FFAPI.variables.touchSupported && FFAPI.variables.video.mediaVideoElements[n].setAttribute("controls", ""), FFAPI.variables.video.mediaVideoElements[n].addEventListener("ended", FFAPI.methods.video.resetVideo)
    }
    if (r)
        for (FFAPI.variables.video.mediaPlayer = document.getElementsByClassName(r), FFAPI.variables.video.mediaPlayerLength = FFAPI.variables.video.mediaPlayer.length, FFAPI.methods.bindElemClick(FFAPI.variables.video.mediaPlayer, FFAPI.methods.video.playCarousselVideoBind), n = 0; n < FFAPI.variables.video.mediaPlayerLength; n++) FFAPI.variables.touchSupported ? FFAPI.variables.video.mediaPlayer[n].setAttribute("controls", "") : FFAPI.variables.video.mediaPlayer[n].controls = !1, FFAPI.variables.video.mediaPlayer[n].addEventListener("ended", FFAPI.methods.video.endedCarousselVideo);
    return e && (FFAPI.variables.video.play = document.getElementsByClassName(e), FFAPI.variables.video.playLength = FFAPI.variables.video.play.length, FFAPI.methods.bindElemClick(FFAPI.variables.video.play, FFAPI.methods.video.playCarousselVideoBind)), !0
};
FFAPI.methods.video.playCarousselVideoBind = function(n) {
    "use strict";
    var t;
    return window.event ? (t = window.event, t.preventDefault ? (t.preventDefault(), t.stopPropagation()) : (t.returnValue = !1, t.cancelBubble = !0)) : (t = n, t.preventDefault(), t.stopPropagation()), FFAPI.methods.video.playCarousselVideo(), FFAPI.methods.unbindElemClick(FFAPI.variables.video.mediaPlayer, FFAPI.methods.video.playCarousselVideo), FFAPI.methods.unbindElemClick(FFAPI.variables.video.play, FFAPI.methods.video.playCarousselVideo), FFAPI.methods.bindElemClick(FFAPI.variables.video.mediaPlayer, FFAPI.methods.video.stopCarousselVideoBind), FFAPI.methods.bindElemClick(FFAPI.variables.video.play, FFAPI.methods.video.stopCarousselVideoBind), !1
};
FFAPI.methods.video.stopCarousselVideoBind = function() {
    "use strict";
    return FFAPI.methods.video.stopCarousselVideo(), FFAPI.methods.unbindElemClick(FFAPI.variables.video.mediaPlayer, FFAPI.methods.video.stopCarousselVideoBind), FFAPI.methods.unbindElemClick(FFAPI.variables.video.play, FFAPI.methods.video.stopCarousselVideoBind), FFAPI.methods.bindElemClick(FFAPI.variables.video.mediaPlayer, FFAPI.methods.video.playCarousselVideo), FFAPI.methods.bindElemClick(FFAPI.variables.video.play, FFAPI.methods.video.playCarousselVideo), !0
};
FFAPI.methods.video.unloadVideoFromSlider = function() {
    "use strict";
    FFAPI.methods.video.stopCarousselVideoBind();
    var n = 0,
        t = document.getElementsByClassName("js-video"),
        i = t.length;
    if (i) {
        for (n; n < i; n++) t[n].innerHTML = FFAPI.variables.video.originalHtml;
        FFAPI.variables.video.loaded = !1
    }
    return !0
};
FFAPI.methods.video.playCarousselVideo = function() {
    "use strict";
    var n = 0;
    for (n; n < FFAPI.variables.video.mediaPlayerLength; n++) FFAPI.variables.video.mediaPlayer[n].play();
    for (FFAPI.variables.video.playing = !0, n = 0; n < FFAPI.variables.video.playLength; n++) FFAPI.methods.removeClass(FFAPI.variables.video.play[n], "play-stop"), FFAPI.methods.addClass(FFAPI.variables.video.play[n], "play-start");
    return !0
};
FFAPI.methods.video.stopCarousselVideo = function() {
    "use strict";
    var n = 0;
    for (n; n < FFAPI.variables.video.mediaPlayerLength; n++) FFAPI.variables.video.mediaPlayer[n].pause();
    for (FFAPI.variables.video.playing = !1, n = 0; n < FFAPI.variables.video.playLength; n++) FFAPI.methods.removeClass(FFAPI.variables.video.play[n], "play-start"), FFAPI.methods.addClass(FFAPI.variables.video.play[n], "play-stop");
    return !0
};
FFAPI.methods.video.endedCarousselVideo = function() {
    "use strict";
    var n = 0;
    for (this.load(), n; n < FFAPI.variables.video.playLength; n++) FFAPI.methods.removeClass(FFAPI.variables.video.play[n], "play-start"), FFAPI.methods.addClass(FFAPI.variables.video.play[n], "play-stop");
    return FFAPI.methods.unbindElemClick(FFAPI.variables.video.mediaPlayer, FFAPI.methods.video.stopCarousselVideoBind), FFAPI.methods.unbindElemClick(FFAPI.variables.video.play, FFAPI.methods.video.stopCarousselVideoBind), FFAPI.methods.bindElemClick(FFAPI.variables.video.mediaPlayer, FFAPI.methods.video.playCarousselVideoBind), FFAPI.methods.bindElemClick(FFAPI.variables.video.play, FFAPI.methods.video.playCarousselVideoBind), FFAPI.variables.video.playing = !1, !0
};
FFAPI.methods.video.removeVideoSliderElements = function() {
    "use strict";
    var n = 0,
        f = document.getElementsByClassName("js-sliderProductPage"),
        i = document.getElementsByClassName("bx-pager-thumb"),
        t = document.getElementsByClassName("js-video"),
        o = t.length,
        r = document.getElementsByClassName("js-video-thumb"),
        s = t.length,
        u = "",
        e = "";
    if (t && f)
        for (n; n < o; n++) f[0].removeChild(t[n]);
    if (r && i)
        for (n = 0; n < s; n++) i[0].removeChild(r[n]);
    if (r)
        for (u = i[0].getElementsByTagName("a"), e = u.length, n = 0; n < e; n++) u[n].setAttribute("data-slide-index", n);
    return !0
};
$(document).ready(function() {
    "use strict";
    Modernizr.video || FFAPI.methods.video.removeVideoSliderElements()
});
try {
    FFAPI.methods.product = FFAPI.methods.product || {};
    FFAPI.variables.product = FFAPI.variables.product || {};
    FFAPI.variables.product.productSliderSelector = ".js-sliderProductPage";
    FFAPI.variables.product.productFullscreenSliderSelector = ".js-sliderProductFull";
    FFAPI.variables.product.productFullscreenDivID = "productFullscreen";
    FFAPI.variables.product.productFullscreenTemplateUrl = "/static/js/ajax/productFullscreen.html";
    var largeSliderOptions = {
            minSlides: 3,
            maxSlides: 3,
            slideWidth: 480,
            slideMargin: 2,
            moveSlides: 1,
            pager: !1
        },
        mediumSliderOptions = {
            minSlides: 3,
            maxSlides: 3,
            slideWidth: 480,
            slideMargin: 2,
            moveSlides: 1,
            pager: !1
        },
        smallSliderOptions = {
            minSlides: 1,
            maxSlides: 1,
            slideWidth: 180,
            slideMargin: 2,
            moveSlides: 1,
            pager: !0
        };
    FFAPI.methods.product.rollover = function(n) {
        "use strict";
        if (!Modernizr.touch) {
            var t = $(".zoomContainer");
            t.length > 0 && t.remove();
            n.find("img").elevateZoom({
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 500,
                zoomWindowFadeOut: 750,
                responsive: !0
            })
        }
    };
    FFAPI.methods.product.defaultSlideCallback = function(n) {
        "use strict";
        $(FFAPI.variables.product.productSliderSelector).find("a").removeClass("slider-active").removeAttr("data-toggle").removeAttr("data-target").removeAttr("href");
        n.attr({
            "data-toggle": "modal",
            "data-target": ".productDetail-modalSlider",
            href: ""
        });
        n.hasClass("js-video") || FFAPI.variables.video.loaded && (FFAPI.methods.video.unloadVideoFromSlider(), $(".sliderProductModule-fullscreen-btn").css("visibility", "visible"));
        n.addClass("slider-active");
        FFAPI.methods.product.rollover(n)
    };
    FFAPI.methods.product.defaultSlideOptions = function(n) {
        "use strict";
        var t = $(FFAPI.variables.product.productSliderSelector).find("a").length;
        return t < 3 && $(".sliderProductModule").addClass("sliderProductModule-Min"), t <= 1 && $(".sliderProductModule").removeClass("sliderProductModule-Min").addClass("sliderProductModule-Single"), {
            pagerCustom: n.pager ? null : ".bx-pager-thumb",
            startSlide: n.startSlide || 0,
            minSlides: n.minSlides || 3,
            maxSlides: n.maxSlides || 3,
            slideWidth: n.slideWidth || 480,
            slideMargin: n.slideMargin || 2,
            moveSlides: n.moveSlides || 1,
            pager: n.pager || !0,
            controls: n.controls !== undefined ? n.controls : !0,
            onSliderLoad: function(n) {
                var t = $(FFAPI.variables.product.productSliderSelector).find("a").not(".bx-clone").eq(n).addClass("slider-active");
                t.attr({
                    "data-toggle": "modal",
                    "data-target": ".productDetail-modalSlider",
                    href: ""
                });
                FFAPI.methods.product.rollover(t);
                $(FFAPI.variables.product.productSliderSelector).css("visibility", "visible")
            },
            onSlideBefore: function(n) {
                if (n.hasClass("js-video")) FFAPI.methods.video.getVideoFromCaroussel(), $(".sliderProductModule-fullscreen-btn").css("visibility", "hidden");
                else {
                    var t = $(".zoomContainer");
                    t.length > 0 && t.remove()
                }
            },
            onSlideAfter: FFAPI.methods.product.defaultSlideCallback,
            onSlideNext: FFAPI.methods.product.defaultSlideCallback,
            onSlidePrev: FFAPI.methods.product.defaultSlideCallback
        }
    };
    FFAPI.methods.product.createSlider = function(n) {
        "use strict";
        return $(FFAPI.variables.product.productSliderSelector).bxSlider(FFAPI.methods.product.defaultSlideOptions(n))
    };
    FFAPI.methods.product.reloadProductSlider = function(n) {
        "use strict";
        FFAPI.variables.product.slider.reloadSlider(FFAPI.methods.product.defaultSlideOptions(n));
        FFAPI.variables.video.playing && FFAPI.methods.video.playCarousselVideo()
    };
    FFAPI.methods.product.createFullscreenSlider = function() {
        "use strict";
        var n = {},
            t;
        window.innerWidth < 767 && (n = {
            pager: !0
        }, Modernizr.touch && (n.controls = !1), $(".bx-pager-thumbFull").hide());
        n.pagerCustom = n.pager ? null : ".bx-pager-thumbFull";
        t = FFAPI.variables.product.slider.getCurrentSlide() || 0;
        t != 0 && $(".js-video", FFAPI.variables.product.slider).length > 0 && t--;
        n.startSlide = t;
        FFAPI.variables.product.sliderFullScreen = $(FFAPI.variables.product.productFullscreenSliderSelector).bxSlider(n)
    };
    FFAPI.methods.product.lockButtonAction = function() {
        "use strict";
        $("#divWishlist").unbind("click").bind("click", function(n) {
            return n.preventDefault(), !1
        })
    };
    FFAPI.methods.product.unlockButtonAction = function() {
        "use strict";
        $("#divWishlist").unbind("click")
    };
    FFAPI.methods.product.onAddToWishlist = function() {
        FFAPI.methods.product.unlockButtonAction();
        FFAPI.methods.header.needRefreshHeaderTab(2);
        var n = {
            id: window.universal_variable.product.id,
            unit_price: window.universal_variable.product.unit_price,
            quantity: 1
        };
        $(document).trigger("WishListUpdated", n)
    };
    FFAPI.methods.product.createProductSizesDropdown = function() {
        require(["forms_validations"], function() {
            $(".customdropdown").dropdown({
                onItemClick: function(n) {
                    var t, i, e;
                    n.preventDefault();
                    t = $(this);
                    $("#spanSelectedSizeText").html(FFAPI.translations.size + " " + t.find(".productDetailModule-dropdown-numberItems").html() + " " + FFAPI.translations.selected);
                    i = t.find(".sizeposition").val();
                    e = t.find(".sizedesc").val();
                    $("#hiddenSize").val(i);
                    $("#hiddenSizeDesc").val(e);
                    var r = $("#btnAddToWishlist"),
                        u = r.attr("href"),
                        f = u.match("(&sizeSelected=.*)");
                    f != null && f.length > 0 ? r.attr("href", u.replace(f[0], "&sizeSelected=" + i)) : r.attr("href", u + "&sizeSelected=" + i)
                }
            })
        })
    };
    FFAPI.methods.product.createProductSizesUnavailableDropdown = function() {
        require(["forms_validations"], function() {
            $(".sizeUnavailableDropdown").dropdown({
                onItemClick: function(n) {
                    n.preventDefault();
                    $("#sizeUnavailableValue").val($(this).attr("data-size-pos"))
                }
            })
        })
    };
    FFAPI.methods.product.checkOneSizeOnly = function() {
        var t = $("#divSizesInformation ul.productDetailModule-selectSize"),
            n = t.find("[data-sizeid='OS']");
        n.length > 0 && t.find("li").length == 1 && (n.length > 1 && (n = n.filter("[data-store-id='" + window.universal_variable.product.storeId + "']")), n.trigger("click"))
    };
    require(["essentials_plugins"], function() {
        FFAPI.methods.product.checkOneSizeOnly()
    });
    FFAPI.methods.product.AddToCartTrack = function() {
        try {
            window.resx = {};
            resx.appid = "Farfetch01";
            FFAPI && FFAPI.variables && FFAPI.variables.lang && (FFAPI.variables.lang === "BR" ? resx.appid = "Farfetchbr" : FFAPI.variables.lang === "FR" && (resx.appid = "Farfetchfr"));
            window.universal_variable.user.isLogged && (resx.customerid = window.universal_variable.user.user_id);
            resx.event = "cart_op";
            resx.itemid = window.universal_variable.product.id;
            certonaResx.run()
        } catch (n) {}
    };
    FFAPI.methods.product.reloadFullscreenSlider = function() {
        "use strict";
        var n = {};
        window.innerWidth < 767 ? (n = {
            pager: !0
        }, Modernizr.touch && (n.controls = !1), $(".bx-pager-thumbFull").hide()) : $(".bx-pager-thumbFull").show();
        n.pagerCustom = n.pager ? null : ".bx-pager-thumbFull";
        n.startSlide = FFAPI.variables.product.sliderFullScreen.getCurrentSlide() || 0;
        FFAPI.variables.product.sliderFullScreen.reloadSlider(n)
    };
    FFAPI.methods.product.hideSizesInformation = function(n) {
        "use strict";
        n.indexOf("field-validation-error") > -1 || ($("#divSizesInformation").hide(), $("#divWishlist").hide(), FFAPI.methods.product.bindOrderByEmailForm())
    };
    FFAPI.methods.product.bindOrderByEmailForm = function() {
        "use strict";
        FFAPI.variables.formsToValidate = $("form[data-ajax=true], .form-validator");
        FFAPI.variables.formsToValidate.data("unobtrusiveValidation", null);
        FFAPI.variables.formsToValidate.data("validator", null);
        $.validator.unobtrusive.parse(document)
    };
    FFAPI.methods.product.getBoutiqueInfo = function() {
        "use strict";
        var n = document.getElementsByClassName("productDetail-boutique-container")[0];
        n && window.innerWidth >= 768 ? n.style.display = "block" : n && (n.style.display = "none")
    };

    function mqValidation() {
        "use strict";
        var n = {};
        return window.innerWidth >= 1024 ? $.extend(!0, n, largeSliderOptions) : window.innerWidth <= 767 ? ($.extend(!0, n, smallSliderOptions), Modernizr.touch && (n.controls = !1)) : $.extend(!0, n, mediumSliderOptions), n
    }
    $(window).smartresize(function() {
        "use strict";
        var n = mqValidation();
        n.startSlide = FFAPI.variables.product.slider.getCurrentSlide() || 0;
        FFAPI.methods.product.reloadProductSlider(n);
        $(".productDetail-modalSlider").is(":visible") && FFAPI.methods.product.reloadFullscreenSlider();
        FFAPI.methods.product.getBoutiqueInfo()
    }, FFAPI.variables.resizeWindowTime);
    $(document).ready(function(n) {
        var i, t, r;
        n("#divSizesInformation .productDetailModule-selectSize li").on("click", function(t) {
            if (!n(t.target).is("a")) {
                var i = n(this).find("a");
                i.trigger("click")
            }
        });
        n(".sizeUnavailableDropdown li").on("click", function(t) {
            if (!n(t.target).is("a")) {
                var i = n(this).find("a"),
                    r = i.text();
                n("span.sizeUnavailableValue").html(r);
                n(this).find("a").trigger("click")
            }
        });
        i = new PluginAccordion("accordion-detail", !1, "accordion-opened", "accordion-opened");
        i.open(0);
        require(["forms_validations"], function() {
            n("#form_validate").validate({
                onfocusout: !1,
                errorClass: "form-validator_error",
                validClass: "form-validator_success"
            })
        });
        n(".productDetail-modalSlider").on("shown.bs.modal", function() {
            "use strict";
            for (var i = n(".sliderProduct-slide img", this), t = 0; t <= i.length - 1; t++) FFAPI.responsive.cacheAndLoadImage(i[t], i[t].getAttribute("data-fullsrc"), FFAPI.responsive.changeImageSrc);
            FFAPI.methods.product.createFullscreenSlider()
        });
        n(".productDetail-modalSlider").on("hidden.bs.modal", function() {
            "use strict";
            FFAPI.variables.product.sliderFullScreen.destroySlider()
        });
        FFAPI.methods.product.closeSizeUnavailableModal = function() {
            n("div.sizeUnavailable button.modal-close-action").trigger("click");
            n("div.sizeUnavailable-modal-button button span.js-text-value").toggleClass("hide");
            n("div.sizeUnavailable-modal-button button span.js-text-value-sent").toggleClass("show")
        };
        FFAPI.methods.product.getBoutiqueInfo();
        FFAPI.methods.product.createProductSizesDropdown();
        FFAPI.methods.product.createProductSizesUnavailableDropdown();
        t = n("body");
        t.on("click", "#btnRemoveFromWishlist", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.extract(n(this))
        });
        t.on("click", "#btnAddToWishlist", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.extract(n(this))
        });
        n(".productDetailModule-contact").on("click", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.parse("27")
        });
        n("#spanSelectedSizeText").on("click", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.parse("126")
        });
        t.on("click", ".sliderProductModule-fullscreen-container a", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.parse("234")
        });
        t.on("click", ".sliderProductModule .bx-prev", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.parse("235")
        });
        t.on("click", ".sliderProductModule .bx-next", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.parse("236")
        });
        t.on("click", ".zoomContainer", function() {
            typeof _fftrkobj != "undefined" && _fftrkobj.parse("24")
        });
        FFAPI.methods.product.FollowBoutique = function(n, t) {
            t == 1 && typeof _fftrkobj != "undefined" && _fftrkobj.track({
                tid: "222",
                val: n
            });
            t == 2 && typeof _fftrkobj != "undefined" && _fftrkobj.track({
                tid: "221",
                val: n
            })
        };
        r = mqValidation();
        FFAPI.variables.product.slider = FFAPI.methods.product.createSlider(r)
    })
} catch (e) {
    try {
        window.debug && console.log(e)
    } catch (ex) {}
}
$(document).ready(function() {
    require(["essentials_plugins"], function() {});
    require(["plu_resTables"], function() {
        var n = !1,
            t = function() {
                if ($(window).width() < 992 && !n) return n = !0, $("table.responsiveTable").each(function(n, t) {
                    splitTable($(t))
                }), !0;
                n && $(window).width() > 992 && (n = !1, $("table.responsiveTable").each(function(n, t) {
                    unsplitTable($(t))
                }))
            };
        FFAPI.variables.auxLoadedSize = !1;
        $("#divSizeGuide").on("sizeGuideLoaded", function() {
            $(window).on("resize", t);
            t();
            FFAPI.variables.auxLoadedSize || ($("table.responsiveTable-lg").each(function(n, t) {
                splitTable($(t))
            }), FFAPI.variables.auxLoadedSize = !0)
        })
    })
});
$(document).ready(function() {
    function t(n, t) {
        $(n).on("click", function() {
            window.open(t, "share", "top=(screen.height / 2) - (350 / 2), left=(screen.width / 2) - (520 / 2), width=520, height=350")
        })
    }
    var n = encodeURIComponent(document.URL);
    t(".displayFacebook", "https://www.facebook.com/sharer/sharer.php?u=" + n);
    t(".displayTwitter", "http://twitter.com/share?url=" + n);
    t(".displayGoogle", "https://plus.google.com/share?url=" + n);
    t(".displayPinterest", "http://pinterest.com/pin/create/button/?url=" + n + "&amp;media=" + encodeURIComponent($('head meta[property="og:image"]').attr("content")) + "&amp;description=" + encodeURIComponent($('head meta[property="og:description"]').attr("content")));
    t(".displayWeibo", "http://service.weibo.com/share/share.php?url=" + n);
    $(".no-touch .sliderTabs-slide").rollover({});
    tooltips();
    require(["essentials_plugins"], function() {})
});
$(".js-input-text-clear").on("click", function() {
    $(this).parent().find("input").val("").focus();
    $(this).parent().find(".js-input-text-clear").addClass("hide")
});
productContactIcon = $(".productDetailModule-contact-listItem-icon");
productContactIframe = $(".helpModal").find("iframe");
productContactIcon.click(function() {
    productContactIframe.attr("src", productContactIframe.attr("data-url"))
});
$(".emailInputNotify .input_black").on("input", function() {
    var n = !1;
    $(this).closest("div").find(".input_black").each(function(t, i) {
        if (i.value) return n = !0, !1
    });
    n ? $(this).parent().find(".js-input-text-clear").removeClass("hide") : $(this).parent().find(".js-input-text-clear").addClass("hide")
});