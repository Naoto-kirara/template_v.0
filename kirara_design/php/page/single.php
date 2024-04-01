<?php

/**
 * single.php
 */

get_header();
?>

<main class="pagePost">
	<article>
		<?php include('siteHeader.php'); ?>
		<div class="siteLayout">
			<div class="siteContent">

				<div class="post">
					<?php
					if (have_posts()) :

						while (have_posts()) : the_post();
							echo '<div class="post_header">';
							echo '<div class="post_info"><p class="post_time">' . get_the_time('Y.m.d') . '</p>';
							echo '<p class="post_cat">' . get_the_category_list(', ') . '</p></div>';
							the_title('<h1 class="post_heading">', '</h1>');
							echo '</div>';

							the_content();

						endwhile;

					else :
						echo '投稿がありません。';

					endif;
					?>
					<div class="btn">
						<a href="../news">一覧に戻る</a>
					</div>
				</div>
			</div>
			<!-- サイドメニュー -->
			<?php display_custom_sidebar_content(); ?>
		</div>
		<?php
		include 'parts/contact.php';
		?>
	</article>
</main>
<?php
get_footer();
?>