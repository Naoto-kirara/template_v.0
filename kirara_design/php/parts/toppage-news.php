<?php

/**
 * Template Name: トップページ用news一覧
 */
?>
<div class="newstag">
  <ul class="newstag_list">
    <li class="newstag_item">
      <a href="<?php echo esc_url(home_url('/news')); ?>">すべて</a>
    </li>
    <?php
    $args = array(
      'post_type'      => 'post',
      'orderby'        => 'date',
      'order'          => 'DESC',
    );
    $query = new WP_Query($args);
    $categories = get_categories();
    foreach ($categories as $category) {
      $category_link = get_category_link($category->term_id);
    ?>
      <li class="newstag_item <?php if (is_category($category->term_id)) echo 'is-selected'; ?>">
        <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category->name); ?></a>
      </li>
    <?php
    }
    ?>
  </ul>
</div>
<div class="newsPost">
  <ul class="newsPost_list">
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
      'post_type'      => 'post',
      'posts_per_page' => 5,
      'orderby'        => 'date',
      'order'          => 'DESC',
      'paged'          => $paged,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
    ?>

        <li class="newsPost_item">
          <time class="newsPost_time"><?php the_time('Y.m.d'); ?></time>
          <span class="newsPost_cat"><?php the_category(', '); ?></span>
          <p class="newsPost_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
        </li>

    <?php
      }
    } else {
      echo '投稿がありません。';
    }
    wp_reset_postdata();
    ?>
  </ul>
</div>