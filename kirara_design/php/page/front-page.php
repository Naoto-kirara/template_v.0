<?php

/**
 * Template Name: トップページテンプレ
 */
?>

<?php get_header(); ?>
<main <?PHP body_class(); ?>>
	<article class="top_page">
		<?php include('siteHeader.php'); ?>
		<div class="topPage_layout">
			<div class="topPage_content">
				<?php the_content(); ?>
			</div>
		</div>
	</article>
	<!-- コンタクトを下部に表示 -->
	<?php
	include 'parts/contact.php';
	?>
</main>
<?php get_footer(); ?>