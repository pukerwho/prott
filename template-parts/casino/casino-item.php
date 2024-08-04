<tr class="flex flex-wrap border-b border-custom-gray">
  <td class="w-full lg:w-1/6 p-4">
    <?php $logo = carbon_get_the_post_meta('crb_casino_logo'); if ($logo): ?>
      <img class="w-[100px] object-cover rounded-lg mb-4 mx-auto" alt="<?php the_title(); ?>" src="<?php echo $logo; ?>" loading="lazy">
    <?php endif; ?>
    <div class="text-lg font-medium text-center"><?php the_title(); ?></div>
  </td>
  <td class="w-full lg:w-3/6 p-4">
    <div class="flex items-center mb-2">
      <div class="text-green-500 mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
        </svg>
      </div>
      <?php _e("Бонуси", "treba-wp"); ?>
    </div>
    <ul>
      <?php 
        $bonuses = carbon_get_the_post_meta("crb_casino_bonuses"); 
        foreach ($bonuses as $bonus):
      ?>
        <li class="flex text-sm mb-2 last-of-type:mb-0">
          <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg" class="mt-[5px]">
            <path d="M0.870117 4.42015L4.00972 7.55975L10.129 1.44043" stroke="#1C2642" stroke-width="2"/>
          </svg>
          <span class="inline-block ml-2"><?php echo $bonus["crb_casino_bonus"]; ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </td>
  <td class="w-full lg:w-1/6 p-4">
    <div class="text-center mb-2 lg:mb-4">
      <span class="text-lg text-medium"><?php echo carbon_get_the_post_meta("crb_casino_rating"); ?></span> <span class="text-gray-400">/ 100</span>
    </div>
    <div>
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/stars.svg" alt="Рейтинг" loading="lazy">
    </div>
  </td>
  <td class="w-full lg:w-1/6 p-4">
    <div class="mb-2 lg:mb-4"><a href="<?php echo carbon_get_the_post_meta("crb_casino_link"); ?>" class="w-full inline-block bg-emerald-500 text-white text-center rounded py-2"><?php _e("Грати", "treba-wp"); ?></a></div>
    <div><a href="<?php the_permalink(); ?>" class="w-full inline-block text-main-dark border border-emerald-500 text-center rounded py-2"><?php _e("Огляд", "treba-wp"); ?></a></div>
  </td>
</tr>