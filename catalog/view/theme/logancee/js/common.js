$(document).ready(function() {
     SearchForHeader2();
     HomeSidebarVarious();
     
     // Wrap selects
     $("select").wrap("<div class='select'></div>");
     
	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();
		
		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});
		
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && responsive_design == 'yes' && $(window).width() < 768) {
		var i = 0;
		var produkty = [];
		
		$( ".box-product .carousel .item" ).each(function() {
			$( this ).find( ".product-grid .row > div" ).each(function() {
				if(i > 1) {
					produkty.push($(this).html());
				}
				
				i++;
			});
			for ( var s = i-3; s >= 0; s--, s-- ) {
				var html = "<div class='item'><div class='product-grid'><div class='row'>";
				if (produkty[s-1] != undefined) {
					html += "<div class='col-xs-6'>" + produkty[s-1] + "</div>";
				} else {
					html += "<div class='col-xs-6'>" + produkty[s+1] + "</div>";
				}
								
				if (produkty[s] != undefined) {
					html += "<div class='col-xs-6'>" + produkty[s] + "</div>";
				} else {
					html += "<div class='col-xs-6'>" + produkty[s+1] + "</div>";
				}
				html += "</div></div></div>";
				
				$( this ).after( html );
			}
			
			produkty = [];
			i = 0;
		});
	}
	
	/* Search */
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('header input[name=\'search\']').val();
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('header input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('header input[name=\'search\']').val();
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	$('#search2').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('#search2').val();
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	$(window).scroll(function(){
		if ($(this).scrollTop() > 300) {
	    	$('.scrollup').fadeIn();
	    } else {
			$('.scrollup').fadeOut();
		}
	}); 
	
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
	
	$('#chatNow').click(function(){
		javascript:jivo_api.open({start : 'chat'});
		return false;
	});
	
	/* Search MegaMenu */
	$('.button-search2').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('.container-megamenu input[name=\'search2\']').val();
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('.container-megamenu input[name=\'search2\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('.container-megamenu input[name=\'search2\']').val();
			alert(search);
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	/* Quatity buttons */
	
	$('#q_up').click(function(){
		var q_val_up=parseInt($("input#quantity_wanted").val());
		if(isNaN(q_val_up)) {
			q_val_up=0;
		}
		$("input#quantity_wanted").val(q_val_up+1).keyup(); 
		return false; 
	});
	
	$('#q_down').click(function(){
		var q_val_up=parseInt($("input#quantity_wanted").val());
		if(isNaN(q_val_up)) {
			q_val_up=0;
		}
		
		if(q_val_up>1) {
			$("input#quantity_wanted").val(q_val_up-1).keyup();
		} 
		return false; 
	});
    	
	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	
	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});	
	
	FixedTop();
	
	$('.sticky-search > i').bind('click', function() {
	     $(".sticky-header").addClass("sticky-bg"); 
	     $("body").addClass("with-sticky-bg"); 
	     $(".sticky-header .quick-search").addClass("showing"); 
	});
	
	$('.sticky-search .quick-search .icon_close').bind('click', function() {
	     $(".sticky-header").removeClass("sticky-bg");
	     $("body").removeClass("with-sticky-bg");  
	     $(".sticky-header .quick-search").removeClass("showing"); 
	});
    
    $('.megamenu .search > i').bind('click', function() {
         if ($(this).hasClass('icon-magnifier')) {
	        $(".megamenu .search_form").addClass("showing"); 
            $("body").prepend('<div id="overlay" class="overlay"></div>');
            $(".megamenu-wrapper").css('z-index', 'inherit');
            $('#search_query2').focus(); 
         } else {
	        $(".megamenu .search_form").removeClass("showing"); 
         }
	});
	
	$('.megamenu .search .icon_close, .overlay').bind('click', function() {
	     $(".megamenu .search_form").removeClass("showing"); 
         $(".megamenu-wrapper").css('z-index', '25');
         $("#overlay").remove();
	});
    
   $(document).mouseup(function (e){ // событие клика по веб-документу
		var div = $(".form-search"); // тут указываем ID элемента
		if (!div.is(e.target) // если клик был не по нашему блоку
		    && div.has(e.target).length === 0) { // и не по его дочерним элементам
            $(".megamenu .search_form").removeClass("showing"); 
            $(".megamenu-wrapper").css('z-index', '25');
			$("#overlay").remove();
		}
	});
	
	$(window).scroll(function() {
		if ($(window).width() <= '767'){
			if ($(this).scrollTop() > 1){
				$('.header-top').addClass("sticky");
			} else{
				$('.header-top').removeClass("sticky");
			}
		}
	});
    
    $('#content').on('click', '.swatch-link', function(e){
        var el = $(this);
        var product = el.parents('.product');
        if (!el.hasClass('selected')) {
            $.ajax({
                url: 'index.php?route=product/product/getProductOptionValueImages&product_id=' + $(this).data('pid') + '&product_option_value_id=' + $(this).data('povid'),
                type: 'post',
                dataType: 'json',
                success: function(json) {
                    if (json['main_image']) {
                        product.find('.image-swap-effect .main-image').attr("src", json['main_image']);
                    }
                     if (json['additional_image']) {
                        product.find('.swap-image').remove();
                        product.find('.image-swap-effect .product-thumb').prepend("<img class='swap-image' src='" + json['additional_image'] + "' />");
                    }
                    product.find('.swatch-link').removeClass('selected');
                    el.addClass('selected');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
	       });
        }
    });
            
});

