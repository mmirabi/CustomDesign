<div class="magic_wrapper" id="magic-addons-page">
	<div class="magic_content">
		<div class="magic_header">
			<h2><?php echo $magic->lang('Explore all addons'); ?></h2>
			<a href="<?php echo $magic->cfg->admin_url; ?>magic-page=addons"class="add-new magic-button">
				<i class="fa fa-download"></i> 
				<?php echo $magic->lang('Your installed addons'); ?>
			</a>
		</div>
		<div class="">
			<?php
				
				$curDate = date_default_timezone_get();
				date_default_timezone_set("Asia/Bangkok");
				$rss = $magic->lib->remote_connect($magic->cfg->api_url.'addons/explore.xml?nonce='.date('dH'));
				date_default_timezone_set($curDate);

				$rss = @simplexml_load_string($rss);
				
				if ($rss) {
		
					$count = count($rss->channel->item);
					$installed = $magic->addons->load_installed(); 
					$html = '';
					for ($i = 0; $i < $count; $i++) {
		
						$item = $rss->channel->item[$i];
						$slug = (string)$item->slug;
						$platforms = explode(',', (string)$item->platforms);
						
						if (
							!isset($installed[$slug]) && 
							in_array($magic->connector->platform, $platforms)
						) {
							
							$title_link = (
								isset($item->detail) ? 
								$item->detail : 
								(isset($item->link) ? $item->link : 'javascript:avoid(0)')
							);
							
							$html .= '<div class="magic_wrap magic_addons"><figure>';
							$html .= '<img src="'.$item->thumb.'">';
							$html .= '<span class="price"><i class="fa fa-dollar" aria-hidden="true"></i>'.$item->price.'</span>';
							$html .= '</figure>';
							$html .= '<div class="magic_right"><a href="'.$title_link.'" target="_blank">'.$item->title.'</a>';
							$html .= '<div class="magic_meta">';
							$html .= '<span><i class="fa fa-folder" aria-hidden="true"></i>'.implode(', ', $platforms).'</span>';
							$html .= '</div>';
							$html .= '<p>'.$item->description.'</p>';
							
							if (isset($item->link))
								$html .= '<a href="'.$item->link.'" target=_blank class="buy_now">'.$magic->lang('Get It Now').' &rarr;</a>';

							$html .= '</div></div>';
						}
		
					}
		
					echo $html;
					
				} else {
					echo '<p>'.$magic->lang('Could not load data at this time. Please check your internet connection!').'</p>';
				}
			?>
		</div>
	</div>
</div>
