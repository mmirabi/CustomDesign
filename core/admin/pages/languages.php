<?php

	$title = "Languages";
	$prefix = 'language_';

	$langs = $magic->get_langs();

	if (!isset($_SESSION[$prefix.'lang']))
		$_SESSION[$prefix.'lang'] = $magic->cfg->active_language;

	$data_lang = $_SESSION[$prefix.'lang'];

	if (isset($_POST['change_language'])) {
		$_SESSION[$prefix.'lang'] = $_POST['change_language'];
		$data_lang = $_POST['change_language'];
	} else if (!isset($_SESSION[$prefix.'lang']) && isset($langs[0])) {
		$_SESSION[$prefix.'lang'] = $langs[0];
		$data_lang = $langs[0];
	}

	// Action Form
	if (isset($_POST['action_submit']) && !empty($_POST['action_submit'])) {

		$data_action = isset($_POST['action']) ? $_POST['action'] : '';
		$val = isset($_POST['id_action']) ? $_POST['id_action'] : '';
		$val = explode(',', $val);

		$magic_admin->check_caps('languages');
		
		foreach ($val as $value) {

			switch ($data_action) {

				case 'delete':
					$magic_admin->delete_row($value, 'languages');
					break;
				default:
					break;

			}

		}

	}

	// Search Form
	$data_search = '';
	if (isset($_POST['search_language']) && !empty($_POST['search_language'])) {

		$data_search = isset($_POST['search']) ? trim($_POST['search']) : '';

		if (empty($data_search)) {
			$errors = 'Please Insert Key Word';
			$_SESSION[$prefix.'data_search'] = '';
		} else {
			$_SESSION[$prefix.'data_search'] = 	$data_search;
		}

	}

	if (!empty($_SESSION[$prefix.'data_search'])) {
		$data_search = '%'.$_SESSION[$prefix.'data_search'].'%';
	}

	// Pagination
	$per_page = 50;
	if(isset($_SESSION[$prefix.'per_page']))
		$per_page = $_SESSION[$prefix.'per_page'];

	if (isset($_POST['per_page'])) {

		$data = isset($_POST['per_page']) ? $_POST['per_page'] : '';

		if ($data != 'none') {
			$_SESSION[$prefix.'per_page'] = $data;
			$per_page = $_SESSION[$prefix.'per_page'];
		} else {
			$_SESSION[$prefix.'per_page'] = 20;
			$per_page = $_SESSION[$prefix.'per_page'];
		}

		$magic->redirect($magic->cfg->admin_url . "magic-page=languages");

	}

    // Sort Form
	if (!empty($_POST['sort'])) {

		$dt_sort = isset($_POST['sort']) ? $_POST['sort'] : '';
		$_SESSION[$prefix.'dt_order'] = $dt_sort;

		switch ($dt_sort) {

			case 'name_asc':
				$_SESSION[$prefix.'orderby'] = 'original_text';
				$_SESSION[$prefix.'ordering'] = 'asc';
				break;
			case 'name_desc':
				$_SESSION[$prefix.'orderby'] = 'original_text';
				$_SESSION[$prefix.'ordering'] = 'desc';
				break;
			default:
				break;

		}

		$magic->redirect($magic->cfg->admin_url . "magic-page=languages");

	}

	$orderby  = (isset($_SESSION[$prefix.'orderby']) && !empty($_SESSION[$prefix.'orderby'])) ? $_SESSION[$prefix.'orderby'] : 'original_text';
	$ordering = (isset($_SESSION[$prefix.'ordering']) && !empty($_SESSION[$prefix.'ordering'])) ? $_SESSION[$prefix.'ordering'] : 'asc';
	$dt_order = isset($_SESSION[$prefix.'dt_order']) ? $_SESSION[$prefix.'dt_order'] : 'name_asc';

	// Get row pagination
    $current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;
    $search_filter = array(
        'keyword' => $data_search,
        'fields' => 'text,original_text'
    );

    if (isset($data_lang) && !empty($data_lang) && $data_lang != 'en') {
	    $default_filters = array("lang" => $data_lang);
    }else $default_filters = null;

    $start = ( $current_page - 1 ) *  $per_page;
	$languages = $magic_admin->get_rows('languages', $search_filter, $orderby, $ordering, $per_page, $start, $default_filters);
	$total_record = $magic_admin->get_rows_total('languages');

    $config = array(
    	'current_page'  => $current_page,
		'total_record'  => $languages['total_count'],
		'total_page'    => $languages['total_page'],
 	    'limit'         => $per_page,
	    'link_full'     => $magic->cfg->admin_url.'magic-page=languages&tpage={page}',
	    'link_first'    => $magic->cfg->admin_url.'magic-page=languages',
	);

	$magic_pagination->init($config);

	if(
		$languages['total_page'] == 0 && 
		empty($data_search)
	){
		$_SESSION[$prefix.'lang'] = null;
	}

