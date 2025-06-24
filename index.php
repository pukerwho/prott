<?php 
get_header(); 
$current_user_id = get_current_user_id();
$users = [
  "1" => [
    "name" => "Ана-Катаріна Кузмицька",
    "key" => "kuzmicka",
  ],
  "2" => [
    "name" => "Лідія Кулик",
    "key" => "lidia",
  ],
  "3" => [
    "name" => "Аліна Трикіша",
    "key" => "trikisha",
  ],
  "4" => [
    "name" => "Настя Можаровська",
    "key" => "nastya",
  ],
  "5" => [
    "name" => "Сергій Кулик",
    "key" => "skulik",
  ],
  "6" => [
    "name" => "Єлизавета Будас",
    "key" => "liza",
  ],
  "7" => [
    "name" => "Тетяна Ковальчук",
    "key" => "kovalchuk",
  ]
];

$args = array(
  'post_type' => 'tasks',
  'posts_per_page' => -1,
  'meta_query' => array(
    array(
      'key'     => '_crb_tasks_status',
      'value'   => 'Перевірено',
      'compare' => 'NOT LIKE',
    ),
    
  ),
  'date_query' => array(
    array(
      'after' => '4 days ago',
      'inclusive' => true,
    ),
  ),
);
$tasks = new WP_Query($args);

?>

