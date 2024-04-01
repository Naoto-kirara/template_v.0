<?php

/**********************************************************************************/
//エディタのインデント幅変更
/**********************************************************************************/
function add_admin_custom_style()
{
	echo '<style type="text/css">
				 .wp-editor-area {
						-o-tab-size:2;
						-moz-tab-size:2;
						tab-size: 2 ;
						font-size:12px !important;
				 }
			 </style>';
}
add_action('admin_head', 'add_admin_custom_style');
/**********************************************************************************/
//投稿ページはブロックエディタ
/**********************************************************************************/
add_filter('use_block_editor_for_post_type', 'enable_block_editor', 100, 10);
function enable_block_editor($use_block_editor, $post_type)
{
	if ($post_type === 'post') return true;
	return $use_block_editor;
}
/**********************************************************************************/
//投稿ページの本文中のPタグに自動クラス追加
/**********************************************************************************/
function add_custom_class_to_paragraph($content)
{
	if (is_single()) {
		$content = preg_replace('/<p([^>]+)?>/', '<p$1 class="wp-block-paragraph">', $content);
	}
	return $content;
}

add_filter('the_content', 'add_custom_class_to_paragraph');
/**********************************************************************************/
//自動整形無効
/**********************************************************************************/
function wpautop_filter($content)
{
	global $post;
	$remove_filter = false;
	$arr_types = array('page');
	$post_type = get_post_type($post->ID);
	if (in_array($post_type, $arr_types)) $remove_filter = true;
	if ($remove_filter) {
		remove_filter('the_content', 'wpautop');
		remove_filter('the_excerpt', 'wpautop');
	}
	return $content;
};
add_filter('the_content', 'wpautop_filter', 9);
/**********************************************************************************/
//Contact Form 7の自動pタグ無効
/**********************************************************************************/
function wpcf7_autop_return_false()
{
	return false;
}
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
/**********************************************************************************/
//ページのスラッグをmainにクラス付与
/**********************************************************************************/
function add_class_page_slug($classes)
{
	if (is_page()) {
		$page = get_post(get_the_ID());
		$classes[] = 'page_' . $page->post_name;

		if ($page->post_parent) {
			$classes[] = 'pageSub';
		}
	}
	return $classes;
};
add_filter('body_class', 'add_class_page_slug');
/**********************************************************************************/
//不要なクラスを指定して除外
/**********************************************************************************/
function remove_body_class($classes)
{
	$exclude_classes = array('page-template-default', 'logged-in', 'page-id', 'page-id-ID', 'admin-bar', 'no-customize-support');
	$classes = array_diff($classes, $exclude_classes);
	return $classes;
};
add_filter('body_class', 'remove_body_class');
/**********************************************************************************/
//wordpressメディア一ライブラリを相対パスで表示
/**********************************************************************************/
function del_domain_from_image_url($url)
{
	if (preg_match('/^http(s)?:\/\/[^\/\s]+(.*)$/', $url, $match)) {
		$url = $match[2];
	}
	return $url;
}
add_filter('wp_get_attachment_url', 'del_domain_from_image_url');
add_filter('attachment_link', 'del_domain_from_image_url');
/**********************************************************************************/
//phpファイルショートコード
/**********************************************************************************/
function Include_my_php($params = array())
{
	extract(shortcode_atts(array(
		'file' => 'default'
	), $params));
	ob_start();
	include(get_theme_root() . '/' . get_template() . "php/parts/$file.php");
	return ob_get_clean();
};
add_shortcode('myphp', 'Include_my_php');
/**********************************************************************************/
// SVGファイルをアップロードできるようにする
/**********************************************************************************/
function add_file_types_to_uploads($file_types)
{
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes);
	return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');
