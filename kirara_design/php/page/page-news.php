<?php

/**
 * Template Name: newsページテンプレ
 */
?>

<?php get_header(); ?>

<main <?php body_class(); ?>>
	<article>
		<?php include('siteHeader.php'); ?>
		<div class="siteLayout">
			<div class="siteContent">
				<ul class="news">
					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

					$args = array(
						'post_type'      => 'post',
						'posts_per_page' => 10,
						'orderby'        => 'date',
						'order'          => 'DESC',
						'paged'          => $paged,
					);
					$query = new WP_Query($args);

					if ($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();
					?>
							<li class="news_item">
								<div class="news_info">
									<p class="news_time"><?php the_time('Y.m.d'); ?></p>
									<p class="news_cat"><?php the_category(', '); ?></p>
								</div>
								<h2 class="news_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</li>

					<?php
						}
						// ページネーション
						$total_pages = $query->max_num_pages;
						$current_page = max(1, get_query_var('paged'));
						echo '<div class="pagenation">';
						echo '<span class="pagenation_arrow prev"><a href="' . esc_url(get_pagenum_link($current_page - 1)) . '">
						<span class="icon svgIcon-arrow-left">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
						<polygon points="419.916,71.821 348.084,0 92.084,256.005 348.084,512 419.916,440.178 235.742,256.005 	" style="fill: rgb(38, 55, 112);"></polygon>
					</svg>
					</span>
					</a></span>';
						for ($i = 1; $i <= $total_pages; $i++) {
							echo '<span class="pagenation_numbers ' . ($current_page === $i ? 'current' : '') . '">';
							echo '<a href="' . esc_url(get_pagenum_link($i)) . '">' . $i . '</a>';
							echo '</span>';
						}
						echo '<span class="pagenation_arrow next"><a href="' . esc_url(get_pagenum_link($current_page + 1)) . '">
						<span class="icon svgIcon-arrow-right">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
						<polygon points="419.916,71.821 348.084,0 92.084,256.005 348.084,512 419.916,440.178 235.742,256.005 	" style="fill: rgb(38, 55, 112);"></polygon>
					</svg>
					</span>
					</a>
					</span>
					';
						echo '</div>';
					} else {
						echo '投稿がありません。';
					}
					wp_reset_postdata();
					?>
				</ul>
			</div>
			<!-- サイドメニュー -->
			<?php display_custom_sidebar_content() ?>
		</div>
	</article>
	<!-- ページに合わせて関連記事、コンタクトを下部に表示 -->
	<?php include 'parts/contact.php'; ?>
</main>
<?php get_footer(); ?>