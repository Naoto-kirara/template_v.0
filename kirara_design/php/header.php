<!DOCTYPE html>
<html lang="ja">

<head>
	<title>★</title>
	<!-- font -->
	<link rel="stylesheet" href="https://use.typekit.net/flr4ion.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
	<!-- minion-pro -->
	<link rel="stylesheet" href="https://use.typekit.net/sgh8fdr.css">
	<!-- css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri('/css/style.css'); ?>">
	<!-- js -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script src="<?php echo get_theme_file_uri('/js/totop.js'); ?>"></script>

</head>

<body>
	<header>
		<div class="header">
			<h1 class="header_title">
				<a class="header_item_link" href="<?php echo esc_url(home_url('/')); ?>">
					<img src="" alt="ロゴ">
				</a>
			</h1>
			<div class="gNav pc">
				<ul class="gNav_container">

					<li class="gNav_item">
						<a class="gNav_item_link" href="<?php echo esc_url(home_url('about')); ?>">会社案内</a>
						<div class="gNav_sub">
							<div class="gNav_sub_container">
								<p class="gNav_sub_title">
									<span class="gNav_sub_title-ja">会社案内</span>
									<span class="gNav_sub_title-en">Company</span>
								</p>
								<ul class="gNav_sub_list">
									<li class="gNav_subMenu">
										<ul class="gNav_subMenu_list">
											<li class="gNav_subMenu_item"><a href="<?php echo esc_url(home_url('/about/message-2/')); ?>">トップメッセージ</a></li>
											<li class="gNav_subMenu_item"><a href="<?php echo esc_url(home_url('/about/philosophy/')); ?>">経営理念</a></li>
											<li class="gNav_subMenu_item"><a href="<?php echo esc_url(home_url('/about/organization/')); ?>">会社概要・組織図</a></li>
											<li class="gNav_subMenu_item"><a href="<?php echo esc_url(home_url('/about/history/')); ?>">沿革</a></li>
											<li class="gNav_subMenu_item"><a href="<?php echo esc_url(home_url('/about/group/')); ?>">グループ企業</a></li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</li>

					<li class="gNav_item">
						<a class="gNav_item_link" href="<?php echo esc_url(home_url('contact')); ?>">お問い合わせ</a>
					</li>

				</ul>
			</div>
			<div class="hamburger">
				<button class="hamburger_btn">
					<span class="hamburger_icon"></span>
				</button>
				<nav class="hamburger_nav">
					<ul class="hamburger_list">
						<?php
						$args = array(
							'post_type'      => 'page',
							'posts_per_page' => -1,
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
							'post_parent'    => 0,
							'post__not_in' => array('500', '480'),
						);
						$query = new WP_Query($args);
						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post(); ?>
								<li class="hamburger_item">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<?php
									// 子ページのクエリ
									$child_args = array(
										'post_type'      => 'page',
										'posts_per_page' => -1,
										'orderby'        => 'menu_order',
										'order'          => 'ASC',
										'post_parent'    => get_the_ID(),
										'post__not_in' => array('570', '606'),
									);
									$child_query = new WP_Query($child_args);
									if ($child_query->have_posts()) :
									?>
										<ul class="hamburger_list-parentBox">
											<?php while ($child_query->have_posts()) : $child_query->the_post(); ?>
												<li class="hamburger_list-child"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
											<?php endwhile; ?>
										</ul>
									<?php endif; ?>
									<?php wp_reset_postdata(); ?>
								</li>
						<?php
							endwhile;
							wp_reset_postdata();
						else :
							echo '第1階層の固定ページが見つかりませんでした。';
						endif;
						?>
						<li class="hamburger_item hamburger_item-others">
							<a href="http://fjsho-ghdfhks-demo11.local/contact/">お問合せ</a>
						</li>
						<li class="hamburger_item hamburger_item-others">
							<a href="http://fjsho-ghdfhks-demo11.local/privacy/">個人情報保護方針</a>
						</li>
						<li class="hamburger_item hamburger_item-others">
							<a href="http://fjsho-ghdfhks-demo11.local/sitemap/">サイトマップ</a>
						</li>
						<li class="hamburger_design sp"><img src="/wp-content/uploads/logo_mark_fghd.png" alt=""></li>
					</ul>
				</nav>
			</div>
		</div>
	</header>