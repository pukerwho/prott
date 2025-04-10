<div>
  <div class="flex items-center justify-between mb-4">
    <div class="flex items-center space-x-4">
      <div>
        <input id="search_websites_box" placeholder="Пошук" class="text-lg border border-gray-300 rounded-lg px-2 py-1" />
      </div>
      <div>
        <div class="flex items-center space-x-3">
          <span class="text-black font-semibold">Порівняння</span>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" value="" class="sr-only peer" checked>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-transparent rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
          </label>
        </div>
      </div>
    </div>
    <div class="bg-gray-200 rounded text-center px-4 py-2">
      Експорт
    </div>
  </div>
  <!-- Заголовки -->
  <div id="header-row" class="flex bg-[#eeeeee] font-semibold text-sm text-gray-700 px-4 py-2 border-b sticky top-0 z-30">
    <div class="w-8"><div class="w-[20px] flex justify-center">#</div></div>
    <div class="w-48">URL</div>
    <div class="w-24 cursor-pointer" data-sort="orders">Orders <span class="sort-direction"></span></div>
    <div class="w-24 cursor-pointer" data-sort="dr">DR <span class="sort-direction"></span></div>
    <div class="w-24 cursor-pointer" data-sort="kw">KW <span class="sort-direction"></span></div>
    <div class="w-24 cursor-pointer" data-sort="tf">TF <span class="sort-direction"></span></div>
    <div class="w-24 cursor-pointer" data-sort="cf">CF <span class="sort-direction"></span></div>
    <div class="w-28 cursor-pointer" data-sort="ga">GA, 30d <span class="sort-direction"></span></div>
    <div class="w-28 cursor-pointer" data-sort="gsc">GSC, 7d <span class="sort-direction"></span></div>
    <div class="w-24 cursor-pointer" data-sort="clbrrating">Рейтинг <span class="sort-direction"></span></div>
    <div class="w-24 cursor-pointer" data-sort="clbrposition">Позиція <span class="sort-direction"></span></div>
  </div>
  <!-- Цикл -->
  <div id="mainsite-table" class="w-full overflow-x-auto">
    <?php 
      // 1. Отримуємо всі пости без сортування
      $main_sites_query = new WP_Query( array( 
        'post_type' => 'websites', 
        'posts_per_page' => -1,
      ) );

      $main_sites = $main_sites_query->posts;

      // 2. Сортуємо за останнім значенням у _crb_websites_orders
      usort($main_sites, function($a, $b) {
          $a_orders = get_post_meta($a->ID, '_crb_websites_orders', true);
          $b_orders = get_post_meta($b->ID, '_crb_websites_orders', true);

          $a_last = intval(array_slice(explode(',', $a_orders), -1)[0]);
          $b_last = intval(array_slice(explode(',', $b_orders), -1)[0]);

          return $b_last <=> $a_last; // по спаданню
      });
      ?>
      <?php 
      // Побудова рейтингу для визначення зміни позиції
      $position_data = [];
      foreach ($main_sites as $site) {
        $orders_raw = get_post_meta($site->ID, '_crb_websites_orders', true);
        $orders_array = array_map('intval', explode(',', $orders_raw));
        $last = end($orders_array);
        $prev = prev($orders_array);
        $position_data[] = [
          'id' => $site->ID,
          'current' => $last,
          'previous' => $prev,
        ];
      }
      $rank_now = $rank_prev = $position_data;
      usort($rank_now, fn($a, $b) => $b['current'] <=> $a['current']);
      usort($rank_prev, fn($a, $b) => $b['previous'] <=> $a['previous']);
      $positions_map = [];
      foreach ($position_data as $item) {
        $id = $item['id'];
        $now = array_search($id, array_column($rank_now, 'id')) + 1;
        $prev = array_search($id, array_column($rank_prev, 'id')) + 1;
        $positions_map[$id] = $prev - $now;
      }
      ?>

      <?php foreach ($main_sites as $post) : setup_postdata($post); ?>
      <!-- Рядок -->
      <?php 
        $current_id = get_the_ID(); 
        $position_change = $positions_map[$current_id] ?? 0;
      ?>
      <div class="website-tr flex items-center border-b px-4 py-2 hover:bg-gray-50 text-sm" data-metadata='{"name": "website","category": "site","tag": ["<?php echo get_the_title(); ?>"]}'>

        <div class="w-8"> 
          <div class="row-index w-[20px] h-[20px] flex items-center justify-center text-center text-white text-xs rounded <?php echo carbon_get_the_post_meta('crb_websites_gruop'); ?>"></div>
        </div>
        <div class="w-48 truncate text-blue-600 flex items-center gap-1">
          <?php the_title(); ?>
          <?php if ($position_change > 0): ?>
            <span class="text-green-600 text-xs position_change">+<?= $position_change ?> 🔼</span>
          <?php elseif ($position_change < 0): ?>
            <span class="text-red-600 text-xs position_change"><?= $position_change ?> 🔽</span>
          <?php endif; ?>
        </div>
        <!-- Замовлень --> 
        <div class="w-24 orders">
          <?php 
            $get_orders = carbon_get_the_post_meta('crb_websites_orders');
            $orders_array = explode(",", $get_orders);
            $orders_array = array_reverse($orders_array);
            $diff_order = diffValue($orders_array[0], $orders_array[1]);
          ?>
          <div>
            <!-- value -->
            <span class="sort-value cursor-pointer value-modal-js" data-modal-id="order-<?php echo $current_id; ?>" data-value-array="<?php echo $get_orders; ?>" data-value-label="Замовлення - <?php the_title(); ?>" data-chart-type="bar">
              <?php echo $orders_array[0]; ?>
            </span> 
            <!-- diff -->
            <span class="<?php echo $diff_order['diff_order_class']; ?> value-diff inline-block rounded ml-1">
              <?php echo $diff_order['diff_order_sign']; echo $diff_order['diff_order']; ?>
            </span>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="order-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="order-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END Замовлення -->

        <!-- DR -->
        <div class="w-24 dr">
          <?php 
            $get_dr = carbon_get_the_post_meta('crb_websites_dr');
            $dr_array = explode(",", $get_dr);
            $dr_array = array_reverse($dr_array);
            $diff_dr = diffValue($dr_array[0], $dr_array[1]);
          ?>
          <div>
            <div>
              <!-- value -->
              <span class="sort-value cursor-pointer value-modal-js" data-modal-id="dr-<?php echo $current_id; ?>" data-value-array="<?php echo $get_dr; ?>" data-value-label="DR - <?php the_title(); ?>" data-chart-type="line">
                <?php echo $dr_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_dr['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_dr['diff_order_sign']; echo $diff_dr['diff_order']; ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="dr-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="dr-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END DR -->

        <!-- KEYWORDS -->
        <div class="w-24 kw">
          <?php 
            $get_keywords = carbon_get_the_post_meta('crb_websites_keywords');
            $keywords_array = explode(",", $get_keywords);
            $keywords_array = array_reverse($keywords_array);
            $diff_keywords = diffValue($keywords_array[0], $keywords_array[1]);
          ?>
          <div>
            <div>
              <!-- value -->
              <span class="sort-value value-modal-js" data-modal-id="keywords-<?php echo $current_id; ?>" data-value-array="<?php echo $get_keywords; ?>" data-value-label="Keywords - <?php the_title(); ?>" data-chart-type="line">
                <?php echo $keywords_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_keywords['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_keywords['diff_order_sign']; echo $diff_keywords['diff_order']; ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="keywords-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="keywords-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END KEYWORDS -->

        <!-- TF -->
        <div class="w-24 tf">
          <?php 
            $get_tf = carbon_get_the_post_meta('crb_websites_tf');
            $tf_array = explode(",", $get_tf);
            $tf_array = array_reverse($tf_array);
            $diff_tf = diffValue($tf_array[0], $tf_array[1]);
          ?>
          <div>
            <div>
              <!-- value -->
              <span class="sort-value cursor-pointer value-modal-js" data-modal-id="TF-<?php echo $current_id; ?>" data-value-array="<?php echo $get_tf; ?>" data-value-label="TF - <?php the_title(); ?>" data-chart-type="line">
                <?php echo $tf_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_tf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_tf['diff_order_sign']; echo $diff_tf['diff_order']; ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="TF-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="TF-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END TF -->

        <!-- CF -->
        <div class="w-24 cf">
          <?php 
            $get_cf = carbon_get_the_post_meta('crb_websites_cf');
            $cf_array = explode(",", $get_cf);
            $cf_array = array_reverse($cf_array);
            $diff_cf = diffValue($cf_array[0], $cf_array[1]);
          ?>
          <div>
            <div>
              <!-- value -->
              <span class="sort-value cursor-pointer value-modal-js" data-modal-id="CF-<?php echo $current_id; ?>" data-value-array="<?php echo $get_cf; ?>" data-value-label="CF - <?php the_title(); ?>" data-chart-type="line">
                <?php echo $cf_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_cf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_cf['diff_order_sign']; echo $diff_cf['diff_order']; ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6" data-modal-id="CF-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="CF-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END CF -->

        <!-- GA -->
        <div class="w-28 ga">
          <?php 
            $get_ga = carbon_get_the_post_meta('crb_websites_ga');
            $ga_array = explode(",", $get_ga);
            $ga_array = array_reverse($ga_array);
            $diff_ga = diffValue($ga_array[0], $ga_array[1]);

          ?>
          <div>
            <div>
              <!-- value -->
              <span class="cursor-pointer value-modal-js" data-modal-id="GA-<?php echo $current_id; ?>" data-value-array="<?php echo $get_ga; ?>" data-value-label="GA - <?php the_title(); ?>" data-chart-type="line">
                <?php 
                $current_ga = $ga_array[0]; 
                if ($current_ga > 1000) {
                  echo $current_ga/1000; echo 'K';
                } else {
                  echo $current_ga;
                } ?>
              </span> 
              <span class="sort-value hidden"><?php echo $current_ga; ?></span>
              <!-- diff -->
              <span class="<?php echo $diff_ga['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php 
                  echo $diff_ga['diff_order_sign']; 
                  $riznitsa_ga = $diff_ga['diff_order'];
                  if ($riznitsa_ga > 1000) {
                    echo $riznitsa_ga/1000; echo 'K';
                  } else {
                    echo $riznitsa_ga; 
                  }
                ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6" data-modal-id="GA-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="GA-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END GA -->

        <!-- GSC -->
        <div class="w-28 gsc">
          <?php 
            $get_gsc = carbon_get_the_post_meta('crb_websites_gsc');
            $gsc_array = explode(",", $get_gsc);
            $gsc_array = array_reverse($gsc_array);
            $diff_gsc = diffValue($gsc_array[0], $gsc_array[1]);
          ?>
          <div>
            <div>
              <!-- value -->
              <span class="sort-value cursor-pointer value-modal-js" data-modal-id="GSC-<?php echo $current_id; ?>" data-value-array="<?php echo $get_gsc; ?>" data-value-label="GSC - <?php the_title(); ?>" data-chart-type="line">
                <?php echo $gsc_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_gsc['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_gsc['diff_order_sign']; echo $diff_gsc['diff_order']; ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6" data-modal-id="GSC-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="GSC-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END GSC -->

        <!-- RATING -->
        <div class="w-24 clbrrating">
          <?php 
            $get_colbr_rating = carbon_get_the_post_meta('crb_websites_colbr_rating');
            $colbr_rating_array = explode(",", $get_colbr_rating);
            $colbr_rating_array = array_reverse($colbr_rating_array);
            $diff_colbr_rating = diffValue($colbr_rating_array[0], $colbr_rating_array[1]);
          ?>
          <div>
            <div>
              <!-- value -->
              <span class="sort-value cursor-pointer value-modal-js" data-modal-id="colbr_rating-<?php echo $current_id; ?>" data-value-array="<?php echo $get_colbr_rating; ?>" data-value-label="Рейтинг - <?php the_title(); ?>" data-chart-type="line">
                <?php echo $colbr_rating_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_colbr_rating['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_colbr_rating['diff_order_sign']; echo $diff_colbr_rating['diff_order']; ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="colbr_rating-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="colbr_rating-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END RATING -->

        <!-- POSITION -->
        <div class="w-24 clbrposition">
          <?php 
            $get_colbr_position = carbon_get_the_post_meta('crb_websites_colbr_position');
            $colbr_position_array = explode(",", $get_colbr_position);
            $colbr_position_array = array_reverse($colbr_position_array);
            $diff_colbr_position = diffValuePosition($colbr_position_array[0], $colbr_position_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value cursor-pointer value-modal-js" data-modal-id="colbr_position-<?php echo $current_id; ?>" data-value-array="<?php echo $get_colbr_position; ?>" data-value-label="Позиції - <?php the_title(); ?>" data-chart-type="line">
                <?php echo $colbr_position_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_colbr_position['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_colbr_position['diff_order_sign']; echo $diff_colbr_position['diff_order']; ?>
              </span>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="colbr_position-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="colbr_position-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- END POSITION -->
      </div>
    <?php endforeach; wp_reset_postdata(); ?>
  </div>
</div>