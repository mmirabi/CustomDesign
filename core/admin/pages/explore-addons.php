<div class="customdesign_wrapper" id="customdesign-addons-page">
	<div class="customdesign_content">
		<div class="customdesign_header">
			<h2><?php echo $customdesign->lang('Explore all addons'); ?></h2>
			<a href="<?php echo $customdesign->cfg->admin_url; ?>customdesign-page=addons"class="add-new customdesign-button">
				<i class="fa fa-download"></i> 
				<?php echo $customdesign->lang('Your installed addons'); ?>
			</a>
		</div>
		<div class="">
			<?php
				
				$curDate = date_default_timezone_get();
				date_default_timezone_set("Asia/Bangkok");
				$rss = $customdesign->lib->remote_connect($customdesign->cfg->api_url.'addons/explore.xml?nonce='.date('dH'));
				date_default_timezone_set($curDate);

				$rss = @simplexml_load_string($rss);
				
				if ($rss) {
		
					$count = count($rss->channel->item);
					$installed = $customdesign->addons->load_installed(); 
					$html = '';
					for ($i = 0; $i < $count; $i++) {
		
						$item = $rss->channel->item[$i];
						$slug = (string)$item->slug;
						$platforms = explode(',', (string)$item->platforms);
						
						if (
							!isset($installed[$slug]) && 
							in_array($customdesign->connector->platform, $platforms)
						) {
							
							$title_link = (
								isset($item->detail) ? 
								$item->detail : 
								(isset($item->link) ? $item->link : 'javascript:avoid(0)')
							);
							
							$html .= '<div class="customdesign_wrap customdesign_addons"><figure>';
							$html .= '<img src="'.$item->thumb.'">';
							$html .= '<span class="price"><i class="fa fa-dollar" aria-hidden="true"></i>'.$item->price.'</span>';
							$html .= '</figure>';
							$html .= '<div class="customdesign_right"><a href="'.$title_link.'" target="_blank">'.$item->title.'</a>';
							$html .= '<div class="customdesign_meta">';
							$html .= '<span><i class="fa fa-folder" aria-hidden="true"></i>'.implode(', ', $platforms).'</span>';
							$html .= '</div>';
							$html .= '<p>'.$item->description.'</p>';
							
							if (isset($item->link))
								$html .= '<a href="'.$item->link.'" target=_blank class="buy_now">'.$customdesign->lang('Get It Now').' &rarr;</a>';

							$html .= '</div></div>';
						}
		
					}
		
					echo $html;
					
				} else {
					echo '<p>'.$customdesign->lang('Could not load data at this time. Please check your internet connection!').'</p>';
				}
			?>
		</div>
	</div>
</div>
