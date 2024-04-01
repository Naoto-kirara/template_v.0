<?php

/**
 * Template Name: サイトマップテンプレ
 */
?>
<?php get_header(); ?>
<main <?PHP body_class(); ?>>
  <article>
    <?php include('siteHeader.php'); ?>
    <div class="siteLayout siteLayout-single">
      <div class="siteContent">
        <div class="sitemap">
          <ul class="sitemap_list">
            <?php
            $args = array(
              'post_type'      => 'page',
              'posts_per_page' => -1,
              'orderby'        => 'menu_order',
              'order'          => 'ASC',
              'post_parent'    => 0,
              'post__not_in'   => array('50', '48', '42'),
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
              while ($query->have_posts()) : $query->the_post();
            ?>
                <li class="sitemap_item">
                  <?php if (get_post_field('post_name') == 'news') : ?>
                    <?php
                    $categories = get_categories();
                    if ($categories) :
                    ?>
                      <ul class="sitemap_parentBox">
                        <?php foreach ($categories as $category) : ?>
                          <li class="sitemap_child">
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="sitemap_link"><?php echo esc_html($category->name); ?></a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  <?php else : ?>
                    <a href="<?php the_permalink(); ?>" class="sitemap_link sitemap_parent"><?php the_title(); ?></a>
                    <?php
                    $child_args = array(
                      'post_type'      => 'page',
                      'posts_per_page' => -1,
                      'orderby'        => 'menu_order',
                      'order'          => 'ASC',
                      'post_parent'    => get_the_ID(),
                      'post__not_in'   => array('570', '606'),
                    );
                    $child_query = new WP_Query($child_args);
                    if ($child_query->have_posts()) :
                    ?>
                      <ul class="sitemap_parentBox">
                        <?php while ($child_query->have_posts()) : $child_query->the_post(); ?>
                          <li class="sitemap_child"><a href="<?php the_permalink(); ?>" class="sitemap_link"><?php the_title(); ?></a></li>
                        <?php endwhile; ?>
                      </ul>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                  <?php endif; ?>
                </li>
            <?php
              endwhile;
              wp_reset_postdata();
            else :
            endif;
            ?>
          </ul>
          <hr style="color:#969696;margin:50px 0;">
          <ul class="sitemap_list sitemap_list-hr">
            <li class="sitemap_item">
              <a href="/contact/" class="sitemap_link sitemap_parent">お問い合わせ</a>
            </li>
            <li class="sitemap_item">
              <a href="/privacy/" class="sitemap_link sitemap_parent">個人情報保護方針</a>
            </li>
            <li class="sitemap_item">
              <a href="/sitemap/" class="sitemap_link sitemap_parent">サイトマップ</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </article>
  <?php
  include 'parts/contact.php';
  ?>

</main>
<?php get_footer(); ?>