?>

<div class="magic_wrapper">

	<div class="magic_content">

		<div class="magic_header">
			<h2><?php echo $magic->lang('Languages'); ?></h2>
			<a href="#add" id="magic-add-language" class="add-new magic-button">
				<i class="fa fa-plus"></i> <?php echo $magic->lang('Add New Language'); ?>
			</a>
			<a href="#scan" id="magic-scan-language" class="add_new tip" style="top: 8px;left: 10px;">
				<i class="fa fa-refresh"></i> <?php echo $magic->lang('Rescan texts'); ?>
				<span><?php echo $magic->lang('Rescan all language texts from MagicRugs files'); ?></span>
			</a>
			<!--button class="magic_submit" id="magic-scan-language">
				<i class="fa fa-refresh"></i> <?php echo $magic->lang('Rescan all language texts'); ?>
			</button-->
			<?php
				$magic_page = isset($_GET['magic-page']) ? $_GET['magic-page'] : '';
				echo $magic_helper->breadcrumb($magic_page);
			?>
		</div>
		<div class="magic_message noti">
			<em class="magic_suc">
				<i class="fa fa-info-circle"></i>
				<?php echo $magic->lang('You can public, unpublic or select a language for backend & frontend in'); ?>
				<a href="<?php echo $magic->cfg->admin_url;?>magic-page=settings">
					<?php echo $magic->lang('General Settings'); ?>
					<i class="fa fa-cog"></i>
				</a>
			</em>
		</div>

		<div class="magic_option">
				<div class="left">
					
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=languages" method="post">
						<input type="hidden" name="id_action" class="id_action" />
						<input type="hidden" name="action" value="delete" />
						<input  class="magic_submit" type="submit" name="action_submit" value="<?php echo $magic->lang('Delete'); ?>">
						<?php $magic->securityFrom();?>
					</form>
					
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=languages" method="post">
						<input type="hidden" name="do" value="action" />
						<select name="per_page" class="art_per_page" data-action="submit">
							<option value="none">-- <?php echo $magic->lang('Per page'); ?> --</option>
							<?php
								$per_pages = array('10', '15', '20', '50', '100', '200', '300', '400', '500', '1000');

								foreach($per_pages as $val) {

								    if($val == $per_page) {
								        echo '<option selected="selected">'.$val.'</option>';
								    } else {
								        echo '<option>'.$val.'</option>';
								    }

								}
							?>
						</select>
						<?php $magic->securityFrom();?>
					</form>
					
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=languages" method="post">
						<input type="hidden" name="do" value="action" />
						<select name="sort" class="art_per_page" data-action="submit">
							<option value="">-- <?php echo $magic->lang('Sort by'); ?> --</option>
							<option value="name_asc" <?php if ($dt_order == 'name_asc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Name'); ?> A-Z</option>
							<option value="name_desc" <?php if ($dt_order == 'name_desc' ) echo 'selected' ; ?> ><?php echo $magic->lang('Name'); ?> Z-A</option>
						</select>
						<?php $magic->securityFrom();?>
					</form>
					
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=languages" method="post">
						<select name="change_language" onchange="this.parentNode.submit();">
							<option value=""> === <?php echo $magic->lang('All languages'); ?> === </option>
							<?php

								$lang_map = $magic->langs();

								foreach ($langs as $lang) {
									if (!empty($lang) && isset($lang_map[$lang])) {
										echo '<option value="'.$lang.'"'.(
											(
												isset($_SESSION[$prefix.'lang']) && 
												$_SESSION[$prefix.'lang'] == $lang
											) ? ' selected' : ''
										).'>'.$lang_map[$lang].'</option>';
									}
								}
								
							?>
						</select>
					</form>
					
				</div>
				<div class="right">
					<form action="<?php echo $magic->cfg->admin_url;?>magic-page=languages" method="post">
						<input type="search" name="search" class="search" placeholder="<?php echo $magic->lang('Search ...'); ?>" value="<?php if(isset($_SESSION[$prefix.'data_search'])) echo $_SESSION[$prefix.'data_search']; ?>">
						<input  class="magic_submit" type="submit" name="search_language" value="<?php echo $magic->lang('Search'); ?>">
						<?php $magic->securityFrom();?>

					</form>
				</div>
			</div>

		<?php if ( isset($languages['total_count']) && $languages['total_count'] > 0) { ?>

		<div class="magic_wrap_table">
			<table class="magic_table magic_languages" id="magic-languages-list">
				<thead>
					<tr>
						<th class="magic_check">
							<div class="magic_checkbox">
								<input type="checkbox" id="check_all">
								<label for="check_all"><em class="check"></em></label>
							</div>
						</th>
						<th width="40%"><?php echo $magic->lang('Original text'); ?></th>
						<th width="40%">
							<?php echo $magic->lang('Translate Text'); ?>
							&nbsp;
							<a href="#auto-translate" id="magic-auto-translate">
								<i class="fa fa-magic"></i> <?php echo $magic->lang('Auto Translate'); ?>
							</a>
						</th>
						<th width="100" class="center">
							<?php echo $magic->lang('Language'); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php

						if ( is_array($languages['rows']) && count($languages['rows']) > 0 ) {

							foreach ($languages['rows'] as $value) { ?>

								<tr data-id="<?php echo $value['id']; ?>">
									<td class="magic_check">
										<div class="magic_checkbox">
											<input type="checkbox" name="checked[]" class="action_check" value="<?php if(isset($value['id'])) echo $value['id']; ?>" class="action" id="<?php if(isset($value['id'])) echo $value['id']; ?>">
											<label for="<?php if(isset($value['id'])) echo $value['id']; ?>"><em class="check"></em></label>
										</div>
									</td>
									<td id="magic-lang-original-<?php echo $value['id']; ?>"><?php echo $value['original_text']; ?></td>
									<td>
										<span id="magic-lang-text-<?php echo $value['id']; ?>"><?php
											echo $value['text'];
										?></span>
										&nbsp;
										<a href="#edit" title="<?php
											echo $magic->lang('Edit this translate text');
										?>" data-edit-text="<?php echo $value['id']; ?>">
											<i class="fa fa-pencil-square-o"></i>
											<?php echo $magic->lang('edit'); ?>
										</a>
									</td>
									<td class="center">
										<?php if(isset($value['lang'])){
												echo '<img title="'.$value['lang'].'" height="30" src="'.$magic->cfg->assets_url.'assets/flags/'.$value['lang'].'.png" />';
											}
										?>
									</td>
								</tr>

							<?php }

						}

					?>
				</tbody>
			</table>
		</div>
		
		<div class="magic_pagination"><?php echo $magic_pagination->pagination_html(); ?></div>

		<?php } else {
					if (isset($total_record) && $total_record > 0) {
						echo '<p class="no-data">'.$magic->lang('Apologies, but no results were found.').'</p>';
						$_SESSION[$prefix.'data_search'] = '';
						echo '<a href="'.$magic->cfg->admin_url.'magic-page=languages" class="btn-back"><i class="fa fa-reply" aria-hidden="true"></i>'.$magic->lang('Back To Lists').'</a>';
					}
					else
						echo '<p class="no-data">'.$magic->lang('No data. Please add language.').'</p>';
			}?>

	</div>
