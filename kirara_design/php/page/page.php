<?php

/**
 * Template Name: 固定ページテンプレ
 */
?>
<?php get_header(); ?>
<main <?php body_class(); ?>>
	<?php
	$current_page_id = get_the_ID();
	$ancestors = get_post_ancestors($current_page_id);

	if (is_page('recruit') || in_array(get_page_by_path('recruit')->ID, $ancestors)) : ?>
		<article class="page_recruit">
		<?php else : ?>
			<article>
			<?php endif; ?>
			<?php include('siteHeader.php'); ?>
			<?php $display_option = get_post_meta($post->ID, 'side_menu_display', true); ?>
			<div class="siteLayout <?php echo $display_option === 'none' ? 'siteLayout-single' : ''; ?>">
				<div class="siteContent">
					<?php the_content(); ?>
				</div>
				<!-- サイドメニュー -->
				<?php display_custom_sidebar_content(); ?>
			</div>
			</article>
			<!-- ページに合わせて関連記事、コンタクトを下部に表示 -->
			<?php
			if ($post) {
				$post_id = $post->ID;
				$parent_id = wp_get_post_parent_id($post_id);
				$ancestors = get_post_ancestors($post_id);
				$current_parent_id = ($parent_id === 0) ? $post_id : $parent_id;
				if (($current_parent_id == get_page_by_path('about')->ID && count($ancestors) > 0) || in_array(get_page_by_path('about')->ID, $ancestors)) {
					// 会社案内ページの場合
					include 'parts/about_related-page.php';
				} elseif ((in_array(get_page_by_path('recruit')->ID, $ancestors) && !is_page('recruit'))) {
					// 採用情報ページの場合（かつrecruitのトップページでない場合）
					include 'parts/recruit_related-page.php';
				}
			}
			include 'parts/contact.php';
			?>
</main>
<?php get_footer(); ?>