function getURLVar(key) {
    var value = [];
    
    var query = String(document.location).split('?');
    
    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');
            
            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }
        
        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
} 
	
// Cart add remove functions	
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {			
				if (json['redirect']) {
					location = json['redirect'];
				}
				
				if (json['success']) {
				    /* 
                    $.notify({
				     	message: json['success'],
				     	target: '_blank'
				     },{
				     	// settings
				     	element: 'body',
				     	position: null,
				     	type: "info",
				     	allow_dismiss: true,
				     	newest_on_top: false,
				     	placement: {
				     		from: "top",
				     		align: "right"
				     	},
				     	offset: 20,
				     	spacing: 10,
				     	z_index: 2031,
				     	delay: 5000,
				     	timer: 1000,
				     	url_target: '_blank',
				     	mouse_over: null,
				     	animate: {
				     		enter: 'animated fadeInDown',
				     		exit: 'animated fadeOutUp'
				     	},
				     	onShow: null,
				     	onShown: null,
				     	onClose: null,
				     	onClosed: null,
				     	icon_type: 'class',
				     	template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
				     		'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
				     		'<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
				     		'<div class="progress" data-notify="progressbar">' +
				     			'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
				     		'</div>' +
				     		'<a href="{3}" target="{4}" data-notify="url"></a>' +
				     	'</div>' 
				     });
				    */			
                    $("#notification-popupmaster .modal-footer").show();
				    $("#notification-popupmaster").modal('show');
				    $("#notification-popupmaster .modal-body p").html(json['success']);	
                    
					$('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
					$('#cart_block #total_price_ajax').load('index.php?route=common/cart/info #total_price');
					$('#cart_block #total_item_ajax').load('index.php?route=common/cart/info #total_item');
				}
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
					$('#cart_block #total_price_ajax').load('index.php?route=common/cart/info #total_price');
					$('#cart_block #total_item_ajax').load('index.php?route=common/cart/info #total_item');
				}			
			}
		});			
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',			
			success: function(json) {
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout' || document.location.pathname == "/cart/") {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
					$('#cart_block #total_price_ajax').load('index.php?route=common/cart/info #total_price');
					$('#cart_block #total_item_ajax').load('index.php?route=common/cart/info #total_item');
				}
			}
		});			
	}
}

var voucher = {
	'add': function() {
		
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},      
			complete: function() {
				$('#cart > button').button('reset');
			},			
			success: function(json) {
				$('#cart-total').html(json['total']);
				
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
					$('#cart_block #total_price_ajax').load('index.php?route=common/cart/info #total_price');
					$('#cart_block #total_item_ajax').load('index.php?route=common/cart/info #total_item');
				}			
			}
		});	
	}
}

var wishlist = {
	'add': function(product_id) {
		yaCounter48659294.reachGoal('wishlist');
		var action = 'add';
		if ($('.add-to-wishlist').hasClass('active')) {
			action = 'remove';
		}
		$.ajax({
			url: 'index.php?route=account/wishlist/' + action,
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {							
				if (json['success']) {
					$('.add-to-wishlist').toggleClass('active');
				}   
				
				$('.wishlist .qty-cart').html(json['total']);
			}
		});
	},
	'remove': function() {
		
	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {							
				if (json['success']) {
					$.notify({
						message: json['success'],
						target: '_blank'
					},{
						// settings
						element: 'body',
						position: null,
						type: "info",
						allow_dismiss: true,
						newest_on_top: false,
						placement: {
							from: "top",
							align: "right"
						},
						offset: 20,
						spacing: 10,
						z_index: 2031,
						delay: 5000,
						timer: 1000,
						url_target: '_blank',
						mouse_over: null,
						animate: {
							enter: 'animated fadeInDown',
							exit: 'animated fadeOutUp'
						},
						onShow: null,
						onShown: null,
						onClose: null,
						onClosed: null,
						icon_type: 'class',
						template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
							'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
							'<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
							'<div class="progress" data-notify="progressbar">' +
								'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
							'</div>' +
							'<a href="{3}" target="{4}" data-notify="url"></a>' +
						'</div>' 
					});
					
					$('#compare-total').html(json['total']);
				}   
			}
		});
	},
	'remove': function() {
	
	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();
	
	$('#modal-agree').remove(); 
	
	var element = this;
	
    $.ajax({
        url: $(element).attr('href'),
        type: 'get',
        dataType: 'html',
        success: function(data) {
			html  = '<div id="modal-agree" class="modal fade">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">'; 
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div';
			html += '  </div>';
			html += '</div>';
			
			$('body').append(html);
			
			$('#modal-agree').modal('show');
        }
    });
});

