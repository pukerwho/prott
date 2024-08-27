<table id="drop-table" class="w-full table-fixed">
  <thead class="text-sm border-b border-gray-200 text-gray-600">
    <tr>
      <th class="w-[175px] text-left whitespace-nowrap py-2">
        <div class="text-left font-bold"><?php _e("Сайт", "treba-wp"); ?></div>
      </th>
      <th class="text-left whitespace-nowrap py-2 cursor-pointer sort-table-drop-js" data-sort-id="1">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("DR", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-center whitespace-nowrap py-2 cursor-pointer sort-table-drop-js" data-sort-id="2">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("TF", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-center whitespace-nowrap py-2 cursor-pointer sort-table-drop-js" data-sort-id="3">
        <div class="flex items-center">
          <div class="text-left font-bold"><?php _e("CF", "treba-wp"); ?></div>
          <div class="sort-arrow hidden ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
          </div>
        </div>
      </th>
      <th class="text-center whitespace-nowrap py-2">
        <div class="text-left font-bold"><?php _e("Expired", "treba-wp"); ?></div>
      </th>
      <th class="text-center whitespace-nowrap py-2">
        <div class="text-left font-bold"><?php _e("Сайти", "treba-wp"); ?></div>
      </th>
    </tr>
  </thead>
  <tbody class="text-sm">
    <?php 
      $drops = new WP_Query( array( 
        'post_type' => 'drops', 
        'posts_per_page' => -1,
      ) );
      if ($drops->have_posts()) : while ($drops->have_posts()) : $drops->the_post(); 
    ?>
      <?php $current_id = get_the_ID(); ?>
      <tr>
        <td class="whitespace-nowrap py-2"><?php the_title(); ?></td>
        <!-- Drop DR -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_dr = carbon_get_the_post_meta('crb_drops_dr');
            $dr_array = explode(",", $get_dr);
            $dr_array = array_reverse($dr_array);
            $diff_dr = diffValue($dr_array[0], $dr_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value-drop">
                <?php echo $dr_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_dr['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_dr['diff_order_sign']; echo $diff_dr['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-which-week="drop" data-modal-id="Drop-DR-<?php echo $current_id; ?>" data-value-array="<?php echo $get_dr; ?>" data-value-label="DR - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="Drop-DR-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="Drop-DR-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END Drop DR -->
        <!-- Drop TF -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_tf = carbon_get_the_post_meta('crb_drops_tf');
            $tf_array = explode(",", $get_tf);
            $tf_array = array_reverse($tf_array);
            $diff_tf = diffValue($tf_array[0], $tf_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value-drop">
                <?php echo $tf_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_tf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_tf['diff_order_sign']; echo $diff_tf['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-which-week="drop" data-modal-id="Drop-TF-<?php echo $current_id; ?>" data-value-array="<?php echo $get_tf; ?>" data-value-label="TF - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="Drop-TF-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="Drop-TF-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END Drop TF -->
        <!-- Drop CF -->
        <td class="whitespace-nowrap py-2">
          <?php 
            $get_cf = carbon_get_the_post_meta('crb_drops_cf');
            $cf_array = explode(",", $get_cf);
            $cf_array = array_reverse($cf_array);
            $diff_cf = diffValue($cf_array[0], $cf_array[1]);
          ?>
          <div class="flex items-center">
            <div>
              <!-- value -->
              <span class="sort-value-drop">
                <?php echo $cf_array[0]; ?>
              </span> 
              <!-- diff -->
              <span class="<?php echo $diff_cf['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                <?php echo $diff_cf['diff_order_sign']; echo $diff_cf['diff_order']; ?>
              </span>
            </div>
            <!-- icon graph -->
            <div class="cursor-pointer ml-1 value-modal-js" data-which-week="drop" data-modal-id="Drop-CF-<?php echo $current_id; ?>" data-value-array="<?php echo $get_cf; ?>" data-value-label="CF - <?php the_title(); ?>" data-chart-type="line">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg>
            </div>
          </div>
          <div class="chart-modal px-8 py-6 " data-modal-id="Drop-CF-<?php echo $current_id; ?>">
            <div class="modal-content">
              <div class="modal-box w-4/5 bg-white min-h-full rounded-lg px-6 py-4">
                <canvas class="line-chart" data-chart-id="Drop-CF-<?php echo $current_id; ?>"></canvas>
              </div>
            </div>
          </div>
        </td>
        <!-- END Drop CF -->
        <td class="whitespace-nowrap py-2"><?php echo carbon_get_the_post_meta('crb_drops_expired'); ?></td>
        <td class="whitespace-nowrap py-2">
          <div class="text-blue-500 cursor-pointer detail-click-js" data-detail-id="Drop-Websites-<?php echo $current_id; ?>">Детальніше</div>
          <div class="detail-modal px-8 py-6 " data-detail-modal="Drop-Websites-<?php echo $current_id; ?>">
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
                          <span class="sort-value-drop">
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
                          <span class="sort-value-drop">
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
                          <span class="sort-value-drop">
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
                      $drops_websites = carbon_get_the_post_meta('crb_drops_websites');
                      foreach ($drops_websites as $drop_website):
                    ?>
                    <tr>
                      <?php $dw_id = $drop_website['id']; ?>
                      <td class="whitespace-nowrap py-2"><?php echo get_the_title($dw_id); ?></td>
                      <!-- DR -->
                      <td class="whitespace-nowrap py-2">
                        <?php 
                          $get_website_dr = carbon_get_post_meta($dw_id, 'crb_websites_dr');
                          $dr_website_array = explode(",", $get_website_dr);
                          $dr_website_array = array_reverse($dr_website_array);
                          $diff_dr_website = diffValue($dr_website_array[0], $dr_website_array[1]);
                        ?>
                        <div class="flex items-center">
                          <div>
                            <!-- value -->
                            <span class="sort-value-drop">
                              <?php echo $dr_website_array[0]; ?>
                            </span> 
                            <!-- diff -->
                            <span class="<?php echo $diff_dr_website['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                              <?php echo $diff_dr_website['diff_order_sign']; echo $diff_dr_website['diff_order']; ?>
                            </span>
                          </div>
                        </div>
                      </td>
                      <!-- TF -->
                      <td class="whitespace-nowrap py-2">
                        <?php 
                          $get_website_tf = carbon_get_post_meta($dw_id, 'crb_websites_tf');
                          $tf_website_array = explode(",", $get_website_tf);
                          $tf_website_array = array_reverse($tf_website_array);
                          $diff_tf_website = diffValue($tf_website_array[0], $tf_website_array[1]);
                        ?>
                        <div class="flex items-center">
                          <div>
                            <!-- value -->
                            <span class="sort-value-drop">
                              <?php echo $tf_website_array[0]; ?>
                            </span> 
                            <!-- diff -->
                            <span class="<?php echo $diff_tf_website['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                              <?php echo $diff_tf_website['diff_order_sign']; echo $diff_tf_website['diff_order']; ?>
                            </span>
                          </div>
                        </div>
                      </td>
                      <!-- CF -->
                      <td class="whitespace-nowrap py-2">
                        <?php 
                          $get_website_cf = carbon_get_post_meta($dw_id, 'crb_websites_cf');
                          $cf_website_array = explode(",", $get_website_cf);
                          $cf_website_array = array_reverse($cf_website_array);
                          $diff_cf_website = diffValue($cf_website_array[0], $cf_website_array[1]);
                        ?>
                        <div class="flex items-center">
                          <div>
                            <!-- value -->
                            <span class="sort-value-drop">
                              <?php echo $cf_website_array[0]; ?>
                            </span> 
                            <!-- diff -->
                            <span class="<?php echo $diff_cf_website['diff_order_class']; ?> value-diff inline-block rounded ml-1">
                              <?php echo $diff_cf_website['diff_order_sign']; echo $diff_cf_website['diff_order']; ?>
                            </span>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
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
