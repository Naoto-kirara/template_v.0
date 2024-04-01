<?php wp_footer(); ?>
<div class="pagetop">
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 12.7">
		<path fill="none" stroke="#fff" stroke-miterlimit="10" d="M.4 12.4 12 .7l11.7 11.7" />
	</svg>
</div>
<footer class="footer">
	<div class="footerLogo pc">
		<div class="footerLogo_img"><img src="/wp-content/uploads/logo_fghd-scaled.webp" alt="富士商グループホールディングスロゴ"></div>
	</div>
	<div class="footerLayout">
		<address class="footerInfo">
			<div class="footerInfo_name">
				<p>富士商グループホールディングス株式会社</p>
			</div>
			<div class="footerInfo_location">
				<p>〒756-0811</p>
				<p>山口県山陽小野田市稲荷町10-23</p>
			</div>
			<!-- <dl class="footerInfo_contact">
				<dt>TEL:</dt>
				<dd>0836-81-1111</dd>
				<br class="pc-br">
				<dt>mail:</dt>
				<dd>Info@mail.com</dd>
			</dl> -->
			<div class="footerInfo_banner">
				<span><img src="" alt=""></span>
				<span><img src="" alt=""></span>
			</div>
		</address>
		<div class="footerNavi">
			<ul class="footerNavi_list">
				<?php
				$args = array(
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'post_parent'    => 0,
				);

				$query = new WP_Query($args);

				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
				?>
						<li class="footerNavi_item">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<?php
							// 特定のスラッグの場合は子階層を表示しない
							$exclude_slugs = array('news', 'contact');
							//特定のスラッグの場合そのページを表示しない
							$current_slug = get_post_field('post_name', get_post());
							$exclude_page_paths = array(
								'/recruit/crosstalk01',
								'/recruit/crosstalk02',
								'/recruit/crosstalk03'
							);
							$exclude_page_ids = array_map(function ($path) {
								return get_page_by_path($path)->ID;
							}, $exclude_page_paths);

							if (!in_array($current_slug, $exclude_slugs)) {
								// 子ページのクエリ
								$child_args = array(
									'post_type'      => 'page',
									'posts_per_page' => -1,
									'orderby'        => 'menu_order',
									'order'          => 'ASC',
									'post_parent'    => get_the_ID(),
									'post__not_in' => $exclude_page_ids,
								);
								$child_query = new WP_Query($child_args);

								if ($child_query->have_posts()) :
							?>
									<ul class="footerNavi_list-parentBox">
										<?php while ($child_query->have_posts()) : $child_query->the_post(); ?>
											<li class="footerNavi_list-child"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
										<?php endwhile; ?>
									</ul>
							<?php
								endif;

								wp_reset_postdata();
							}
							?>
						</li>
				<?php
					endwhile;
					wp_reset_postdata();
				else :
					echo '第1階層の固定ページが見つかりませんでした。';
				endif;
				?>


			</ul>
			<div class="footerLogo sp">
				<div class="footerLogo_img"> <img src="/wp-content/uploads/logo_fujishoGHD_sp.webp" alt="富士商グループホールディングスロゴ"> </div>
			</div>
		</div>
	</div>
	<div class="copyRight sp">
		<p>Copyright © Fujisho Group Holdings All Rights Reserved.</p>
	</div>
</footer>
<script>
	function scrollAddClass() {
		const scrollEffect = document.querySelectorAll("section:not(:first-child) > *,.history_item");
		let windowHeight = window.innerHeight;
		for (let i = 0; i < scrollEffect.length; i++) {
			let target = scrollEffect[i].getBoundingClientRect().top;
			if (target < windowHeight) {
				scrollEffect[i].classList.add("is-active");
			}
		}
	}
	window.addEventListener('scroll', scrollAddClass);
	window.addEventListener('scroll', scrollAddClass);
	document.querySelector('.hamburger_btn').addEventListener('click', function() {
		document.querySelector('.hamburger_list').classList.toggle('is-open');
	});
	//header scroll effect
	window.addEventListener('scroll', function() {
		var header = document.getElementsByClassName('header')[0];

		if (window.pageYOffset > 0) {
			header.classList.add('scrolled');
		} else {
			header.classList.remove('scrolled');
		}
	});
</script>
</body>

</html>