<?php if ($current_user_id === 1): ?>
<div class="container py-4">
  <div class="flex items-center justify-between mb-4">
    <div class="flex items-center space-x-6">
      <!-- Меню -->
      <div class="inline-flex items-center rounded-lg bg-white p-1 space-x-1">
        <a href="/" class="px-4 py-1.5 text-sm font-medium rounded-lg bg-gray-200 text-gray-900">
          Всі
        </a>
        <a href="/write" class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900">
          З написанням
        </a>
        <a href="/ready" class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900">
          Готові
        </a>
      </div>
      <!-- На перевірці -->
      <div class="flex items-center space-x-3">
        <span>На перевірці</span>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" value="" class="sr-only peer" id="filter-status-check">
          <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-transparent rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
        </label>
      </div>
    </div>
    
    <?php echo get_template_part('template-parts/menu-btn'); ?>
  </div>
  
  <div class="day bg-white rounded-lg p-4 mb-4 last-of-type:mb-0">
    <div class="posts">
      <?php if ($tasks->have_posts()): ?>
      <table class="w-full table-auto prott-table">
        <thead class="border-b border-gray-200 text-gray-600">
          <tr>
            <th class="text-left whitespace-nowrap py-2">
              <div class="text-left font-bold"><?php _e("ID", "treba-wp"); ?></div>
            </th>
            <th class="text-left whitespace-nowrap py-2" data-sort-id="1">
              <div class="text-left font-bold"><?php _e("Сайт", "treba-wp"); ?></div>
            </th>
            <th class="text-left whitespace-nowrap py-2" data-sort-id="2">
              <div class="text-left font-bold"><?php _e("Статус", "treba-wp"); ?></div>
            </th>
            <th class="text-left whitespace-nowrap py-2 prott-sort-js" data-sort-id="3">
              <div class="flex items-center">
                <div class="text-left font-bold"><?php _e("Дата", "treba-wp"); ?></div>
                <div class="sort-arrow hidden ml-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                  </svg>
                </div>
              </div>
            </th>
            <th class="text-left whitespace-nowrap py-2" data-sort-id="4">
              <div class="text-left font-bold"><?php _e("Завдання", "treba-wp"); ?></div>
            </th>
            <th class="text-left whitespace-nowrap py-2 prott-sort-js" data-sort-id="5">
              <div class="flex items-center">
                <div class="text-left font-bold"><?php _e("Автор", "treba-wp"); ?></div>
                <div class="sort-arrow hidden ml-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                </div>
              </div>
            </th>
            <th class="text-center whitespace-nowrap py-2">
              <div class="text-center font-bold"><?php _e("Дії", "treba-wp"); ?></div>
            </th>
          </tr>
        </thead>
        <tbody class="text-sm">
          <?php if ($tasks->have_posts()) : while ($tasks->have_posts()) : $tasks->the_post(); ?>
            <?php 
              // Всі значення мета-полів на початку
              $current_id = get_the_ID();
              $task_id = carbon_get_the_post_meta("crb_tasks_id");
              $crb_tasks_status = carbon_get_the_post_meta("crb_tasks_status");
              $crb_tasks_pay = carbon_get_the_post_meta("crb_tasks_pay");
              $crb_tasks_complete = carbon_get_the_post_meta("crb_tasks_complete");
              $crb_tasks_type = carbon_get_the_post_meta('crb_tasks_type');
              $task_post_link = carbon_get_the_post_meta('crb_tasks_post_link');
              $task_site = carbon_get_the_post_meta("crb_tasks_site");
              // Логічні змінні для читабельності
              $is_new_task = ($crb_tasks_status === 'Нове завдання');
              $is_paid = ($crb_tasks_pay === 'yes');
              $is_complete = ($crb_tasks_complete == 'yes');
              $is_admin = ($current_user_id == '1');
              $is_collaborator = strpos($crb_tasks_type, 'collaborator') !== false;
            ?>
            <tr class="border-b border-gray-200 last:border-transparent" data-tr-status="<?php echo $crb_tasks_status; ?>">
              <td class="whitespace-nowrap py-2">
                <div class="flex items-center">
                  <div class="w-[8px] h-[8px] rounded-full border-2 <?php echo $is_collaborator ? 'border-rose-400' : 'border-green-400' ; ?> mr-2"></div>
                  <div><?php echo esc_html($task_id); ?></div>
                </div>
              </td>
              <td class="whitespace-nowrap py-2">
                <?php if ($task_post_link): ?>
                  <div class="flex items-center">
                    <div class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="12px" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h560v-280h80v280q0 33-23.5 56.5T760-120H200Zm188-212-56-56 372-372H560v-80h280v280h-80v-144L388-332Z"></path></svg></div>
                    <a href="<?php echo $task_post_link; ?>" target="_blank" class="text-blue-500"><?php echo $task_site; ?></a>
                <?php else: ?>
                  <?php echo $task_site; ?>
                <?php endif; ?>
              </td>
              <td class="whitespace-nowrap py-2">
                <?php
                  // Оптимізований блок з компактними if/else для статусу
                  if ($crb_tasks_status === 'В процесі написання') {
                    $status_class = 'w-[8px] h-[8px] rounded-full bg-blue-400 mr-2';
                    $status_text = 'В процесі написання';
                  } elseif ($crb_tasks_status === 'Нове завдання') {
                    $status_class = 'w-[8px] h-[8px] rounded-full bg-yellow-400 mr-2';
                    $status_text = 'Нове завдання';
                  } elseif ($crb_tasks_status === 'В роботі') {
                    $status_class = 'w-[8px] h-[8px] rounded-full border-2 border-blue-400 mr-2';
                    $status_text = 'В роботі';
                  } elseif ($crb_tasks_status === 'На перевірці') {
                    $status_class = 'w-[8px] h-[8px] rounded-full border-2 border-green-400 mr-2';
                    $status_text = 'На перевірці';
                  } elseif ($crb_tasks_status === 'Перевірено') {
                    $status_class = 'w-[8px] h-[8px] rounded-full bg-green-400 mr-2';
                    $status_text = 'Перевірено';
                  } else {
                    $status_class = 'w-[8px] h-[8px] bg-black rounded mr-2';
                    $status_text = $crb_tasks_status;
                  }
                ?>
                <div class="flex items-center">
                  <div class="<?php echo $status_class; ?>"></div>
                  <div><?php echo $status_text; ?></div>

                  <?php if (!$is_collaborator): ?>
                  <!-- Статус оплати -->
                  <div class="ml-2">
                    <div class="<?php echo ($is_paid) ? 'text-green-500 ' : 'text-gray-400'; ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>

              </td>
              <td class="whitespace-nowrap py-2">
                <div class="text-blue-500 cursor-pointer date-click-js" data-date-id="<?php echo $current_id; ?>">
                  <span class="data-sort-prott"><?php 
                    echo get_the_date("d.m, H:i");
                    // echo carbon_get_the_post_meta('crb_tasks_date_create'); 
                  ?></span>
                </div>
                <div class="date-modal px-8 py-6" data-date-modal="<?php echo $current_id; ?>">
                  <div class="modal-content">
                    <div class="modal-box max-w-[640px] min-w-[480px] min-h-full bg-white rounded-lg px-6 py-4">
                      <div class="text-xl text-center mb-4">Дата/час</div>
                      <?php 
                      $task_create = get_the_date("Y/m/d H:i:s");
                      // $task_create = carbon_get_the_post_meta('crb_tasks_date_create');
                      $author_date = carbon_get_the_post_meta('crb_tasks_author_date');
                      $link_date = carbon_get_the_post_meta('crb_tasks_link_date');
                      ?>
                      <div class="flex items-center mb-3 last-of-type:mb-0">
                        <div class="mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        </div>
                        <div>Надійшла заявка: <?php echo get_the_date("d.m, H:i"); ?></div>
                      </div>
                      <div class="flex items-center mb-3 last-of-type:mb-0">
                        <div class="mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                        </div>
                        <div>Передано копірайтеру: <?php echo ($author_date) ? date("d.m, H:i", $author_date) : '...'; ?></div>
                      </div>
                      <div class="flex items-center">
                        <div class="mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" /></svg>
                        </div>
                        <div>
                          Додано посилання: <?php echo ($link_date) ? date("d.m, H:i", $link_date) : '...'; ?>
                            <?php if ($link_date): ?>
                              <?php $task_finish_date = taskFinishDate($task_create, $link_date); ?>
                              <span>(<span class="<?php echo ($task_finish_date > 20) ? 'text-red-500' : 'text-green-500'; ?>"><?php echo $task_finish_date; ?> г.</span>)</span>
                            <?php else: ?>
                              <?php $task_continue_date = taskContinueDate($task_create); ?>
                              <span>(<span class="<?php echo ($task_continue_date > 20) ? 'text-red-500' : 'text-green-500'; ?>"><?php echo taskContinueDate($task_create); ?> г.</span>)</span>
                            <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td class="whitespace-nowrap py-2">
                <div class="text-blue-500 detail-click-js cursor-pointer" data-detail-id="<?php echo $current_id; ?>">Детальніше</div>
                <div class="detail-modal px-8 py-6 " data-detail-modal="<?php echo $current_id; ?>">
                  <div class="modal-content">
                    <?php 
                      $task_content = get_the_content();
                      $task_type = carbon_get_the_post_meta('crb_tasks_type');
                    ?>
                    <div class="modal-box w-full lg:w-3/4 min-h-full bg-white rounded-lg px-6 py-4">
                      
                      <div class="text-xl mb-4">Завдання <?php echo carbon_get_the_post_meta('crb_tasks_id'); ?> - <span class="font-light text-gray-600"><?php echo carbon_get_the_post_meta('crb_tasks_site'); ?></span></div>
                      
                      <?php if ($task_content): ?>
                      <div class="content whitespace-pre-line mb-4">
                        <?php echo get_the_content(); ?>
                      </div>
                      <?php endif; ?>

                      <?php if (strpos($task_type, 'collaborator') !== false): ?>
                        <?php 
                          $title = carbon_get_the_post_meta('crb_tasks_title');
                          $url = carbon_get_the_post_meta('crb_tasks_url');
                          $metaTitle = carbon_get_the_post_meta('crb_tasks_metatitle');
                          $metaDescription = carbon_get_the_post_meta('crb_tasks_metadescription');
                          $html = wp_kses_post(get_post_meta(get_the_ID(), '_crb_tasks_html', true));
                        ?>
                        <!-- Назва статті -->
                        <div class="font-bold mb-1">Назва статті:</div>
                        <div class="flex items-center relative mb-4">
                          <div class="bg-gray-600 text-white rounded cursor-pointer copy-click p-2 mr-1" data-clipboard-text="<?php echo $title; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
                          </div>
                          <div class="w-full relative border border-gray-300 rounded text-ellipsis overflow-hidden px-2 py-2">
                            <?php echo $title; ?>
                          </div>
                          <div class="copy-tooltip hidden absolute -top-[4px] left-0 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $title; ?>">Скопійовано 🙂</div>
                        </div>
                        
                        <?php if ($url): ?>
                        <!-- URL статті -->
                        <div class="font-bold mb-1">Бажаний вигляд URL:</div>
                        <div class="flex items-center relative mb-4">
                          <div class="bg-gray-600 text-white rounded cursor-pointer copy-click p-2 mr-1" data-clipboard-text="<?php echo $url; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
                          </div>
                          <div class="w-full relative border border-gray-300 rounded text-ellipsis overflow-hidden px-2 py-2">
                            <?php echo $url; ?>
                          </div>
                          <div class="copy-tooltip hidden absolute -top-[4px] left-0 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $url; ?>">Скопійовано 🙂</div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($metaTitle): ?>
                        <!-- Title статті -->
                        <div class="font-bold mb-1">Title:</div>
                        <div class="flex items-center relative mb-4">
                          <div class="bg-gray-600 text-white rounded cursor-pointer copy-click p-2 mr-1" data-clipboard-text="<?php echo $metaTitle; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
                          </div>
                          <div class="w-full relative border border-gray-300 rounded text-ellipsis overflow-hidden px-2 py-2">
                            <?php echo $metaTitle; ?>
                          </div>
                          <div class="copy-tooltip hidden absolute -top-[4px] left-0 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $metaTitle; ?>">Скопійовано 🙂</div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($metaDescription): ?>
                        <!-- Description статті -->
                        <div class="font-bold mb-1">Description:</div>
                        <div class="flex items-center relative mb-4">
                          <div class="bg-gray-600 text-white rounded cursor-pointer copy-click p-2 mr-1" data-clipboard-text="<?php echo $metaDescription; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
                          </div>
                          <div class="w-full relative border border-gray-300 rounded text-ellipsis overflow-hidden px-2 py-2">
                            <?php echo $metaDescription; ?>
                          </div>
                          <div class="copy-tooltip hidden absolute -top-[4px] left-0 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $metaDescription; ?>">Скопійовано 🙂</div>
                        </div>
                        <?php endif; ?>

                        <!-- Анкори -->
                        <div class="font-bold mb-1">Цільові сторінки:</div>
                        <div class="mb-4">
                          <div class="flex items-center mb-1 -mx-2">
                            <div class="w-1/2 px-2">
                              <div class="text-sm">Анкор:</div>
                            </div>
                            <div class="w-1/2 px-2">
                              <div class="text-sm">Цільова сторінка:</div>
                            </div>
                          </div>
                          <?php
                          // Парсимо HTML для отримання анкорів і посилань/зображень
                          $anchors_parsed = [];
                          libxml_use_internal_errors(true);
                          $dom = new DOMDocument();
                          $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

                          foreach ($dom->getElementsByTagName('a') as $link) {
                            $href = $link->getAttribute('href');
                            $anchor_text = trim($link->textContent);

                            // Якщо тексту нема, але є зображення
                            if ($anchor_text === '') {
                              $images = $link->getElementsByTagName('img');
                              if ($images->length > 0) {
                                $img = $images->item(0);
                                $anchor_text = 'картинка';
                              }
                            }

                            $anchors_parsed[] = ['anchor' => $anchor_text, 'url' => $href];
                          }
                          ?>
                          <?php foreach ($anchors_parsed as $anchor): ?>
                            <div class="flex items-center mb-2 -mx-1">
                              <div class="w-1/2 relative px-1">
                                <div class="bg-gray-100 border border-gray-300 rounded text-ellipsis overflow-hidden cursor-pointer p-2 copy-click" data-clipboard-text="<?php echo $anchor['anchor']; ?>"><?php echo $anchor['anchor']; ?></div>
                                <div class="copy-tooltip hidden absolute -top-[4px] left-1 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $anchor['anchor']; ?>">Скопійовано 🙂</div>
                              </div>
                              <div class="w-1/2 relative px-1">
                                <div class="bg-gray-100 border border-gray-300 rounded text-ellipsis overflow-hidden cursor-pointer p-2 copy-click" data-clipboard-text="<?php echo $anchor['url']; ?>"><?php echo $anchor['url']; ?></div>
                                <div class="copy-tooltip hidden absolute -top-[4px] left-1 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $anchor['url']; ?>">Скопійовано 🙂</div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                        <!-- END Анкори -->

                        <!-- HTML статті -->
                        <div class="font-bold mb-1">Текст публікації:</div>
                        <?php 
                          $has_images = stripos($html, '&lt;img') !== false || stripos($html, '<img') !== false;
                        ?>
                        <div class="border border-gray-300 rounded-lg p-2 mb-2">
                          <pre class="h-64 overflow-auto whitespace-pre-wrap break-words bg-gray-100 p-4 rounded text-sm"><code class="download-html-source"><?php echo htmlspecialchars($html); ?></code></pre>
                        </div>
                        <?php if ($has_images): ?>
                          <a href="<?php echo get_template_directory_uri(); ?>/inc/download-images.php?post_id=<?php echo $current_id; ?>" class="bg-gray-200 text-black text-center rounded-lg p-2 cursor-pointer mb-1 block" target="_blank">Завантажити картинки</a>
                        <?php endif; ?>
                        <div class="relative mb-4">
                          <div class="bg-gray-600 text-white text-center rounded-lg p-2 cursor-pointer copy-click" data-clipboard-text="<?php echo htmlspecialchars($html); ?>">Скопіювати</div>
                          <div class="copy-tooltip hidden absolute -top-[4px] left-0 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo htmlspecialchars($html); ?>">Скопійовано 🙂</div>
                        </div>
                      <?php else: ?>
                        <div class="text-xl mb-2">Цільові сторінки</div>
                        <div class="mb-4">
                          <div class="flex items-center mb-1 -mx-2">
                            <div class="w-1/2 px-2">
                              <div class="text-sm">Анкор:</div>
                            </div>
                            <div class="w-1/2 px-2">
                              <div class="text-sm">Цільова сторінка:</div>
                            </div>
                          </div>
                          <?php 
                          $anchors = carbon_get_the_post_meta('crb_tasks_anchors');
                          ?>
                          <?php foreach (unserialize($anchors) as $anchor): ?>
                            <div class="flex items-center mb-2 -mx-1">
                              <div class="w-1/2 relative px-1">
                                <div class="bg-gray-100 border border-gray-300 rounded text-ellipsis overflow-hidden cursor-pointer p-2 copy-click" data-clipboard-text="<?php echo $anchor['anchor']; ?>"><?php echo $anchor['anchor']; ?></div>
                                <div class="copy-tooltip hidden absolute -top-[4px] left-1 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $anchor['anchor']; ?>">Скопійовано 🙂</div>
                              </div>
                              <div class="w-1/2 relative px-1">
                                <div class="bg-gray-100 border border-gray-300 rounded text-ellipsis overflow-hidden cursor-pointer p-2 copy-click" data-clipboard-text="<?php echo $anchor['url']; ?>"><?php echo $anchor['url']; ?></div>
                                <div class="copy-tooltip hidden absolute -top-[4px] left-1 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo $anchor['url']; ?>">Скопійовано 🙂</div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Посилання -->
                      <div class="text-xl mb-2">Посилання на статтю</div>
                      <?php 
                        
                      if ($task_post_link): ?>
                        <a href="<?php echo $task_post_link; ?>" target="_blank"><?php echo $task_post_link; ?></a>
                      <?php else: ?> 
                        <?php 
                        $get_tasks_author = carbon_get_the_post_meta("crb_tasks_author");
                          if (!$is_new_task): ?>
                          <div>
                            <div class="task-link-error text-red-500 hidden" data-task-id="<?php echo $current_id; ?>"></div>
                            <!-- Форма -->
                            <div class="mb-2">
                              <input type="text" class="task-link w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-inputlink-id="<?php echo $current_id; ?>">
                            </div>
                            <div class="task-link-js" data-post-id="<?php echo $current_id; ?>" data-task-id="<?php echo carbon_get_the_post_meta('crb_tasks_id'); ?>" data-task-site="<?php echo $task_site; ?>" data-clbr-type="<?php echo $is_collaborator; ?>">
                              <div class="bg-blue-500 text-white text-center rounded cursor-pointer px-4 py-2">Відправити</div>
                            </div>
                          </div>
                        <?php else: ?>
                          <div>
                            <?php 
                            if ($get_tasks_author): ?>
                            <?php else: ?>
                              <div class="italic">Треба обрати автора</div>
                            <?php endif; ?>
                          </div>
                        <?php endif; ?>
                      <?php endif; ?>
                      <!-- END Посилання -->
                    </div>
                  </div>
                </div>
              </td>
              <td class="whitespace-nowrap py-2">
                <?php 
                if ($is_new_task) { echo '<i>Треба прийняти завдання</i>';
                } else {
                  if ($is_collaborator) {
                    $author_accept = carbon_get_the_post_meta('crb_tasks_author_accept');
                    $user_info = get_userdata($author_accept);
                    if ($user_info) {
                      echo esc_html($user_info->display_name);
                    } else {
                      echo 'Невідомий користувач';
                    } 
                  } else {
                    $tasks_author = carbon_get_the_post_meta("crb_tasks_author");
                    $author_flex_class = ($tasks_author) ? 'flex' : 'hidden';
                    $author_choose_class = (!$tasks_author) ? 'flex' : 'hidden';
                ?>
                  <div class="<?php echo $author_flex_class; ?> items-center author-task" data-task-id="<?php echo $current_id; ?>">
                    <div class="mr-2"><span class="data-sort-prott"><?php echo $tasks_author; ?></span></div>
                    <div class="cursor-pointer task-author-edit-js" data-task-id="<?php echo $current_id; ?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></div>
                  </div>
                  <!-- Обираємо автора -->
                  <div class="<?php echo $author_choose_class; ?> items-center author-task-choose" data-task-id="<?php echo $current_id; ?>">
                    <div class="mr-2">
                      <select class="author-select" name="select-author-name" data-select-id="<?php echo $current_id; ?>">
                        <option selected>Оберіть автора</option>
                        <?php foreach ($users as $user): ?>
                          <option value="<?php echo htmlspecialchars($user['name']); ?>">
                            <?php echo htmlspecialchars($user['name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="task-author-js" data-post-id="<?php echo $current_id; ?>">
                      <div class="flex items-center bg-blue-500 text-white rounded cursor-pointer px-2 py-1">
                        <div class="mr-2">Save</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                        </svg>
                      </div>
                    </div>
                  </div>
                <?php }} ?>
              </td>
              <!-- ДІЇ -->
              <td class="whitespace-nowrap py-2">
                <?php if ($is_new_task): ?>
                  <div class="task-accept flex items-center justify-center bg-blue-500 text-white rounded text-center cursor-pointer px-2 py-1 task-accept-js" data-post-id="<?php echo $current_id; ?>" data-author-accept="<?php echo get_the_author(); ?>">
                    <div class="mr-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                      </svg>
                    </div>
                    <div>Прийняти</div>
                  </div>
                <?php else: ?>
                  <!-- ДІЇ Якщо готові статті -->
                  <?php if ($is_collaborator): ?>
                    <!-- ДІЇ Якщо вже є посилання -->
                    <?php if ($task_post_link): ?>
                      <!-- ДІЇ Чи перевірили чи ні -->
                      <?php if ($is_complete): ?>
                        <div class="border border-green-500 bg-green-500 text-white rounded text-center px-6 py-1">Перевірено</div>
                      <?php else: ?>
                        <div class="btn-complete btn-complete-ready border border-green-500 rounded text-center cursor-pointer px-6 py-1 <?php echo ($current_user_id == '1') ? 'task-complete-js': ''; ?>" data-post-id="<?php echo $current_id; ?>">На перевірці</div>
                      <?php endif; ?>
                    <?php else: ?>
                    <!-- ДІЇ Якщо немає посилання, то в роботі -->
                      <div class="border border-blue-500 rounded text-center px-6 py-1">В роботі</div>
                    <?php endif; ?>
                  <?php else: ?>
                  <!-- ДІЇ Якщо з написанням -->
                  <div class="">
                    <!-- ДІЇ Якщо додано посилання -->
                    <?php if ($task_post_link): ?>
                      <?php $get_tasks_complete = carbon_get_the_post_meta("crb_tasks_complete"); ?>
                      <?php if ($get_tasks_complete == 'yes'): ?>
                        <div class="border border-green-500 bg-green-500 text-white rounded text-center px-6 py-1">Перевірено</div>
                      <?php else: ?>
                        <div class="btn-complete btn-complete-ready border border-green-500 rounded text-center cursor-pointer px-6 py-1 <?php echo ($current_user_id == '1') ? 'task-complete-js': ''; ?>" data-post-id="<?php echo $current_id; ?>">На перевірці</div>
                      <?php endif; ?>
                    <?php else: ?>
                    <!-- ДІЇ Якщо немає посилання, то в роботі -->
                    <div class="border border-blue-500 rounded text-center px-6 py-1">В роботі</div>
                    <?php endif; ?>
                  </div>
                  <?php endif; ?>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; endif; wp_reset_postdata(); ?>
        </tbody>
      </table>
      <?php else: ?>
        <div class="text-center py-4">
          <div class="text-2xl mb-4">Поки тут нічого немає</div>
          <div class="text-lg font-light">Треба почекати і тут знову будуть нові завдання 😉</div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>