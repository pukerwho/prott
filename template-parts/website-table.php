<table id="mainsite-table" class="w-full table-fixed">
  <thead class="text-sm border-b border-gray-200 text-gray-600">
    <tr>
      <th class="w-[175px] text-left whitespace-nowrap py-2">
        <div class="text-left font-bold"><?php _e("Сайт", "treba-wp"); ?></div>
      </th>
      <th class="text-left whitespace-nowrap py-2 cursor-pointer sort-table-js" data-sort-id="1">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("Замовлень", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-left whitespace-nowrap py-2 cursor-pointer sort-table-js" data-sort-id="2">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("DR", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-left whitespace-nowrap py-2 cursor-pointer sort-table-js" data-sort-id="3">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("Keywords", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-left whitespace-nowrap py-2 cursor-pointer sort-table-js" data-sort-id="4">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("TF", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-left whitespace-nowrap py-2 cursor-pointer sort-table-js" data-sort-id="5">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("CF", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-center whitespace-nowrap py-2 cursor-pointer sort-table-js" data-sort-id="6">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("GA, 30 days", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-center whitespace-nowrap py-2 cursor-pointer sort-table-js" data-sort-id="7">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("GSC, 7 days", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-center whitespace-nowrap py-2">
        <div class="text-left font-bold"><?php _e("Посилання", "treba-wp"); ?></div>
      </th>
    </tr>
  </thead>
  <tbody class="text-sm">
    <?php 
      $main_sites = new WP_Query( array( 
        'post_type' => 'websites', 
        'posts_per_page' => -1,
      ) );
      if ($main_sites->have_posts()) : while ($main_sites->have_posts()) : $main_sites->the_post(); 
    ?>
      <?php $current_id = get_the_ID(); ?>
      <tr class="border-b border-gray-200 last:border-transparent">
        <td class="whitespace-nowrap py-2">
          <div class="chart-week-<?php echo $current_id; ?>" data-week-array="<?php echo carbon_get_the_post_meta('crb_websites_week'); ?>"></div>
          <div class="flex items-center">
            <div class="hidden cursor-pointer mr-1 edit-modal-js" data-modal-id="edit-<?php echo $current_id; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
            </div>
            <div><?php the_title(); ?></div>
          </div>
          <div class="edit-modal px-8 py-6 " data-modal-id="edit-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-max-[640px] bg-white min-h-full rounded-lg px-6 py-4">
                <div class="text-xl mb-4">Оновлення показників</div>
                <div class="mb-2">
                  <div class="font-bold">Замовлень:</div>
                  <input type="text" class="edit-meta w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-crb-value="_crb_websites_orders">
                </div>
                <div class="mb-2">
                  <div class="font-bold">DR:</div>
                  <input type="text" class="edit-meta w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-crb-value="_crb_websites_dr">
                </div>
                <div class="mb-2">
                  <div class="font-bold">Keywords:</div>
                  <input type="text" class="edit-meta w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-crb-value="_crb_websites_keywords">
                </div>
                <div class="mb-2">
                  <div class="font-bold">TF:</div>
                  <input type="text" class="edit-meta w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-crb-value="_crb_websites_tf">
                </div>
                <div class="mb-2">
                  <div class="font-bold">CF:</div>
                  <input type="text" class="edit-meta w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-crb-value="_crb_websites_cf">
                </div>
                <div class="mb-2">
                  <div class="font-bold">GA:</div>
                  <input type="text" class="edit-meta w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-crb-value="_crb_websites_ga">
                </div>
                <div class="mb-2">
                  <div class="font-bold">GSC:</div>
                  <input type="text" class="edit-meta w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-crb-value="_crb_websites_gsc">
                </div>
                <div class="edit-send-js bg-blue-500 text-white text-center rounded cursor-pointer px-4 py-2" data-modal-id="edit-<?php echo $current_id; ?>" data-post-id="<?php echo $current_id; ?>">Відправити</div>
              </div>
            </div>
          </div>
        </td>
        <!-- Замовлення -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_orders = carbon_get_the_post_meta('crb_websites_orders');
            $orders_array = explode(",", $get_orders);
            $orders_array = array_reverse($orders_array);
            $diff_order = diffValue($orders_array[0], $orders_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value">
                <?php echo $orders_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_order['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_order['diff_order_sign']; echo $diff_order['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-modal-id="order-<?php echo $current_id; ?>" data-value-array="<?php echo $get_orders; ?>" data-value-label="Замовлення - <?php the_title(); ?>" data-chart-type="bar">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="order-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="order-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END Замовлення -->

        <!-- DR -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_dr = carbon_get_the_post_meta('crb_websites_dr');
            $dr_array = explode(",", $get_dr);
            $dr_array = array_reverse($dr_array);
            $diff_dr = diffValue($dr_array[0], $dr_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value">
                <?php echo $dr_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_dr['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_dr['diff_order_sign']; echo $diff_dr['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-modal-id="dr-<?php echo $current_id; ?>" data-value-array="<?php echo $get_dr; ?>" data-value-label="DR - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="dr-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="dr-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END DR -->

        <!-- Keywords -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_keywords = carbon_get_the_post_meta('crb_websites_keywords');
            $keywords_array = explode(",", $get_keywords);
            $keywords_array = array_reverse($keywords_array);
            $diff_keywords = diffValue($keywords_array[0], $keywords_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value">
                <?php echo $keywords_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_keywords['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_keywords['diff_order_sign']; echo $diff_keywords['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-modal-id="keywords-<?php echo $current_id; ?>" data-value-array="<?php echo $get_keywords; ?>" data-value-label="Keywords - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="keywords-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="keywords-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END Keywords -->

        <!-- TF -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_tf = carbon_get_the_post_meta('crb_websites_tf');
            $tf_array = explode(",", $get_tf);
            $tf_array = array_reverse($tf_array);
            $diff_tf = diffValue($tf_array[0], $tf_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value">
                <?php echo $tf_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_tf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_tf['diff_order_sign']; echo $diff_tf['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-modal-id="TF-<?php echo $current_id; ?>" data-value-array="<?php echo $get_tf; ?>" data-value-label="TF - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="TF-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="TF-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END TF -->

        <!-- CF -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_cf = carbon_get_the_post_meta('crb_websites_cf');
            $cf_array = explode(",", $get_cf);
            $cf_array = array_reverse($cf_array);
            $diff_cf = diffValue($cf_array[0], $cf_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value">
                <?php echo $cf_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_cf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_cf['diff_order_sign']; echo $diff_cf['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-modal-id="CF-<?php echo $current_id; ?>" data-value-array="<?php echo $get_cf; ?>" data-value-label="CF - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6" data-modal-id="CF-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="CF-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END CF -->

        <!-- GA -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_ga = carbon_get_the_post_meta('crb_websites_ga');
            $ga_array = explode(",", $get_ga);
            $ga_array = array_reverse($ga_array);
            $diff_ga = diffValue($ga_array[0], $ga_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value">
                <?php echo $ga_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_ga['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_ga['diff_order_sign']; echo $diff_ga['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-modal-id="GA-<?php echo $current_id; ?>" data-value-array="<?php echo $get_ga; ?>" data-value-label="GA - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6" data-modal-id="GA-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="GA-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END GA -->

        <!-- GSC -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_gsc = carbon_get_the_post_meta('crb_websites_gsc');
            $gsc_array = explode(",", $get_gsc);
            $gsc_array = array_reverse($gsc_array);
            $diff_gsc = diffValue($gsc_array[0], $gsc_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value">
                <?php echo $gsc_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_gsc['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_gsc['diff_order_sign']; echo $diff_gsc['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-modal-id="GSC-<?php echo $current_id; ?>" data-value-array="<?php echo $get_gsc; ?>" data-value-label="GSC - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6" data-modal-id="GSC-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="GSC-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END GSC -->

        <td class="whitespace-nowrap py-2">
          <div class="text-blue-500 cursor-pointer detail-click-js" data-detail-id="Website-Drops-<?php echo $current_id; ?>">Детальніше</div>
          <div class="detail-modal px-8 py-6" data-detail-modal="Website-Drops-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box max-w-[640px] bg-white min-h-full rounded-lg px-6 py-4">
                <table class="w-full table-fixed">
                  <thead class="text-sm border-b border-gray-200 text-gray-600">
                    <tr>
                      <th class="w-[175px] text-left whitespace-nowrap py-2">
                        <div class="text-left font-bold"><?php _e("Сайт", "treba-wp"); ?></div>
                      </th>
                      <th class="text-left whitespace-nowrap py-2 cursor-pointer">
                        <div class="text-left font-bold"><?php _e("DR", "treba-wp"); ?></div>
                      </th>
                      <th class="text-center whitespace-nowrap py-2 cursor-pointer">
                        <div class="text-left font-bold"><?php _e("TF", "treba-wp"); ?></div>
                      </th>
                      <th class="text-center whitespace-nowrap py-2 cursor-pointer">
                        <div class="text-left font-bold"><?php _e("CF", "treba-wp"); ?></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="text-sm">
                    <tr class="bg-gray-100">
                      <td class="whitespace-nowrap py-2"><?php the_title(); ?></td>
                      <td class="whitespace-nowrap py-2">
                        <div>
                          <!-- value -->
                          <span class="sort-value">
                            <?php echo $dr_array[0]; ?>
                          </span> 
                          <!-- diff -->
                          <span class="<?php echo $diff_dr['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                            <?php echo $diff_dr['diff_order_sign']; echo $diff_dr['diff_order']; ?>
                          </span>
                        </div>
                      </td>
                      <td class="whitespace-nowrap py-2">
                        <div>
                          <!-- value -->
                          <span class="sort-value">
                            <?php echo $tf_array[0]; ?>
                          </span> 
                          <!-- diff -->
                          <span class="<?php echo $diff_tf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                            <?php echo $diff_tf['diff_order_sign']; echo $diff_tf['diff_order']; ?>
                          </span>
                        </div>
                      </td>
                      <td class="whitespace-nowrap py-2">
                        <div>
                          <!-- value -->
                          <span class="sort-value">
                            <?php echo $cf_array[0]; ?>
                          </span> 
                          <!-- diff -->
                          <span class="<?php echo $diff_cf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                            <?php echo $diff_cf['diff_order_sign']; echo $diff_cf['diff_order']; ?>
                          </span>
                        </div>
                      </td>
                    </tr>
                    <?php 
                      $drops = new WP_Query( array( 
                        'post_type' => 'drops', 
                        'posts_per_page' => -1,

                        'meta_query' => array(
                          array(
                            'key'     => '_crb_drops_websites',
                            'value'   => 'post:websites:'.$current_id,
                            'compare' => 'IN', 
                          )
                        )
                      ) );
                      if ($drops->have_posts()) : while ($drops->have_posts()) : $drops->the_post(); 
                    ?>
                    <tr>
                      <td class="whitespace-nowrap py-2"><?php the_title(); ?></td>
                      <td class="whitespace-nowrap py-2">
                        <?php 
                          $get_drop_website_dr = carbon_get_the_post_meta('crb_drops_dr');
                          $drop_website_array_dr = explode(",", $get_drop_website_dr);
                          $drop_website_array_dr = array_reverse($drop_website_array_dr);
                          $diff_drop_website_dr = diffValue($drop_website_array_dr[0], $drop_website_array_dr[1]);
                        ?>
                        <div class="flex items-center">
                          <div>
                            <!-- value -->
                            <span class="sort-value-drop">
                              <?php echo $drop_website_array_dr[0]; ?>
                            </span> 
                            <!-- diff -->
                            <span class="<?php echo $diff_drop_website_dr['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                              <?php echo $diff_drop_website_dr['diff_order_sign']; echo $diff_drop_website_dr['diff_order']; ?>
                            </span>
                          </div>
                        </div>
                      </td>
                      <td class="whitespace-nowrap py-2">
                        <?php 
                          $get_drop_website_tf = carbon_get_the_post_meta('crb_drops_tf');
                          $drop_website_array_tf = explode(",", $get_drop_website_tf);
                          $drop_website_array_tf = array_reverse($drop_website_array_tf);
                          $diff_drop_website_tf = diffValue($drop_website_array_tf[0], $drop_website_array_tf[1]);
                        ?>
                        <div class="flex items-center">
                          <div>
                            <!-- value -->
                            <span class="sort-value-drop">
                              <?php echo $drop_website_array_tf[0]; ?>
                            </span> 
                            <!-- diff -->
                            <span class="<?php echo $diff_drop_website_tf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                              <?php echo $diff_drop_website_tf['diff_order_sign']; echo $diff_drop_website_tf['diff_order']; ?>
                            </span>
                          </div>
                        </div>
                      </td>
                      <td class="whitespace-nowrap py-2">
                        <?php 
                          $get_drop_website_cf = carbon_get_the_post_meta('crb_drops_cf');
                          $drop_website_array_cf = explode(",", $get_drop_website_cf);
                          $drop_website_array_cf = array_reverse($drop_website_array_cf);
                          $diff_drop_website_cf = diffValue($drop_website_array_cf[0], $drop_website_array_cf[1]);
                        ?>
                        <div class="flex items-center">
                          <div>
                            <!-- value -->
                            <span class="sort-value-drop">
                              <?php echo $drop_website_array_cf[0]; ?>
                            </span> 
                            <!-- diff -->
                            <span class="<?php echo $diff_drop_website_cf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                              <?php echo $diff_drop_website_cf['diff_order_sign']; echo $diff_drop_website_cf['diff_order']; ?>
                            </span>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php endwhile; endif; wp_reset_postdata(); ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </td>
      </tr>
    <?php endwhile; endif; wp_reset_postdata(); ?>
  </tbody>
</table>