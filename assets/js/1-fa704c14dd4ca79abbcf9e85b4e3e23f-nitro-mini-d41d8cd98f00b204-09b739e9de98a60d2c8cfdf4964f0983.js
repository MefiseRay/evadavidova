(function(a){if(typeof define==="function"&&define.amd&&define.amd.jQuery){define(["jquery"],a)}else{if(typeof module!=="undefined"&&module.exports){a(require("jquery"))}else{a(jQuery)}}}(function(f){var y="1.6.18",p="left",o="right",e="up",x="down",c="in",A="out",m="none",s="auto",l="swipe",t="pinch",B="tap",j="doubletap",b="longtap",z="hold",E="horizontal",u="vertical",i="all",r=10,g="start",k="move",h="end",q="cancel",a="ontouchstart"in window,v=window.navigator.msPointerEnabled&&!window.navigator.pointerEnabled&&!a,d=(window.navigator.pointerEnabled||window.navigator.msPointerEnabled)&&!a,C="TouchSwipe";var n={fingers:1,threshold:75,cancelThreshold:null,pinchThreshold:20,maxTimeThreshold:null,fingerReleaseThreshold:250,longTapThreshold:500,doubleTapThreshold:200,swipe:null,swipeLeft:null,swipeRight:null,swipeUp:null,swipeDown:null,swipeStatus:null,pinchIn:null,pinchOut:null,pinchStatus:null,click:null,tap:null,doubleTap:null,longTap:null,hold:null,triggerOnTouchEnd:true,triggerOnTouchLeave:false,allowPageScroll:"auto",fallbackToMouseEvents:true,excludedElements:".noSwipe",preventDefaultEvents:true};f.fn.mf_swipe=function(H){var G=f(this),F=G.data(C);if(F&&typeof H==="string"){if(F[H]){return F[H].apply(F,Array.prototype.slice.call(arguments,1))}else{f.error("Method "+H+" does not exist on jQuery.swipe")}}else{if(F&&typeof H==="object"){F.option.apply(F,arguments)}else{if(!F&&(typeof H==="object"||!H)){return w.apply(this,arguments)}}}return G};f.fn.mf_swipe.version=y;f.fn.mf_swipe.defaults=n;f.fn.mf_swipe.phases={PHASE_START:g,PHASE_MOVE:k,PHASE_END:h,PHASE_CANCEL:q};f.fn.mf_swipe.directions={LEFT:p,RIGHT:o,UP:e,DOWN:x,IN:c,OUT:A};f.fn.mf_swipe.pageScroll={NONE:m,HORIZONTAL:E,VERTICAL:u,AUTO:s};f.fn.mf_swipe.fingers={ONE:1,TWO:2,THREE:3,FOUR:4,FIVE:5,ALL:i};function w(F){if(F&&(F.allowPageScroll===undefined&&(F.swipe!==undefined||F.swipeStatus!==undefined))){F.allowPageScroll=m}if(F.click!==undefined&&F.tap===undefined){F.tap=F.click}if(!F){F={}}F=f.extend({},f.fn.mf_swipe.defaults,F);return this.each(function(){var H=f(this);var G=H.data(C);if(!G){G=new D(this,F);H.data(C,G)}})}function D(a6,au){var au=f.extend({},au);var az=(a||d||!au.fallbackToMouseEvents),K=az?(d?(v?"MSPointerDown":"pointerdown"):"touchstart"):"mousedown",ax=az?(d?(v?"MSPointerMove":"pointermove"):"touchmove"):"mousemove",V=az?(d?(v?"MSPointerUp":"pointerup"):"touchend"):"mouseup",T=az?(d?"mouseleave":null):"mouseleave",aD=(d?(v?"MSPointerCancel":"pointercancel"):"touchcancel");var ag=0,aP=null,a3=null,ac=0,a2=0,a0=0,H=1,ap=0,aJ=0,N=null;var aR=f(a6);var aa="start";var X=0;var aQ={};var U=0,a4=0,a7=0,ay=0,O=0;var aX=null,af=null;try{aR.bind(K,aN);aR.bind(aD,bb)}catch(aj){f.error("events not supported "+K+","+aD+" on jQuery.swipe")}this.enable=function(){this.disable();aR.bind(K,aN);aR.bind(aD,bb);return aR};this.disable=function(){aK();return aR};this.destroy=function(){aK();aR.data(C,null);aR=null};this.option=function(be,bd){if(typeof be==="object"){au=f.extend(au,be)}else{if(au[be]!==undefined){if(bd===undefined){return au[be]}else{au[be]=bd}}else{if(!be){return au}else{f.error("Option "+be+" does not exist on jQuery.swipe.options")}}}return null};function aN(bf){if(aB()){return}if(f(bf.target).closest(au.excludedElements,aR).length>0){return}var bg=bf.originalEvent?bf.originalEvent:bf;if(bg.pointerType&&bg.pointerType=="mouse"&&au.fallbackToMouseEvents==false){return}var be,bh=bg.touches,bd=bh?bh[0]:bg;aa=g;if(bh){X=bh.length}else{if(au.preventDefaultEvents!==false){bf.preventDefault()}}ag=0;aP=null;a3=null;aJ=null;ac=0;a2=0;a0=0;H=1;ap=0;N=ab();S();ai(0,bd);if(!bh||(X===au.fingers||au.fingers===i)||aY()){U=ar();if(X==2){ai(1,bh[1]);a2=a0=at(aQ[0].start,aQ[1].start)}if(au.swipeStatus||au.pinchStatus){be=P(bg,aa)}}else{be=false}if(be===false){aa=q;P(bg,aa);return be}else{if(au.hold){af=setTimeout(f.proxy(function(){aR.trigger("hold",[bg.target]);if(au.hold){be=au.hold.call(aR,bg,bg.target)}},this),au.longTapThreshold)}an(true)}return null}function a5(bg){var bj=bg.originalEvent?bg.originalEvent:bg;if(aa===h||aa===q||al()){return}var bf,bk=bj.touches,be=bk?bk[0]:bj;var bh=aH(be);a4=ar();if(bk){X=bk.length}if(au.hold){clearTimeout(af)}aa=k;if(X==2){if(a2==0){ai(1,bk[1]);a2=a0=at(aQ[0].start,aQ[1].start)}else{aH(bk[1]);a0=at(aQ[0].end,aQ[1].end);aJ=aq(aQ[0].end,aQ[1].end)}H=a9(a2,a0);ap=Math.abs(a2-a0)}if((X===au.fingers||au.fingers===i)||!bk||aY()){aP=aL(bh.start,bh.end);a3=aL(bh.last,bh.end);ak(bg,a3);ag=aS(bh.start,bh.end);ac=aM();aI(aP,ag);bf=P(bj,aa);if(!au.triggerOnTouchEnd||au.triggerOnTouchLeave){var bd=true;if(au.triggerOnTouchLeave){var bi=aZ(this);bd=F(bh.end,bi)}if(!au.triggerOnTouchEnd&&bd){aa=aC(k)}else{if(au.triggerOnTouchLeave&&!bd){aa=aC(h)}}if(aa==q||aa==h){P(bj,aa)}}}else{aa=q;P(bj,aa)}if(bf===false){aa=q;P(bj,aa)}}function M(bd){var be=bd.originalEvent?bd.originalEvent:bd,bf=be.touches;if(bf){if(bf.length&&!al()){G(be);return true}else{if(bf.length&&al()){return true}}}if(al()){X=ay}a4=ar();ac=aM();if(bc()||!am()){aa=q;P(be,aa)}else{if(au.triggerOnTouchEnd||(au.triggerOnTouchEnd===false&&aa===k)){if(au.preventDefaultEvents!==false&&bd.cancelable!==false){bd.preventDefault()}aa=h;P(be,aa)}else{if(!au.triggerOnTouchEnd&&a8()){aa=h;aF(be,aa,B)}else{if(aa===k){aa=q;P(be,aa)}}}}an(false);return null}function bb(){X=0;a4=0;U=0;a2=0;a0=0;H=1;S();an(false)}function L(bd){var be=bd.originalEvent?bd.originalEvent:bd;if(au.triggerOnTouchLeave){aa=aC(h);P(be,aa)}}function aK(){aR.unbind(K,aN);aR.unbind(aD,bb);aR.unbind(ax,a5);aR.unbind(V,M);if(T){aR.unbind(T,L)}an(false)}function aC(bh){var bg=bh;var bf=aA();var be=am();var bd=bc();if(!bf||bd){bg=q}else{if(be&&bh==k&&(!au.triggerOnTouchEnd||au.triggerOnTouchLeave)){bg=h}else{if(!be&&bh==h&&au.triggerOnTouchLeave){bg=q}}}return bg}function P(bf,bd){var be,bg=bf.touches;if(J()||W()){be=aF(bf,bd,l)}if((Q()||aY())&&be!==false){be=aF(bf,bd,t)}if(aG()&&be!==false){be=aF(bf,bd,j)}else{if(ao()&&be!==false){be=aF(bf,bd,b)}else{if(ah()&&be!==false){be=aF(bf,bd,B)}}}if(bd===q){bb(bf)}if(bd===h){if(bg){if(!bg.length){bb(bf)}}else{bb(bf)}}return be}function aF(bg,bd,bf){var be;if(bf==l){aR.trigger("swipeStatus",[bd,aP||null,ag||0,ac||0,X,aQ,a3]);if(au.swipeStatus){be=au.swipeStatus.call(aR,bg,bd,aP||null,ag||0,ac||0,X,aQ,a3);if(be===false){return false}}if(bd==h&&aW()){clearTimeout(aX);clearTimeout(af);aR.trigger("swipe",[aP,ag,ac,X,aQ,a3]);if(au.swipe){be=au.swipe.call(aR,bg,aP,ag,ac,X,aQ,a3);if(be===false){return false}}switch(aP){case p:aR.trigger("swipeLeft",[aP,ag,ac,X,aQ,a3]);if(au.swipeLeft){be=au.swipeLeft.call(aR,bg,aP,ag,ac,X,aQ,a3)}break;case o:aR.trigger("swipeRight",[aP,ag,ac,X,aQ,a3]);if(au.swipeRight){be=au.swipeRight.call(aR,bg,aP,ag,ac,X,aQ,a3)}break;case e:aR.trigger("swipeUp",[aP,ag,ac,X,aQ,a3]);if(au.swipeUp){be=au.swipeUp.call(aR,bg,aP,ag,ac,X,aQ,a3)}break;case x:aR.trigger("swipeDown",[aP,ag,ac,X,aQ,a3]);if(au.swipeDown){be=au.swipeDown.call(aR,bg,aP,ag,ac,X,aQ,a3)}break}}}if(bf==t){aR.trigger("pinchStatus",[bd,aJ||null,ap||0,ac||0,X,H,aQ]);if(au.pinchStatus){be=au.pinchStatus.call(aR,bg,bd,aJ||null,ap||0,ac||0,X,H,aQ);if(be===false){return false}}if(bd==h&&ba()){switch(aJ){case c:aR.trigger("pinchIn",[aJ||null,ap||0,ac||0,X,H,aQ]);if(au.pinchIn){be=au.pinchIn.call(aR,bg,aJ||null,ap||0,ac||0,X,H,aQ)}break;case A:aR.trigger("pinchOut",[aJ||null,ap||0,ac||0,X,H,aQ]);if(au.pinchOut){be=au.pinchOut.call(aR,bg,aJ||null,ap||0,ac||0,X,H,aQ)}break}}}if(bf==B){if(bd===q||bd===h){clearTimeout(aX);clearTimeout(af);if(Z()&&!I()){O=ar();aX=setTimeout(f.proxy(function(){O=null;aR.trigger("tap",[bg.target]);if(au.tap){be=au.tap.call(aR,bg,bg.target)}},this),au.doubleTapThreshold)}else{O=null;aR.trigger("tap",[bg.target]);if(au.tap){be=au.tap.call(aR,bg,bg.target)}}}}else{if(bf==j){if(bd===q||bd===h){clearTimeout(aX);clearTimeout(af);O=null;aR.trigger("doubletap",[bg.target]);if(au.doubleTap){be=au.doubleTap.call(aR,bg,bg.target)}}}else{if(bf==b){if(bd===q||bd===h){clearTimeout(aX);O=null;aR.trigger("longtap",[bg.target]);if(au.longTap){be=au.longTap.call(aR,bg,bg.target)}}}}}return be}function am(){var bd=true;if(au.threshold!==null){bd=ag>=au.threshold}return bd}function bc(){var bd=false;if(au.cancelThreshold!==null&&aP!==null){bd=(aT(aP)-ag)>=au.cancelThreshold}return bd}function ae(){if(au.pinchThreshold!==null){return ap>=au.pinchThreshold}return true}function aA(){var bd;if(au.maxTimeThreshold){if(ac>=au.maxTimeThreshold){bd=false}else{bd=true}}else{bd=true}return bd}function ak(bd,be){if(au.preventDefaultEvents===false){return}if(au.allowPageScroll===m){bd.preventDefault()}else{var bf=au.allowPageScroll===s;switch(be){case p:if((au.swipeLeft&&bf)||(!bf&&au.allowPageScroll!=E)){bd.preventDefault()}break;case o:if((au.swipeRight&&bf)||(!bf&&au.allowPageScroll!=E)){bd.preventDefault()}break;case e:if((au.swipeUp&&bf)||(!bf&&au.allowPageScroll!=u)){bd.preventDefault()}break;case x:if((au.swipeDown&&bf)||(!bf&&au.allowPageScroll!=u)){bd.preventDefault()}break;case m:break}}}function ba(){var be=aO();var bd=Y();var bf=ae();return be&&bd&&bf}function aY(){return!!(au.pinchStatus||au.pinchIn||au.pinchOut)}function Q(){return!!(ba()&&aY())}function aW(){var bg=aA();var bi=am();var bf=aO();var bd=Y();var be=bc();var bh=!be&&bd&&bf&&bi&&bg;return bh}function W(){return!!(au.swipe||au.swipeStatus||au.swipeLeft||au.swipeRight||au.swipeUp||au.swipeDown)}function J(){return!!(aW()&&W())}function aO(){return((X===au.fingers||au.fingers===i)||!a)}function Y(){return aQ[0].end.x!==0}function a8(){return!!(au.tap)}function Z(){return!!(au.doubleTap)}function aV(){return!!(au.longTap)}function R(){if(O==null){return false}var bd=ar();return(Z()&&((bd-O)<=au.doubleTapThreshold))}function I(){return R()}function aw(){return((X===1||!a)&&(isNaN(ag)||ag<au.threshold))}function a1(){return((ac>au.longTapThreshold)&&(ag<r))}function ah(){return!!(aw()&&a8())}function aG(){return!!(R()&&Z())}function ao(){return!!(a1()&&aV())}function G(bd){a7=ar();ay=bd.touches.length+1}function S(){a7=0;ay=0}function al(){var bd=false;if(a7){var be=ar()-a7;if(be<=au.fingerReleaseThreshold){bd=true}}return bd}function aB(){return!!(aR.data(C+"_intouch")===true)}function an(bd){if(!aR){return}if(bd===true){aR.bind(ax,a5);aR.bind(V,M);if(T){aR.bind(T,L)}}else{aR.unbind(ax,a5,false);aR.unbind(V,M,false);if(T){aR.unbind(T,L,false)}}aR.data(C+"_intouch",bd===true)}function ai(bf,bd){var be={start:{x:0,y:0},last:{x:0,y:0},end:{x:0,y:0}};be.start.x=be.last.x=be.end.x=bd.pageX||bd.clientX;be.start.y=be.last.y=be.end.y=bd.pageY||bd.clientY;aQ[bf]=be;return be}function aH(bd){var bf=bd.identifier!==undefined?bd.identifier:0;var be=ad(bf);if(be===null){be=ai(bf,bd)}be.last.x=be.end.x;be.last.y=be.end.y;be.end.x=bd.pageX||bd.clientX;be.end.y=bd.pageY||bd.clientY;return be}function ad(bd){return aQ[bd]||null}function aI(bd,be){if(bd==m){return}be=Math.max(be,aT(bd));N[bd].distance=be}function aT(bd){if(N[bd]){return N[bd].distance}return undefined}function ab(){var bd={};bd[p]=av(p);bd[o]=av(o);bd[e]=av(e);bd[x]=av(x);return bd}function av(bd){return{direction:bd,distance:0}}function aM(){return a4-U}function at(bg,bf){var be=Math.abs(bg.x-bf.x);var bd=Math.abs(bg.y-bf.y);return Math.round(Math.sqrt(be*be+bd*bd))}function a9(bd,be){var bf=(be/bd)*1;return bf.toFixed(2)}function aq(){if(H<1){return A}else{return c}}function aS(be,bd){return Math.round(Math.sqrt(Math.pow(bd.x-be.x,2)+Math.pow(bd.y-be.y,2)))}function aE(bg,be){var bd=bg.x-be.x;var bi=be.y-bg.y;var bf=Math.atan2(bi,bd);var bh=Math.round(bf*180/Math.PI);if(bh<0){bh=360-Math.abs(bh)}return bh}function aL(be,bd){if(aU(be,bd)){return m}var bf=aE(be,bd);if((bf<=45)&&(bf>=0)){return p}else{if((bf<=360)&&(bf>=315)){return p}else{if((bf>=135)&&(bf<=225)){return o}else{if((bf>45)&&(bf<135)){return x}else{return e}}}}}function ar(){var bd=new Date();return bd.getTime()}function aZ(bd){bd=f(bd);var bf=bd.offset();var be={left:bf.left,right:bf.left+bd.outerWidth(),top:bf.top,bottom:bf.top+bd.outerHeight()};return be}function F(bd,be){return(bd.x>be.left&&bd.x<be.right&&bd.y>be.top&&bd.y<be.bottom)}function aU(bd,be){return(bd.x==be.x&&bd.y==be.y)}}}));