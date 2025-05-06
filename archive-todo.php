<?php 
get_header(); 
$current_user_id = get_current_user_id();
?>

<?php if ($current_user_id === 1 || $current_user_id === 2): ?>
<div class="container py-4">
  <div class="bg-white rounded-lg py-4">
    <div class="px-4 mb-4">
      <h1 class="text-2xl font-medium">Завдання</h1>
    </div>

    <div class="flex items-center justify-between px-4 mb-4">
      <form  name="filter_tours" class="flex items-center gap-2">
        <div class="flex items-center justify-between gap-2">
          <div class="flex items-center gap-1 text-sm font-medium rounded-full border border-gray-300 px-3 py-1.5">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <select id="site-select" class="site-select" name="todo_status">
              <option value="All">Статус</option>
              <?php 
              $todo_status = !empty( $_GET['todo_status'] ) ? $_GET['todo_status'] : '';
              $all_status = ["Всі", "В роботі", "На перевірці", "Прийняті"];
              foreach ($all_status as $status):
              ?>
                <option value="<?php echo $status; ?>" <?php echo $todo_status == $status ? 'selected' : ''; ?>><?php echo $status; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="flex items-center gap-1 text-sm font-medium rounded-full border border-gray-300 px-3 py-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" /></svg>  
            <select id="orderby-select" class="orderby-select" name="article_orderby" data-select-id="<?php echo $current_id; ?>">
              <option value="All">Оплата</option>
              <?php 
              $article_orderby = !empty( $_GET['article_orderby'] ) ? $_GET['article_orderby'] : '';
              $all_orderby = [
                [
                  "name" => "По keywords",
                  "key" => "_crb_article_ahrefs",
                ],
                [
                  "name" => "По клікам",
                  "key" => "_crb_article_google_click",
                ],
                [
                  "name" => "По показам",
                  "key" => "_crb_article_google_views",
                ]
              ];
              foreach ($all_orderby as $orderby):
              ?>
                <option value="<?php echo $orderby["key"]; ?>" <?php echo $article_orderby == $orderby["key"] ? 'selected' : ''; ?>><?php echo $orderby["name"]; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <input type="submit" class="ml-auto flex items-center rounded-full bg-purple-600 px-3 py-1.5 text-sm font-medium text-white cursor-pointer hover:bg-purple-700"  value="Застосувати">
      </form>
      <!-- new todo btn -->
      <div>
        <div class="bg-emerald-600 text-gray-50 flex items-center rounded-[6px] px-3 py-1 cursor-pointer">
          <div class="mr-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[16px] h-[16px]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          </div>
          Нове завдання
        </div>
      </div>
      <!-- end new todo btn -->
    </div>
    
    
    <div>
      <table class="w-full table-auto text-sm prott-table">
        <thead class="bg-[#eeeeee] font-semibold text-sm text-gray-700">
          <tr>
            <th class="text-left whitespace-nowrap px-4 py-2">
              <div class="text-left font-medium px-">Від кого</div>
            </th>
            <th class="text-left whitespace-nowrap px-4 py-2">
              <div class="text-left font-medium px-">Дата</div>
            </th>
            <th class="text-left whitespace-nowrap px-4 py-2">
              <div class="text-left font-medium">Статус</div>
            </th>
            <th class="text-left whitespace-nowrap px-4 py-2">
              <div class="text-left font-medium">Вартість</div>
            </th>
            <th class="text-left whitespace-nowrap px-4 py-2">
              <div class="text-left font-medium">Оплата</div>
            </th>
            <th class="text-left whitespace-nowrap px-4 py-2" >
              <div class="text-left font-medium">Завдання</div>
            </th>
          </tr>
        </thead>
        <tbody class="text-sm">
          <?php 
            $todo_query = new WP_Query( array( 
              'post_type' => 'todo', 
              'posts_per_page' => 30,
            ) );
            if ($todo_query->have_posts()) : while ($todo_query->have_posts()) : $todo_query->the_post(); 
          ?>
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">
              <div><?php echo carbon_get_the_post_meta("crb_todo_from"); ?></div>
            </td>
            <td class="px-4 py-2">
              <div><?php echo get_the_date("d.m, H:i"); ?></div>
            </td>
            <td class="px-4 py-2">
              <div class="flex items-center">
                <div class="w-[8px] h-[8px] bg-blue-400 rounded-full mr-2"></div>
                <div><?php echo carbon_get_the_post_meta("crb_todo_status"); ?></div>
              </div>
            </td>
            <td class="px-4 py-2">
              <div><?php echo carbon_get_the_post_meta("crb_todo_price"); ?> грн.</div>
            </td>
            <td class="px-4 py-2">
              <div class="w-[30px] h-[30px] flex items-center justify-center border border-[#d9d9e3] text-gray-600 rounded-[6px]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[16px] h-[16px]"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
              </div>
            </td>
            <td class="px-4 py-2">
              <div class="bg-blue-500 text-white text-center rounded cursor-pointer px-2 py-1">Деталі</div>
            </td>
          </tr>
          <?php endwhile; endif; wp_reset_postdata(); ?>
        </tbdoy>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>
<?php get_footer(); ?>