/* Autocomplete */
(function($) {
	function Autocomplete(element, options) {
		this.element = element;
		this.options = options;
		this.timer = null;
		this.items = new Array();

		$(element).attr('autocomplete', 'off');
		$(element).on('focus', $.proxy(this.focus, this));
		$(element).on('blur', $.proxy(this.blur, this));
		$(element).on('keydown', $.proxy(this.keydown, this));

		$(element).after('<ul class="dropdown-menu"></ul>');
		$(element).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));
	}

	Autocomplete.prototype = {
		focus: function() {
			this.request();
		},
		blur: function() {
			setTimeout(function(object) {
				object.hide();
			}, 200, this);
		},
		click: function(event) {
			event.preventDefault();

			value = $(event.target).parent().attr('data-value');

			if (value && this.items[value]) {
				this.options.select(this.items[value]);
			}
		},
		keydown: function(event) {
			switch(event.keyCode) {
				case 27: // escape
					this.hide();
					break;
				default:
					this.request();
					break;
			}
		},
		show: function() {
			var pos = $(this.element).position();

			$(this.element).siblings('ul.dropdown-menu').css({
				top: pos.top + $(this.element).outerHeight(),
				left: pos.left
			});

			$(this.element).siblings('ul.dropdown-menu').show();
			$(this).siblings('ul.dropdown-menu').css("opacity", "1");
			$(this).siblings('ul.dropdown-menu').css("visibility", "visible");
		},
		hide: function() {
			$(this.element).siblings('ul.dropdown-menu').hide();
		},
		request: function() {
			clearTimeout(this.timer);

			this.timer = setTimeout(function(object) {
				object.options.source($(object.element).val(), $.proxy(object.response, object));
			}, 200, this);
		},
		response: function(json) {
			html = '';

			if (json.length) {
				for (i = 0; i < json.length; i++) {
					this.items[json[i]['value']] = json[i];
				}

				for (i = 0; i < json.length; i++) {
					if (!json[i]['category']) {
						html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
					}
				}

				// Get all the ones with a categories
				var category = new Array();

				for (i = 0; i < json.length; i++) {
					if (json[i]['category']) {
						if (!category[json[i]['category']]) {
							category[json[i]['category']] = new Array();
							category[json[i]['category']]['name'] = json[i]['category'];
							category[json[i]['category']]['item'] = new Array();
						}

						category[json[i]['category']]['item'].push(json[i]);
					}
				}

				for (i in category) {
					html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

					for (j = 0; j < category[i]['item'].length; j++) {
						html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
					}
				}
			}

			if (html) {
				this.show();
			} else {
				this.hide();
			}

			$(this.element).siblings('ul.dropdown-menu').html(html);
		}
	};

	$.fn.autocomplete = function(option) {
		return this.each(function() {
			var data = $(this).data('autocomplete');

			if (!data) {
				data = new Autocomplete(this, option);

				$(this).data('autocomplete', data);
			}
		});
	}
})(window.jQuery);

function openPopup(module_id, product_id) {
     product_id = product_id || undefined;
     $.magnificPopup.open({
          items: {
               src: 'index.php?route=extension/module/popup/show&module_id=' + module_id + (product_id ? '&product_id=' + product_id : '')
          },
          mainClass: 'popup-module mfp-with-zoom',
          type: 'ajax',
          removalDelay: 200
     });
}

$(window).resize(function() {
     FixedTop();
});

$(window).scroll(function() {
     FixedTop();
});

function FixedTop() {
     if($(window).width() >= 1160 && $(window).scrollTop() > 280) {
          $('.sticky-header').addClass('fixed-header');
     } else { 
          $('.sticky-header').removeClass('fixed-header');
     }
}

function SearchForHeader2() {
     if($(window).width() < 992) {
          $('.header-layout-2 .sticky-search > i').bind('click', function() {
          	url = $('base').attr('href') + 'index.php?route=product/search';
          	
          	location = url;
          });
     }
}

$(window).resize(function() {
     SearchForHeader2();
});

function HomeSidebarVarious() {
     var height_two = $("header .slider-header").height()+100;
     if($(window).height() > height_two) {
          $("body").addClass("with-fixed");
     } else {
          $("body").removeClass("with-fixed");
     }
}

$(window).resize(function() {
     HomeSidebarVarious();
});