/**********************************************************************************/
//ページ一覧にスラッグ表示
/**********************************************************************************/
function add_page_column_slug_title($columns)
{
	$columns['slug'] = "スラッグ";
	return $columns;
}
function add_page_column_slug($column_name, $post_id)
{
	if ($column_name == 'slug') {
		$post = get_post($post_id);
		$slug = $post->post_name;
		echo esc_attr($slug);
	}
}
add_filter('manage_pages_columns', 'add_page_column_slug_title');
add_action('manage_pages_custom_column', 'add_page_column_slug', 10, 2);
/**********************************************************************************/
//固定ページに英語タイトル記入欄を設置
/**********************************************************************************/
function custom_page_meta_box()
{
	add_meta_box(
		'custom_english_title_meta_box',
		'英語タイトル',
		'display_title_en_field',
		'page',
		'side',
		'default'
	);
}
function display_title_en_field($post)
{
	$current_value = get_post_meta($post->ID, 'title_en', true);

	wp_nonce_field('custom_english_title_nonce', 'custom_english_title_nonce');

	echo '<input type="text" id="custom_english_title_field" name="custom_english_title_field" value="' . esc_attr($current_value) . '" size="25" />';
}
function savetitle_en_field($post_id)
{
	if (!isset($_POST['custom_english_title_nonce']) || !wp_verify_nonce($_POST['custom_english_title_nonce'], 'custom_english_title_nonce')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_page', $post_id)) {
		return;
	}

	if (isset($_POST['custom_english_title_field'])) {
		update_post_meta($post_id, 'title_en', sanitize_text_field($_POST['custom_english_title_field']));
	}
}
add_action('add_meta_boxes', 'custom_page_meta_box');
add_action('save_post', 'savetitle_en_field');
/**********************************************************************************/
//固定ページにヒーローイメージ選択のカスタムボックス設置
/**********************************************************************************/
function custom_page_image_metabox()
{
	add_meta_box(
		'page_image_metabox',
		'ヒーロー画像',
		'render_page_image_metabox',
		'page',
		'side',
		'default'
	);
}
function render_page_image_metabox($post)
{
	wp_nonce_field(basename(__FILE__), 'page_image_metabox_nonce');
	$page_image = get_post_meta($post->ID, 'page_image', true);
?>
	<p>
		<img src="<?php echo esc_attr($page_image); ?>" alt="" style="max-width: 100%; cursor: pointer;" id="page-image-preview" />
	</p>
	<p>
		<input type="text" name="page_image" id="page_image" class="meta-image" value="<?php echo esc_url($page_image); ?>" style="display:none;" />
		<input type="button" class="button image-upload" value="画像を選択" />
		<input type="button" class="button image-cancel" value="画像をキャンセル" style="margin-top: 5px;" />
	</p>
	<script>
		jQuery(document).ready(function($) {
			var customUploader = wp.media({
				title: '画像を選択',
				button: {
					text: '画像を選択'
				},
				multiple: false
			});

			function openMediaUploader() {
				customUploader.open();
				customUploader.on('select', function() {
					var attachment = customUploader.state().get('selection').first().toJSON();
					$('.meta-image').val(attachment.url);
					$('#page-image-preview').attr('src', attachment.url);
				});
			}
			$('#page-image-preview').click(function(e) {
				e.preventDefault();
				openMediaUploader();
			});
			$('.image-upload').click(function(e) {
				e.preventDefault();
				openMediaUploader();
			});
			$('.image-cancel').click(function(e) {
				e.preventDefault();
				$('.meta-image').val('');
				$('#page-image-preview').attr('src', '');
			});
		});
	</script>
<?php
}
add_action('add_meta_boxes', 'custom_page_image_metabox');
function save_page_image_metabox($post_id)
{
	if (!isset($_POST['page_image_metabox_nonce']) || !wp_verify_nonce($_POST['page_image_metabox_nonce'], basename(__FILE__))) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}
	if (isset($_POST['page_image'])) {
		update_post_meta($post_id, 'page_image', esc_url_raw($_POST['page_image']));
	}
}
add_action('save_post', 'save_page_image_metabox');
/**********************************************************************************/
//パンくずリスト
/**********************************************************************************/
function breadcrumb()
{
	$breadcrumb_items = array();
	global $post;
	$categories = get_the_category($post->ID);

?>
	<div class="breadcrumb">
		<ol class="breadcrumb_list" itemscope itemtype="https://schema.org/BreadcrumbList">
			<li class="breadcrumb_item breadcrumb-top" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a itemprop="item" href="<?php echo esc_url(home_url()); ?>" class="breadcrumb_itemLink breadcrumb_itemLink-top">
					<span itemprop="name"><span class="icon_breadcrumb"></span>TOP</span>
				</a>
				<meta itemprop="position" content="1">
			</li>

			<?php if ($post->post_parent) :
				$current_post = $post;

				while ($current_post->post_parent) {
					$parent_post = get_post($current_post->post_parent);
					$breadcrumb_items[] = array(
						'title' => get_the_title($parent_post->ID),
						'url' => get_page_link($parent_post->ID)
					);
					$current_post = $parent_post;
				}

				foreach (array_reverse($breadcrumb_items) as $index => $breadcrumb_item) { ?>
					<li class="breadcrumb_item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemscope itemtype="https://schema.org/WebPage" itemprop="item" itemid="<?php echo $breadcrumb_item['url']; ?>" href="<?php echo $breadcrumb_item['url']; ?>" class="breadcrumb_itemLink">
							<span itemprop="name"><?php echo $breadcrumb_item['title']; ?></span>
						</a>
						<meta itemprop="position" content="<?php echo $index + 2; ?>">
					</li>
			<?php }
			endif; ?>

			<!-- お知らせカテゴリーページ-->
			<?php if (is_category()) : ?>
				<li class="breadcrumb_item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a href="/news" itemprop="item">
						<span itemprop="name">お知らせ</span>
					</a>
					<meta itemprop="position" content="2">
				</li>
				<?php foreach ($categories as $category) : ?>
					<li class="breadcrumb_item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a href="<?php echo get_category_link($category->term_id); ?>" itemprop="item">
							<span itemprop="name"><?php echo esc_html($category->name); ?></span>
						</a>
						<meta itemprop="position" content="<?php echo ($post->post_parent) ? '4' : '3'; ?>">
					</li>
				<?php endforeach; ?>
				<!-- お知らせ詳細 -->
			<?php elseif (is_single()) : ?>
				<li class="breadcrumb_item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a href="./news" itemprop="item">
						<span itemprop="name">お知らせ</span>
					</a>
					<meta itemprop="position" content="2">
				</li>
				<?php foreach ($categories as $category) : ?>
					<li class="breadcrumb_item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" itemprop="item">
							<span itemprop="name"><?php echo esc_html($category->name); ?></span>
						</a>
						<meta itemprop="position" content="<?php echo ($post->post_parent) ? '4' : '3'; ?>">
					</li>
					<li class="breadcrumb_item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<span itemprop="name"><?php echo esc_html(get_the_title()); ?></span>
						<meta itemprop="position" content="<?php echo ($post->post_parent || (is_single() && $categories)) ? '4' : '3'; ?>">
					</li>
				<?php endforeach; ?>

			<?php else : ?>
				<li class="breadcrumb_item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<span itemprop="name"><?php echo esc_html(get_the_title()); ?></span>
					<meta itemprop="position" content="<?php echo ($post->post_parent || (is_single() && $categories)) ? '4' : '3'; ?>">
				</li>
			<?php endif; ?>

		</ol>
	</div>
<?php
}
/**********************************************************************************/
//固定ページ管理画面にサイドメニュー表示方法を分岐させるトグルメニューを作成
/**********************************************************************************/
function add_custom_fields_meta_box()
{
	add_meta_box(
		'page_display_settings',
		'サイドメニュー表示設定',
		'render_custom_fields_meta_box',
		'page',
		'side',
		'default'
	);
}
add_action('add_meta_boxes', 'add_custom_fields_meta_box');
function render_custom_fields_meta_box($post)
{
	$display_option = get_post_meta($post->ID, 'side_menu_display', true);
?>
	<select name="side_menu_display" id="side-menu-display">
		<option value="same_category" <?php echo ($display_option === 'same_category') ? 'selected' : ''; ?>>同一カテゴリー</option>
		<option value="menu" <?php echo ($display_option === 'menu') ? 'selected' : ''; ?>>メニュー</option>
		<option value="fix_a" <?php echo ($display_option === 'fix_a') ? 'selected' : ''; ?>>固定Aタイプ</option>
		<option value="none" <?php echo ($display_option === 'none') ? 'selected' : ''; ?>>なし</option>
	</select>
	<?php
}
function save_custom_fields_meta($post_id)
{
	if (array_key_exists('side_menu_display', $_POST)) {
		update_post_meta(
			$post_id,
			'side_menu_display',
			$_POST['side_menu_display']
		);
	}
}
add_action('save_post', 'save_custom_fields_meta');
/**********************************************************************************/
//サイドメニューの表示設定
/**********************************************************************************/
function get_side_menu_display_option($post_id)
{
	$display_option = get_post_meta($post_id, 'side_menu_display', true);
	return $display_option;
}
function get_section_titles()
{
	global $post;
	$section_titles = array();
	if ($post) {
		$post_content = $post->post_content;
		$section_titles = array();
		preg_match_all('/<[^>]*\bclass\s*=\s*["\']([^"\']*?\bsectionTitle\b[^"\']*?)["\'][^>]*>(.*?)<\/[^>]*>/i', $post_content, $matches);
		if (!empty($matches[2])) {
			$section_titles = $matches[2];
		}
	}


	return $section_titles;
}
function display_custom_sidebar_content()
{
	global $post;
	$is_news_page = is_page('news') || (is_page() && $post->post_parent && get_post($post->post_parent)->post_name === 'news') || (is_category());

	if ($is_news_page) {
		// newsの子ページの場合の処理
	?>
		<aside class="newsSideMenu">
			<div class="newsSideMenu_container">
				<p class="newsSideMenu_title">Category</p>
				<ul class="newsSideMenu_list">
					<li class="newsSideMenu_item <?php if (is_page('news')) echo 'is-selected'; ?>">
						<a href="<?php echo esc_url(home_url('/news')); ?>">すべて</a>
					</li>
					<?php
					$categories = get_categories();
					foreach ($categories as $category) {
						$category_link = get_category_link($category->term_id);
					?>
						<li class="newsSideMenu_item <?php if (is_category($category->term_id)) echo 'is-selected'; ?>">
							<a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category->name); ?></a>
						</li>
					<?php
					}
					?>
				</ul>
			</div>
		</aside>

	<?php

	} elseif (is_single()) {
	?>
		<aside class="newsSideMenu">
			<div class="newsSideMenu_container">
				<p class="newsSideMenu_title">Category</p>
				<ul class="newsSideMenu_list">
					<li class="newsSideMenu_item <?php if (is_page('news')) echo 'is-selected'; ?>">
						<a href="<?php echo esc_url(home_url('/news')); ?>">すべて</a>
					</li>
					<?php
					$categories = get_categories();
					foreach ($categories as $category) {
						$category_link = get_category_link($category->term_id);
					?>
						<li class="newsSideMenu_item <?php if (is_category($category->term_id)) echo 'is-selected'; ?>">
							<a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category->name); ?></a>
						</li>
					<?php
					}
					?>
				</ul>
			</div>
		</aside>

		<?php
	} else {
		// 通常のページでの処理
		if ($post && is_singular('page')) {
			$display_option = get_side_menu_display_option($post->ID);
			if ($display_option === 'same_category') {
				// 同一カテゴリーのページの場合の処理
				$parent_id = wp_get_post_parent_id(get_the_ID());
				$current_page_id = get_the_ID();
				$sibling_pages_args = array(
					'post_type'      => 'page',
					'post_parent'    => $parent_id !== 0 ? $parent_id : get_the_ID(),
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'posts_per_page' => -1,
				);

				$sibling_pages = new WP_Query($sibling_pages_args);
				if ($sibling_pages->have_posts()) : ?>
					<aside class="sideMenu">
						<div class="sideMenu_container">
							<?php
							$parent_title = get_the_title($parent_id);
							?>
							<p class="sideMenu_title"><?php echo $parent_title; ?></p>
							<ul class="sideMenu_list">
								<?php while ($sibling_pages->have_posts()) : $sibling_pages->the_post(); ?>
									<li class="sideMenu_item <?php if (get_the_ID() === $current_page_id) echo "sideMenu_item-current"; ?>">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</li>
								<?php endwhile; ?>
							</ul>
						</div>
					</aside>
<?php
					wp_reset_postdata();
				endif;
			} elseif ($display_option === 'menu') {
				// メニューが選択されたページの場合の処理
				// コンテンツ内のsectionTitleに連番のIDを付与
				$parent_id = wp_get_post_parent_id(get_the_ID());
				$parent_title = get_the_title($parent_id);
				echo '
                <script>
                document.addEventListener(\'DOMContentLoaded\', function() {
                var sectionTitles = document.querySelectorAll(\'.sectionTitle\');
                sectionTitles.forEach(function(sectionTitle, index) {
                var jump_ID = \'jump_\' + (index + 1);
                sectionTitle.setAttribute(\'id\', jump_ID);
                });
                });
                </script>
                ';
				echo '<aside class="sideMenu">';
				echo '<div class="sideMenu_container">';
				echo '<p class="sideMenu_title">';
				echo $parent_title;
				echo '</p>';
				echo '<ul class="sideMenu_list">';

				$section_titles = get_section_titles();
				$index = 1;
				foreach ($section_titles as $title) {
					$jump_id = 'jump_' . $index;
					echo '<li class="sideMenu_item">';
					echo '<a href="#' . $jump_id . '">' . $title . '</a>';
					echo '</li>';
					$index++;
				}
				echo '</ul>';
				echo '</div>';
				echo '</aside>';
			} elseif ($display_option === 'fix_a') {
				// 固定タイプAが選択されたページの場合の処理
				echo '
                <aside class="sideMenu">
                <div class="sideMenu_container">
                <p class="sideMenu_title">CATEGORY</p>
                <ul class="sideMenu_list">
                <li class="sideMenu_item">
                <a href="http://fjisho-cofhks-demo11.local/service/planning_sales#gift/">ギフト物販・ノベルティ企画</a>
                </li>
                <li class="sideMenu_item">
                <a href="http://fjisho-cofhks-demo11.local/service/planning_sales#catalog/">お取り寄せグルメ</a>
                </li>
                <li class="sideMenu_item">
                <a href="http://fjisho-cofhks-demo11.local/service/planning_sales/askul/">アスクル</a>
                </li>
                <li class="sideMenu_item ">
                <a href="http://fjisho-cofhks-demo11.local/service/planning_sales/vending_machine/">自動販売機</a>
                </li>
                <li class="sideMenu_item">
                <a href="https://fujisho-gensen.co.jp/" target="_blank">ECビジネス</a>
                </li>
                <li class="sideMenu_item ">
                <a href="http://fjisho-cofhks-demo11.local/service/planning_sales/meat/">精肉店</a>
                </li>
                </ul>
                </div>
                </aside>';
			} else {
				// デフォルトの処理
			}
		}
	}
}
/**********************************************************************************/
//募集要項投稿用 固定カスタムフィールドボックス
/**********************************************************************************/
function add_jobDescription_fields()
{
	add_meta_box('jobDescription_setting', '募集要項', 'insert_jobDescription_fields', 'jobDescription', 'normal');
}
add_action('admin_menu', 'add_jobDescription_fields');
// カスタムフィールドの入力エリア
function insert_jobDescription_fields()
{
	global $post;
	echo '<style>#jobDescription_setting .inside{padding-top: 50px;background: linear-gradient(180deg, #E5F4FF, #F4F1E7);} textarea {color: blue;padding: 10px;width: 626px;box-sizing: content-box;border-radius: 0;margin: 0;}.jobDescription_table input {width: 622px;box-sizing: content-box;height: 100%;border-radius: 0;margin: 0;}.jobDescription_title {font-size: 16px;font-weight: normal;width: 160px;color: #263770;text-align: center;letter-spacing: 5px;vertical-align: middle;background: #F0F4F8;}.jobDescription_table {margin: auto;width: auto;margin-bottom: 70px;font-size: 18px;font-weight: normal;background: white;}.jobDescription_text {padding: 0px;}.jobDescription_item {border-top: 1px solid #BEBFBF;}.jobDescription_item:last-child {border-bottom: 1px solid #BEBFBF;}</style>';
	echo '<table class="jobDescription_table"><tbody><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">募 集 職 種</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_type_of_industry" placeholder="例)総合職">' . get_post_meta($post->ID, 'recruit_type_of_industry', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">必 要 資 格</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_required_credential" placeholder="例)不問">' . get_post_meta($post->ID, 'recruit_required_credential', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">募 集 学 科</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_department" placeholder="例)不問">' . get_post_meta($post->ID, 'recruit_department', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">採用予定人数</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_number_of_employees" placeholder="例)５名程度">' . get_post_meta($post->ID, 'recruit_number_of_employees', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">仕事の内容</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_job_details" placeholder="例)法⼈営業、管理事務、リテール">' . get_post_meta($post->ID, 'recruit_job_details', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">初　任　給</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_starting_salary" placeholder="例)202,200円〜209,200円">' . get_post_meta($post->ID, 'recruit_starting_salary', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">給　与</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recrui_salary" placeholder="例)202,200円〜209,200円">' . get_post_meta($post->ID, 'recrui_salary', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">諸 手 当</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_allowances" placeholder="例)通勤手当、扶養家族手当、超過勤務手当他">' . get_post_meta($post->ID, 'recruit_allowances', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">昇 　給</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_raise" placeholder="例)年1回(4月)">' . get_post_meta($post->ID, 'recruit_raise', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">賞　 与 </th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_bonus" placeholder="例)年2回(7月、12月)">' . get_post_meta($post->ID, 'recruit_bonus', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">休　日</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_holiday" placeholder="例)本社勤務・・・土曜、日曜、祝日他(年121日)店舗勤務・・・事業所カレンダー(年110⽇)">' . get_post_meta($post->ID, 'recruit_holiday', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">勤 務 時 間</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_wolking_hour" placeholder="例)本社勤務・・・8時30分～17時30分(休憩60分、1日8時間勤務)店舗勤務・・・事業所カレンダーに時差出勤(1日8時間勤務)">' . get_post_meta($post->ID, 'recruit_wolking_hour', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">勤 務 地</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_place" placeholder="例)各グループ会社(山陽小野田市)および県内の各直営店舗">' . get_post_meta($post->ID, 'recruit_place', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">社 会 保 険</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_insurance" placeholder="例)健康保険、厚生年金、雇用保険、労働保険">' . get_post_meta($post->ID, 'recruit_insurance', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">福 利 厚 生</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_welfare" placeholder="例)退職金制度、確定拠出年金、グループ共済会制度">' . get_post_meta($post->ID, 'recruit_welfare', true) . '</textarea></td></tr><tr class="jobDescription_item">';
	echo '<th class="jobDescription_title">定 年</th>';
	echo '<td class="jobDescription_text"><textarea rows="2" name="recruit_retirement" placeholder="例)65歳　再雇用制度あり">' . get_post_meta($post->ID, 'recruit_retirement', true) . '</textarea></td></tr></tbody></table>';
}
function save_jobDescription_fields($post_id)
{
	if (!empty($_POST['recruit_type_of_industry'])) {
		update_post_meta($post_id, 'recruit_type_of_industry', $_POST['recruit_type_of_industry']);
	} else {
		delete_post_meta($post_id, 'recruit_type_of_industry');
	}

	if (!empty($_POST['recruit_required_credential'])) {
		update_post_meta($post_id, 'recruit_required_credential', $_POST['recruit_required_credential']);
	} else {
		delete_post_meta($post_id, 'recruit_required_credential');
	}

	if (!empty($_POST['recruit_department'])) {
		update_post_meta($post_id, 'recruit_department', $_POST['recruit_department']);
	} else {
		delete_post_meta($post_id, 'recruit_department');
	}

	if (!empty($_POST['recruit_number_of_employees'])) {
		update_post_meta($post_id, 'recruit_number_of_employees', $_POST['recruit_number_of_employees']);
	} else {
		delete_post_meta($post_id, 'recruit_number_of_employees');
	}

	if (!empty($_POST['recruit_job_details'])) {
		update_post_meta($post_id, 'recruit_job_details', $_POST['recruit_job_details']);
	} else {
		delete_post_meta($post_id, 'recruit_job_details');
	}

	if (!empty($_POST['recruit_starting_salary'])) {
		update_post_meta($post_id, 'recruit_starting_salary', $_POST['recruit_starting_salary']);
	} else {
		delete_post_meta($post_id, 'recruit_starting_salary');
	}

	if (!empty($_POST['recrui_salary'])) {
		update_post_meta($post_id, 'recrui_salary', $_POST['recrui_salary']);
	} else {
		delete_post_meta($post_id, 'recrui_salary');
	}

	if (!empty($_POST['recruit_allowances'])) {
		update_post_meta($post_id, 'recruit_allowances', $_POST['recruit_allowances']);
	} else {
		delete_post_meta($post_id, 'recruit_allowances');
	}

	if (!empty($_POST['recruit_raise'])) {
		update_post_meta($post_id, 'recruit_raise', $_POST['recruit_raise']);
	} else {
		delete_post_meta($post_id, 'recruit_raise');
	}

	if (!empty($_POST['recruit_bonus'])) {
		update_post_meta($post_id, 'recruit_bonus', $_POST['recruit_bonus']);
	} else {
		delete_post_meta($post_id, 'recruit_bonus');
	}

	if (!empty($_POST['recruit_holiday'])) {
		update_post_meta($post_id, 'recruit_holiday', $_POST['recruit_holiday']);
	} else {
		delete_post_meta($post_id, 'recruit_holiday');
	}

	if (!empty($_POST['recruit_wolking_hour'])) {
		update_post_meta($post_id, 'recruit_wolking_hour', $_POST['recruit_wolking_hour']);
	} else {
		delete_post_meta($post_id, 'recruit_wolking_hour');
	}

	if (!empty($_POST['recruit_place'])) {
		update_post_meta($post_id, 'recruit_place', $_POST['recruit_place']);
	} else {
		delete_post_meta($post_id, 'recruit_place');
	}

	if (!empty($_POST['recruit_insurance'])) {
		update_post_meta($post_id, 'recruit_insurance', $_POST['recruit_insurance']);
	} else {
		delete_post_meta($post_id, 'recruit_insurance');
	}

	if (!empty($_POST['recruit_welfare'])) {
		update_post_meta($post_id, 'recruit_welfare', $_POST['recruit_welfare']);
	} else {
		delete_post_meta($post_id, 'recruit_welfare');
	}

	if (!empty($_POST['recruit_retirement'])) {
		update_post_meta($post_id, 'recruit_retirement', $_POST['recruit_retirement']);
	} else {
		delete_post_meta($post_id, 'recruit_retirement');
	}
}
add_action('save_post', 'save_jobDescription_fields');
/**********************************************************************************/
//募集要項【 jobDescription 】
/**********************************************************************************/
function jobDescription_init()
{
	$labels = array(
		'name' => _x('募集要項', 'post type general name'),
		'singular_name' => _x('募集要項', 'post type singular name'),
		'add_new' => _x('新規追加', 'jobDescription'),
		'add_new_item' => __('新しく募集要項を追加する'),
		'edit_item' => __('募集要項を編集'),
		'new_item' => __('新しい募集要項'),
		'view_item' => __('募集要項を見る'),
		'not_found' => __('募集要項はありません'),
		'not_found_in_trash' => __('ゴミ箱に募集要項はありません'),
	);
	$args = array(
		'labels' => $labels,
		'description' => '募集要項の一覧ページです。',
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite_withfront' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'menu_position' => 5,
		'show_in_rest' => true,
		'supports' => array('title', 'revisions'),
		'has_archive' => true,
	);
	register_post_type('jobDescription', $args);
}

add_action('init', 'jobDescription_init');
