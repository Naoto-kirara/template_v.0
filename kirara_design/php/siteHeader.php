<?php if (!(is_home() || is_front_page())) : ?>
	<div class="siteHeader">
		<div class="pageTitle">
			<?php breadcrumb(); ?>
			<h1 class="pageTitle_text">
				<span class="icon_pageTitle">
					<svg class="svgIcon" width="140">
						<use xlink:href="#fso" />
					</svg>
				</span>
				<?php if (is_single() || is_category()) : ?>
					<span class="pageTitle_en">News</span>
					<span class="pageTitle_ja">お知らせ</span>
				<?php else : ?>
					<span class="pageTitle_en"><?php echo post_custom('title_en'); ?></span>
					<span class="pageTitle_ja"><?php the_title(); ?></span>
				<?php endif; ?>
			</h1>
		</div>
		<!-- 固定ページのヒーロー画像で選択された画像をページのヒーローイメージとして使用 -->
		<?php
		$page_image = get_post_meta(get_the_ID(), 'page_image', true);
		if (!empty($page_image)) {
			$page_title = get_the_title();
			echo '<div class="pageTitle_img">';
			echo '<img src="' . esc_url($page_image) . '" alt="' . esc_attr($page_title) . 'ページヒーロー画像">';
			echo '</div>';
		} ?>
	</div>
<?php endif; ?>