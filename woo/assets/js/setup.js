(function($) {
	
	var step = 1,
		nav = $('.magic-setup-steps>li'),
		body = $('#setup-body .store-container.magic_content'),
		do_step = function() {
			if (step == 1) {
				
				var data = encodeURIComponent(JSON.stringify({
					logo: encodeURIComponent($('#magic-logo-input').val()),
					color: $('input[name="primary_color"]').val(),
					currency: $('input[name="currency"]').val(),
					editor_page: $('select[name="editor_page"]').val(),
					terms: $('textarea[name="terms"]').val()
				}));
				
				var submit_url = MagicDesign.ajax+'&action=setup&step=1&nonce=MAGIC_ADMIN:'+MagicDesign.nonce,
					boundary = "---------------------------7da24f2e50046",
					body = '--' + boundary + '\r\n'
				         + 'Content-Disposition: form-data; name="file";'
				         + 'filename="file.txt"\r\n'
				         + 'Content-type: plain/text\r\n\r\n'
				         + data
				         + '\r\n'
				         + '--'+ boundary + '--';
						 
				$.ajax({
				    contentType: "multipart/form-data; boundary="+boundary,
				    data: body,
				    type: "POST",
				    url: submit_url,
				    xhr: function() {
					    var xhr = new window.XMLHttpRequest();
					    xhr.upload.addEventListener("progress", function(evt){
					      if (evt.lengthComputable) {
					        var percentComplete = evt.loaded / evt.total;
					      }
					    }, false);
					    return xhr;
					},
				    success: function (res, status) {
					    
					    if (res != '1') {
						    $('#setup-body').removeClass('loading');
							$('.magic-setup-footer-links').css({opacity: 1}).removeClass('disabled');
						    return alert(res);
					    }
					    
					    next_step();
					    
					}
				});
				
			} else if (step == 2) {
				
				var url = [
					'&action=setup',
					'step=2',
					'theme='+(!$('[data-toggle="magic-theme"]').hasClass('disabled') ? 1 : 0),
					'kc='+(!$('[data-toggle="kingcomposer"]').hasClass('disabled') ? 1 : 0),
					'nonce=MAGIC_ADMIN:'+MagicDesign.nonce
				];
				
				$.get(MagicDesign.ajax+url.join('&'), function(res) {		
					if (res != '1') {
						
						res = JSON.parse(res);
						$('.store-container[data-step="2"] ul.magic-wizard-services').first().before(
							'<p class="store-setup error">'+res.join('</p><p class="store-setup error">')+'</p>'
						);
						
						$('#setup-body').removeClass('loading');
						$('button.button-next').html($('button.button-next').attr('data-txt'));
						$('.magic-setup-footer-links').css({opacity: 1}).removeClass('disabled');
			
					} else next_step();
				});
			}	
			
		},
		next_step = function() {
					
			body.hide().eq(step).show();
			
			step++;	
			
			if (step <= nav.length) {
				nav.each(function() {
					var t = parseInt(this.getAttribute('data-step'));
					if (t < step) {
						this.innerHTML = '<a href="#">'+this.getAttribute('data-txt')+'</a>';
						$(this).removeClass('active').addClass('done').find('a').on('click', function(e) {
							e.preventDefault();
							step = parseInt(this.parentNode.getAttribute('data-step'))-1;
							next_step();
						});
					} else if (t == step) {
						$(this).removeClass('done').addClass('active').html(this.getAttribute('data-txt'));
					} else if (t > step) {
						$(this).removeClass('done active').html(this.getAttribute('data-txt'));
					}
				});
				$('.magic-setup-actions.step').show();
			}
			
			if (step == nav.length) {
				$('#dismiss-step').css({opacity: 0}).addClass('disabled');
				$('.magic-setup-actions.step').hide();
			}
			
			if (step == nav.length-1) {
				$('.magic-setup-actions.step').hide();
			}
			
			$('#setup-body').removeClass('loading');
			$('button.button-next').html($('button.button-next').attr('data-txt'));
			$('.magic-setup-footer-links').css({opacity: 1}).removeClass('disabled');
			
			if (step == 1) {
				$('.magic-setup-footer-links').show().html($('.magic-setup-footer-links').attr('data-txt'));
			} else if (step < nav.length) {
				$('.magic-setup-footer-links').show().html($('.magic-setup-footer-links').attr('data-skip'));
			} else $('.magic-setup-footer-links').hide();
			
		};
	
	nav.each(function(){this.setAttribute('data-txt', this.innerHTML)});
	
	$('button.button-next').on('click', function(e) {
		e.preventDefault();
		$('#setup-body').addClass('loading');
		$('.magic-setup-footer-links').css({opacity: 0}).addClass('disabled');
		do_step();
	});
	
	$('.magic-wizard-service-toggle').on('click', function(e) {
		e.preventDefault();
		if ($(this).hasClass('disabled'))
			$(this).removeClass('disabled');
		else $(this).addClass('disabled');
	});
	
	$('.magic-setup-footer-links').on('click', function(e) {
		
		if ($(this).hasClass('disabled'))
			return e.preventDefault();
			
		if (step == 1)
			return true;
		
		e.preventDefault();
		next_step();
		
	});
	
})(jQuery);