</div>
<div id="magic-popup">
	<div class="magic-popup-content">
		<header>
			<input type="search" placeholder="<?php echo $magic->lang('Search countries...'); ?>" />
			<div id="magic-language-selected"><?php echo $magic->lang('Please select a language'); ?></div>
			<span class="close-pop" data-close><svg enable-background="new 0 0 32 32" height="32px" id="close" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M17.459,16.014l8.239-8.194c0.395-0.391,0.395-1.024,0-1.414c-0.394-0.391-1.034-0.391-1.428,0  l-8.232,8.187L7.73,6.284c-0.394-0.395-1.034-0.395-1.428,0c-0.394,0.396-0.394,1.037,0,1.432l8.302,8.303l-8.332,8.286  c-0.394,0.391-0.394,1.024,0,1.414c0.394,0.391,1.034,0.391,1.428,0l8.325-8.279l8.275,8.276c0.394,0.395,1.034,0.395,1.428,0  c0.394-0.396,0.394-1.037,0-1.432L17.459,16.014z" fill="#121313" id="Close"></path><g></g><g></g><g></g><g></g><g></g><g></g></svg></span>
		</header>
		<div class="magic-langs-wrp">
			<?php
				echo '<ul>';
				foreach($magic->langs() as $code => $country) {
					echo '<li data-code="'.$code.'">';
					echo '<img src="'.$magic->cfg->assets_url.'assets/flags/'.$code.'.png" height="24" />';
					echo $country;
					echo '</li>';
				}
				echo '</ul>';
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
(function($){

	var wrp = $('#magic-popup'),
		li = wrp.find('li'),
		show = function(){
			wrp.css({opacity:0}).show().animate({opacity: 1}, 250).find('header input').focus();
			wrp.find('.magic-popup-content').css({top: '-50px', opacity: 0}).animate({top: 0, opacity: 1}, 250);
		},
		hide = function(){
			wrp.animate({opacity: 0}, 250, function(){wrp.hide();});
			wrp.find('.magic-popup-content').animate({top: '-50px', opacity: 0}, 250);
		},
		nonce = "<?php echo magic_secure::create_nonce('MAGIC_ADMIN_languages') ?>";

	wrp.find('header input[type="search"]').on('input', function(e){
		var val = this.value.toLowerCase().trim();
		li.each(function(){
			if (this.innerHTML.toLowerCase().indexOf(val) > -1 || val === '')
				this.style.display = 'block';
			else this.style.display = 'none';
		});
	});

	li.on('click', function(){
		$('#magic-language-selected').html(
			'<button data-code="'+this.getAttribute('data-code')+'"><i class="fa fa-check"></i> <?php echo $magic->lang('Confirm to create language'); ?> "'+$(this).text()+'"</button>'
		);
	});

	wrp.on('click', function(e){
		if (e.target.tagName == 'BUTTON' && e.target.getAttribute('data-code')) {
			wrp.find('header').remove();
			wrp.find('.magic-langs-wrp').html('<p style="margin-top:200px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></p>');
			$.ajax({
				url: MagicDesign.ajax,
				method: 'POST',
				data: MagicDesign.filter_ajax({
					action: 'new_language',
					nonce: 'MAGIC_ADMIN:'+MagicDesign.nonce,
					code: e.target.getAttribute('data-code'),
				}),
				statusCode: {
					403: function(){
						location.reload();
					}
				},
				success: function(res){
                    // console.log(res);
					location.reload();
				}
			});
		}
		if (e.target.id == 'magic-popup'){
			hide();e.preventDefault();
		}
	}).find('header [data-close]').on('click', function(e){
		hide();e.preventDefault();
	});

	$('#magic-add-language').on('click', function(e){
		show();e.preventDefault();
	});

	$('#magic-scan-language').on('click', function(){
		
		var code = $('select[name="change_language"]').val();

		if (!code || code === '') {
			return alert('<?php echo $magic->lang('Please select a specific language before scanning'); ?>');
		}

		$(this).html('<i class="fa fa-spinner fa-spin fa-fw"></i> <?php echo $magic->lang('Please wait..'); ?>').attr({"disabled": "true"}).off('click');

		$.ajax({
			url: MagicDesign.ajax,
			method: 'POST',
			data: MagicDesign.filter_ajax({
				action: 'new_language',
				nonce: 'MAGIC_ADMIN_languages:'+nonce,
				code: $('select[name="change_language"]').val()
			}),
			statusCode: {
				403: function(){
					location.reload();
				}
			},
			success: function(res){
				location.reload();
			}
		});
	});

	$('a[data-edit-text]').on('click', function(e){
		var text = $(this).parent().find('>span').html();
		var new_text = prompt('<?php echo $magic->lang('Please enter the translate text'); ?> ('+$('select[name="change_language"] option:selected').html()+')', text);
		if (new_text !== null && new_text != text) {
			$.ajax({
				url: MagicDesign.ajax,
				method: 'POST',
				data: MagicDesign.filter_ajax({
					action: 'edit_language_text',
					nonce: 'MAGIC_ADMIN:'+MagicDesign.nonce,
					text: new_text,
					id: this.getAttribute('data-edit-text')
				}),
				statusCode: {
					403: function(){
						location.reload();
					}
				},
				success: function(res){
					$('#magic-lang-text-'+res.id).html(res.text);
				}
			});
		}
		e.preventDefault();
	});

	$('a#magic-auto-translate').on('click', function(e){
		
		e.preventDefault();
		
		var list = $('#magic-languages-list tbody tr'),
			code = $('select[name="change_language"]').val();
		
		if (!code || code === '') {
			return alert('<?php echo $magic->lang('Please select a specific language before scanning'); ?>');
		}
		
		$(this).after('<span id="magic-translating-wrp" style="color: #aaa;font-weight:400;font-style: italic"><i class="fa fa-spinner fa-spin fa-fw"></i> <?php echo $magic->lang('Translating'); ?> <span id="magic-auto-translating">0</span> of '+list.length+'</span>').remove();
		
		var text_data = [''],
			translating = $('#magic-auto-translating'),
			sch = window.location.href.indexOf('https') === 0 ? 'https' : 'http',
			stopon = 0,
			done = 0,
			get_translate = function(i) {
				if (text_data[i] !== undefined) {
					$.get('https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl='+code+'&dt=t&q='+text_data[i],
					function(res){
						var id, txt;
						if (typeof res == 'object' && res[0].length > 0) {
							var data_post = {};
							res[0].map(function(tr) {
								id = tr[1].split('_._')[0].replace('#', '').trim();
								if (tr[0] != tr[1]) {
									txt = tr[0].trim().replace("\n", '').split('_._');
									txt = txt[1] !== undefined ? txt[1].trim() : txt[0].trim();
									txt = txt.replace(/\"\-\"/g, '.');
									data_post[id] = txt;
								} else {
									if(Number.isInteger(parseInt(id))){
										$('#magic-lang-text-'+id).after(' <i class="fa fa-check"></i>');
									}
									done++;
									translating.html(done);
									if (done == list.length){
										$('#magic-translating-wrp').css({color: 'green'}).html('Translate complete!');
									}
								}
							});
							
							if (Object.keys(data_post).length > 0) {
								$.ajax({
									url: MagicDesign.ajax,
									method: 'POST',
									data: MagicDesign.filter_ajax({
										action: 'edit_language_text',
										nonce: 'MAGIC_ADMIN:'+MagicDesign.nonce,
										text: data_post
									}),
									statusCode: {
										403: function(){
											location.reload();
										}
									},
									success: function(res){
										if (res == 0 || res == '0') {
											alert('Error on update translate text');
											return; 
										}
										Object.keys(res).map(function(re) {
											$('#magic-lang-text-'+re).html(res[re]).after(' <i class="fa fa-check"></i>');
											done++;
											translating.html(done);
											if (done == list.length)
												$('#magic-translating-wrp').css({color: 'green'}).html('Translate complete!');
										});
									}
								});
							}
							
						}
						
						get_translate(i+1);
						
					});
				}	
			};
			
		list.each(function() {
			
			var id = this.getAttribute('data-id'),
				origin = $('#magic-lang-original-'+id).html(),
				text = $('#magic-lang-text-'+id).html();
			
			if (text == origin)	{
				
				var vartxt = '%23'+id+'_._'+$('#magic-lang-text-'+id).html().trim()
							.replace(/\%/g, '%25').replace(/\#/g, '%23')
							.replace(/\|/g, '%7C').replace(/\"/g, '%22')
							.replace(/\./g, '%22-%22')
							.replace(/\&/g, '%26').replace(/\?/g, '%3F')+"%0A";
							
				if (text_data[stopon].length+vartxt.length > 5000) {
					stopon++;
					text_data[stopon] = '';
				};
				
				text_data[stopon] += vartxt;
				
			} else {
				$('#magic-lang-text-'+id).after(' <i class="fa fa-check"></i>');
				done++;
				translating.html(done);
				if (done == list.length)
					$('#magic-translating-wrp').css({color: 'green'}).html('Translate complete!');
			}
			
		});
			
		get_translate(0);
			
	});

})(jQuery);
</script>