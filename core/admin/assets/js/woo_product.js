jQuery(document).ready(function($){
	
	let lightbox = function(ops) {

		if (ops == 'close') {
			$('body').css({overflow: ''});
			return $('#customdesign-lightbox').remove();
		}
		
		var tmpl = '<div id="customdesign-lightbox" class="customdesign-lightbox" style="display:block">\
						<div id="customdesign-lightbox-body">\
							<div id="customdesign-lightbox-content" class="%class%" style="min-width:%width%px">\
								%content%\
							</div>\
							%footer%\
							<a class="kalb-close" href="#close" title="Close">\
								<i class="dashicons dashicons-no-alt"></i>\
							</a>\
						</div>\
						<div class="kalb-overlay"></div>\
					</div>',
			cfg = $.extend({
				width: 1000,
				class: '',
				footer: '',
				content: '',
				onload: function(){},
				onclose: function(){}
			}, ops);

		if (cfg.footer !== '')
			cfg.footer = '<div id="customdesign-lightbox-footer">'+cfg.footer+'</div>';

		tmpl = $(tmpl.replace(/\%width\%/g, cfg.width).
					replace(/\%class\%/g, cfg.class).
					replace(/\%content\%/g, cfg.content).
					replace(/\%footer\%/g, cfg.footer));

		$('.customdesign-lightbox').remove();
		$('body').append(tmpl).css({overflow: 'hidden'});

		cfg.onload(tmpl);
		tmpl.find('a.kalb-close,div.kalb-overlay').on('click', function(e){
			cfg.onclose(tmpl);
			$('.customdesign-lightbox').remove();
			$('body').css({overflow: ''});
			e.preventDefault();
		});

	};

	
	/*
	* Show Customdesign configuration in variations
	*/
	
	$(document).on('click', (e) => {
		if (
			e.target.getAttribute('data-customdesign-frame') || 
			e.target.parentNode.getAttribute('data-customdesign-frame')
		) {
			
			let el = e.target.parentNode.getAttribute('data-customdesign-frame') ? e.target.parentNode : e.target,
				fn = el.getAttribute('data-customdesign-frame'),
				src = fn+'&nonce=CUSTOMDESIGN-SECURITY-BACKEND:'+customdesignjs.nonce_backend,
				id = el.parentNode.getAttribute('data-id'),
				inp = window['variable-customdesign-'+id],
				val = inp.value;
			
			
			if (fn == 'paste') {
				
				e.preventDefault();
				
				if (!localStorage.getItem('CUSTOMDESIGN-VARIATION-COPY'))
					return alert('Error, You must copy one config before pasting');
					
				$(inp).val(localStorage.getItem('CUSTOMDESIGN-VARIATION-COPY')).change();
				$('button#customdesign-config-'+id).click().parent().attr('data-empty', 'false');
				
				return;	
				
			} else if (fn == 'clear') {
				
				e.preventDefault();
				
				if (confirm('Are you sure that you want to clear this config?')) {
					$(inp).val('').change();
					$(el).parent().attr('data-empty', 'true');
				};
				
				return;	
				
			} else if (fn == 'list') {
				
				e.preventDefault();
				
				load_product_bases(
					{
						'product_source': 'woo-variation'
					}, 
					{
						'can_create_new': false,
						'action_text': 'Select this config',
						'action_fn': (product) => {
							$(inp).val(product.customdesign_data).change();
							$('button#customdesign-config-'+id).click().parent().attr('data-empty', 'false');
						}
					}
				);
				
				return;	
				
			};
			
			$(el).before(
				'<iframe id="customdesign-variation-'+id+'" name="customdesign-variation-'+id+'" style="width: 100%;min-height:150px;border: none;" src="'+
					(val === '' ? src : '')+
				'"></iframe>'
			).closest('div.variable_customdesign_data').attr('data-loading', 'Loading..').addClass('hasFrame');;
			
			if (val !== '') {
				
				let form = $('<form action="'+src+'" method="post" target="customdesign-variation-'+id+'"><textarea name="data">'+val.replace(/\<textarea/g, '&lt;textarea').replace(/\<\/textarea\>/g, '&lt;/textarea&gt;')+'</textarea></form>');	
				
				$('body').append(form);
				
			    form.submit().remove();	
				
			}
			
			e.preventDefault();
		}
	});
	
});