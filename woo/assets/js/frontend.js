jQuery(document).ready(function($){
	window.magicwoo = {
		
		init: function (){
			magicwoo.lightbox.elm = jQuery([
				'<div class="magic-lightbox" style="display:none;"><div class="magic-lightbox-body">',
				'<a href="#" class="magic-lightbox-close" title=""><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 52 52" style="enable-background:new 0 0 52 52;" xml:space="preserve" width="100%" height="100%"><g>',
				'<path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M26,50C12.767,50,2,39.233,2,26 S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z" fill="#000000"/>',
				'<path d="M35.707,16.293c-0.391-0.391-1.023-0.391-1.414,0L26,24.586l-8.293-8.293c-0.391-0.391-1.023-0.391-1.414,0 s-0.391,1.023,0,1.414L24.586,26l-8.293,8.293c-0.391,0.391-0.391,1.023,0,1.414C16.488,35.902,16.744,36,17,36 s0.512-0.098,0.707-0.293L26,27.414l8.293,8.293C34.488,35.902,34.744,36,35,36s0.512-0.098,0.707-0.293 c0.391-0.391,0.391-1.023,0-1.414L27.414,26l8.293-8.293C36.098,17.316,36.098,16.684,35.707,16.293z" fill="#000000"/>',
				'</g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a><div class="magic-lightbox-content"></div></div>',
				'<div class="magic-lightbox-overlay"></div></div>'
			].join('')).appendTo('body');
			magicwoo.lightbox.elm.find('.magic-lightbox-close, .magic-lightbox-overlay').on('click', function (e){e.preventDefault();magicwoo.lightbox.close()});
			
			$(document).on('click', '.woocommerce-cart-form .product-remove > a', function(e) {
	            var cart_id = $(this).closest('.cart_item').find('a.magic-edit-design').attr('id'),
	            	cart_data = JSON.parse(localStorage.getItem('MAGIC-CART-DATA'));
                  
	            delete cart_data[cart_id];
	            
	            localStorage.setItem('MAGIC-CART-DATA', JSON.stringify(cart_data));
	            
            });
            
            $('.magic-cart-thumbnails img').on('click', function(e) {
	            magicwoo.lightbox.open('<img src="'+this.getAttribute('src')+'" style="background:'+this.style.background+'" />');
	            e.preventDefault('');
            });
            
		},
		
		lightbox: {
			
			elm : null,
			
			open : function (content){
				magicwoo.lightbox.elm.find('.magic-lightbox-content').html(content);
				this.elm.show();
			},
			close : function (){
				this.elm.hide();
			}
		}
	}
	
	magicwoo.init();

	var getParams = function (url) {
		var params = {};
		var parser = document.createElement('a');
		parser.href = url;
		var query = parser.search.substring(1);
		var vars = query.split('&');
		for (var i = 0; i < vars.length; i++) {
			var pair = vars[i].split('=');
			params[pair[0]] = decodeURIComponent(pair[1]);
		}
		return params;
	};

	$(document).on('change', 'input[type="number"].input-text.qty.text', function(){
		var customize_url = $('#magic-customize-button').attr('href');
		var param = getParams(customize_url);

		if(param.quantity){
			var newUrl = customize_url.replace('quantity='+param.quantity, 'quantity='+$(this).val());
		} else {
			var newUrl = customize_url+'&quantity='+$(this).val();
		}

		$('#magic-customize-button').attr('href', newUrl);

	});
});
