<?php

/**
 * Template Name: 募集要項ページテンプレ
 */
?>
<?php get_header(); ?>
<main <?php body_class(); ?>>
  <article class="page_recruit">
    <?php include('siteHeader.php'); ?>
    <div class="siteLayout siteLayout-single">
      <div class="siteContent">
        <style>
          .jobDescription_content {
            display: none;
          }
        </style>
        <section>
          <div class="jobDescription_tabs">
            <button class="is-selected" onclick="showItems('jobDescription_new')">新卒採用</button>
            <button onclick="showItems('jobDescription_mid')">中途採用</button>
          </div>

          <div class="jobDescription">
            <?php
            $jobDescriptionn_args = array(
              'post_type' => 'jobDescription',
              'posts_per_page' => 2,
            );
            $jobDescription_post_query = new WP_Query($jobDescriptionn_args);
            if ($jobDescription_post_query->have_posts()) :
              while ($jobDescription_post_query->have_posts()) : $jobDescription_post_query->the_post();
                $recruit_type_of_industry = get_post_meta($post->ID, 'recruit_type_of_industry', true);
                $recruit_required_credential = get_post_meta($post->ID, 'recruit_required_credential', true);
                $recruit_department = get_post_meta($post->ID, 'recruit_department', true);
                $recruit_number_of_employees = get_post_meta($post->ID, 'recruit_number_of_employees', true);
                $recruit_job_details = get_post_meta($post->ID, 'recruit_job_details', true);
                $recruit_starting_salary = get_post_meta($post->ID, 'recruit_starting_salary', true);
                $recruit_salary = get_post_meta($post->ID, 'recruit_salary', true);
                $recruit_allowances = get_post_meta($post->ID, 'recruit_allowances', true);
                $recruit_raise = get_post_meta($post->ID, 'recruit_raise', true);
                $recruit_bonus = get_post_meta($post->ID, 'recruit_bonus', true);
                $recruit_holiday = get_post_meta($post->ID, 'recruit_holiday', true);
                $recruit_wolking_hour = get_post_meta($post->ID, 'recruit_wolking_hour', true);
                $recruit_place = get_post_meta($post->ID, 'recruit_place', true);
                $recruit_insurance = get_post_meta($post->ID, 'recruit_insurance', true);
                $recruit_welfare = get_post_meta($post->ID, 'recruit_welfare', true);
                $recruit_retirement = get_post_meta($post->ID, 'recruit_retirement', true);
            ?>
                <div id="jobDescription_<?php echo ($post->ID === 750) ? 'mid' : 'new'; ?>" class="jobDescription_content">
                  <table class="jobDescription_table">
                    <?php if (!empty($recruit_type_of_industry)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">募集職種</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_type_of_industry); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_required_credential)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">必要資格</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_required_credential); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_department)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">募集学科</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_department); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_number_of_employees)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">採用予定人数</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_number_of_employees); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_job_details)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">仕事の内容</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_job_details); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_starting_salary)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">初任給</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_starting_salary); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_salary)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">給与</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_salary); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_allowances)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">諸手当</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_allowances); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_raise)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">昇給</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_raise); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_bonus)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">賞与</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_bonus); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_holiday)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">休日</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_holiday); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_wolking_hour)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">勤務時間</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_wolking_hour); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_place)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">勤務地</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_place); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_insurance)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">社会保険</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_insurance); ?></td>
                      </tr>
                    <?php endif; ?>

                    <?php if (!empty($recruit_welfare)) : ?>
                      <tr class="jobDescription_item">
                        <th class="jobDescription_title">福利厚生</th>
                        <td class="jobDescription_text"><?php echo nl2br($recruit_welfare); ?></td>
                      </tr>
                    <?php endif; ?>

                  </table>
                </div>
            <?php
              endwhile;
              wp_reset_postdata();
            else :
            endif;
            ?>
          </div>
        </section>

        <div class="btn_entry mb-100">
          <a href="https://job.mynavi.jp/25/pc/search/corp222292/outline.html" target="_blank">
            <div class="btn_entry_text">
              <div class="btn_entry_icon"><img src="/wp-content/themes/template/svg/icon_entry.svg" alt=""></div>
              <p>エントリーする</p>
            </div>
            <div class="btn_entry_img">
              <img src="/wp-content/uploads/z-26.png" alt="">
            </div>
          </a>
        </div>

        <div class="insta_btn"><a href="https://www.instagram.com/fghd_recruit/" target="_blank"></a></div>
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            showItems('jobDescription_new');
          });

          function showItems(itemId) {
            var items = document.querySelectorAll('.jobDescription_content');
            items.forEach(function(item) {
              item.style.display = 'none';
            });
            var selectedItem = document.getElementById(itemId);
            if (selectedItem) {
              selectedItem.style.display = 'block';
            }
          }

          function toggleSelected(button, itemId) {
            var buttons = document.querySelectorAll('.jobDescription_tabs button');
            buttons.forEach(function(btn) {
              btn.classList.toggle('is-selected');
            });
            showItems(itemId);
          }

          function selectButton(button) {
            var buttons = document.querySelectorAll('.jobDescription_tabs button');
            buttons.forEach(function(btn) {
              btn.classList.remove('is-selected');
            });

            button.classList.add('is-selected');
          }

          var buttons = document.querySelectorAll('.jobDescription_tabs button');
          buttons.forEach(function(button) {
            button.addEventListener('click', function() {
              selectButton(button);
            });
          });
        </script>
      </div>
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