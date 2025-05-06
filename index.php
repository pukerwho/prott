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
  'date_query' => array(
    array(
      'after' => '8 days ago',
      'inclusive' => true,
    ),
  ),
);
$tasks = new WP_Query($args);

$args_month = array(
  'post_type' => 'tasks',
  'posts_per_page' => -1,
  'date_query' => array(
    array(
      'after' => '300 days ago',
      'inclusive' => true,
    ),
  ),
);
$tasks_month = new WP_Query($args_month);

$months = [
  1 => 'січень',
  2 => 'лютий',
  3 => 'березень',
  4 => 'квітень',
  5 => 'травень',
  6 => 'червень',
  7 => 'липень',
  8 => 'серпень',
  9 => 'вересень',
  10 => 'жовтень',
  11 => 'листопад',
  12 => 'грудень',
];

$current_month = date('n');
?>

<?php if ($current_user_id === 1 || $current_user_id === 2): ?>
<div class="container py-4">
  <div class="flex space-x-3 mb-6">
    <div class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 cursor-pointer modal-open-js" data-modal-id="modal-pay">
      <div class="mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[21px] h-[21px]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
      </div>
      <div>Оплата</div>
    </div>
    <?php if ($current_user_id === 1): ?>
    <div class="relative flex items-center bg-white border border-gray-300 rounded px-4 py-2 cursor-pointer">
      <a href="/todo" class="w-full h-full absolute left-0 top-0 z-1"></a>
      <div class="mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[21px] h-[21px]"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" /></svg>
      </div>
      <div>Завдання</div>
    </div>
    <?php endif; ?>
  </div>
  <?php 
  
  $posts_by_day = array_reduce( $tasks->posts, function( $r, $v ) {
    $r[ date( 'Y-m-d', strtotime( $v->post_date ) ) ][] = $v;
    return $r;  
  });
  ?>

  <?php if ( $posts_by_day ) : ?>
    <div class="day-posts">
      <?php $current_week = array_slice($posts_by_day, 0, 19); ?>
      <?php foreach( $current_week as $day => $day_posts ) : ?>
        <?php 
          $month = date( 'm', strtotime( $day ) );
          $current_month = date('n');
          // if ($month === $current_month ): 
        ?>
        <div class="day bg-white rounded-lg p-4 mb-4 last-of-type:mb-0">
          <div class="flex items-center justify-between mb-2">
            <div class="flex items-center">
              <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" /></svg>
              </div>
              <div class="text-lg font-bold"><?php echo date( 'd.m', strtotime( $day ) ); ?></div>
            </div>
            <div class="flex items-center">
              <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" /></svg>
              </div>
              <div class="text-lg text-gray-600">Завдань: <span class="font-bold"><?php echo count($posts_by_day[$day]); ?></span></div>
            </div>
          </div>
          
          <div class="posts">
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
                    <div class="text-left font-bold"><?php _e("Деталі", "treba-wp"); ?></div>
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
                    <div class="text-center font-bold"><?php _e("...", "treba-wp"); ?></div>
                  </th>
                </tr>
              </thead>
              <tbody class="text-sm">
                <?php foreach( $day_posts as $post ) : setup_postdata( $post ); ?>
                  <?php 
                    $current_id = get_the_ID();
                    $get_status = carbon_get_the_post_meta("crb_tasks_status"); 
                  ?>
                  <tr class="border-b border-gray-200 last:border-transparent">
                    <td class="whitespace-nowrap py-2"><?php echo carbon_get_the_post_meta("crb_tasks_id"); ?></td>
                    <td class="whitespace-nowrap py-2"><?php echo carbon_get_the_post_meta("crb_tasks_site"); ?></td>
                    <td class="whitespace-nowrap py-2">
                      <?php if ($get_status === 'В процесі написання'): ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] rounded-full bg-blue-400 mr-2"></div>
                          <div>В процесі написання</div>
                        </div>
                      <?php elseif ($get_status === 'Нове завдання'): ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] rounded-full bg-yellow-400 mr-2"></div>
                          <div>Нове завдання</div>
                        </div>
                      <?php elseif ($get_status === 'В роботі'): ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] rounded-full border-2 border-blue-400 mr-2"></div>
                          <div>В роботі</div>
                        </div>
                      <?php elseif ($get_status === 'На перевірці'): ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] rounded-full border-2 border-green-400 mr-2"></div>
                          <div>На перевірці</div>
                        </div>
                      <?php elseif ($get_status === 'Перевірено'): ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] rounded-full bg-green-400 mr-2"></div>
                          <div>Перевірено</div>
                        </div>
                      <?php else: ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] bg-black rounded mr-2"></div>
                          <div><?php echo $get_status; ?></div>
                        </div>
                      <?php endif; ?>
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
                          <div class="modal-box w-full max-w-[640px] min-h-full bg-white rounded-lg px-6 py-4">
                            <div class="text-xl mb-2">Завдання <?php echo carbon_get_the_post_meta('crb_tasks_id'); ?></div>
                            <div class="content whitespace-pre-line mb-4">
                              <?php echo get_the_content(); ?>
                            </div>
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
                            <!-- Посилання -->
                            <div class="text-xl mb-2">Посилання на статтю</div>
                            <?php $task_post_link = carbon_get_the_post_meta('crb_tasks_post_link'); if ($task_post_link): ?>
                              <a href="<?php echo $task_post_link; ?>" target="_blank"><?php echo $task_post_link; ?></a>
                            <?php else: ?> 
                              <div>
                                <?php $get_tasks_author = carbon_get_the_post_meta("crb_tasks_author");
                                if ($get_tasks_author): ?>
                                <!-- Форма -->
                                  <div class="mb-2"><input type="text" class="task-link w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-inputlink-id="<?php echo $current_id; ?>"></div>
                                  <div class="task-link-js" data-post-id="<?php echo $current_id; ?>" data-task-id="<?php echo carbon_get_the_post_meta('crb_tasks_id'); ?>"><div class="bg-blue-500 text-white text-center rounded cursor-pointer px-4 py-2">Відправити</div></div>
                                <?php else: ?>
                                  <div class="italic">Треба обрати автора</div>
                                <?php endif; ?>
                              </div>
                            <?php endif; ?>
                            <!-- END Посилання -->
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="whitespace-nowrap py-2">
                      <?php if ($get_status === 'Нове завдання'): ?>
                        <i>Треба прийняти завдання</i>
                      <?php else: ?>
                        <?php $tasks_author = carbon_get_the_post_meta("crb_tasks_author"); ?>
                        <div class="<?php echo ($tasks_author) ? 'flex' : 'hidden'; ?> items-center author-task" data-task-id="<?php echo $current_id; ?>">
                          <div class="mr-2"><span class="data-sort-prott"><?php echo $tasks_author; ?></span></div>
                          <div class="cursor-pointer task-author-edit-js" data-task-id="<?php echo $current_id; ?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></div>
                        </div>
                      
                        <!-- Обираємо автора -->
                        <div class="<?php echo (!$tasks_author) ? 'flex' : 'hidden'; ?> items-center author-task-choose" data-task-id="<?php echo $current_id; ?>">
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
                      <?php endif; ?>
                    </td>
                    <td class="whitespace-nowrap py-2">
                      <?php if ($get_status === 'Нове завдання'): ?>
                        <div class="task-accept flex items-center justify-center bg-blue-500 text-white rounded text-center cursor-pointer px-2 py-1 task-accept-js" data-post-id="<?php echo $current_id; ?>" >
                          <div class="mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                          </div>
                          <div>Прийняти</div>
                        </div>
                      <?php else: ?>
                        <div class="flex items-center -mx-1">
                          <div class="<?php echo ($task_post_link) ? 'w-3/4' : 'w-full'; ?> px-1">
                            <?php $get_pay_status = carbon_get_the_post_meta("crb_tasks_pay"); ?>
                            <div class="<?php echo ($get_pay_status == 'yes') ? 'bg-green-500 ' : 'bg-gray-800'; ?> <?php echo ($current_user_id == '1') ? 'task-pay-js' : ''; ?> text-white text-center rounded cursor-pointer px-2 py-1" data-post-id="<?php echo $current_id; ?>">
                              <div><?php echo ($get_pay_status == "yes") ? 'Оплачено' : 'Не оплачено'; ?></div>
                            </div>
                          </div>
                          <?php if ($task_post_link): ?>
                            <div class="w-1/4 px-1">
                              <?php $get_tasks_complete = carbon_get_the_post_meta("crb_tasks_complete"); ?>
                              <div class="btn-complete <?php echo ($get_tasks_complete == 'yes') ? 'bg-green-500 text-white' : 'border border-gray-800 text-gray-800'; ?> <?php echo ($current_user_id == '1') ? 'task-complete-js': ''; ?> flex items-center justify-center rounded cursor-pointer px-2 py-1" data-post-id="<?php echo $current_id; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                        
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php 
        // endif; 
        ?>
      <?php endforeach; wp_reset_postdata(); ?>
    </div>
  <?php endif; ?>
</div>


<!-- ОПЛАТА ЗА ТИЖДЕНЬ -->
<?php 
  $earnings_now = [];
  $quantities_now = [];
  foreach ($users as $user) {
    $earnings_now[$user['name']] = 0;
    $quantities_now[$user['name']] = 0;
  }
?>
<?php if ($tasks->have_posts()) : while ($tasks->have_posts()) : $tasks->the_post(); ?>
  <?php
    $author_write = carbon_get_the_post_meta("crb_tasks_author");
    $check_pay_status = carbon_get_the_post_meta("crb_tasks_pay");
    if ($check_pay_status != "yes" && isset($earnings_now[$author_write]) && $author_write !== 'Світлана') {
      if ($author_write === 'Лідія Кулик') {
        $earnings_now['Лідія Кулик'] += 225;
        $quantities_now[$author_write] += 1;
      } else {
        $earnings_now[$author_write] += 175;
        $quantities_now[$author_write] += 1;
        $earnings_now['Лідія Кулик'] += 50;
      }
    }
  ?>
<?php endwhile; endif; wp_reset_postdata(); ?>
<!-- END ОПЛАТА ЗА ТИЖДЕНЬ -->

<div class="modal px-8 py-6" data-modal-id="modal-pay">
  <div class="modal-content">
    <div class="modal-box w-2/3 bg-white min-h-full rounded-lg px-6 py-4">
      <div class="hidden flex-wrap bg-gray-200 rounded-lg p-1 mb-2">
        <div class="tab w-1/2 active" data-tab="week">За цей тиждень</div>
        <div class="tab w-1/2" data-tab="month">За <?php echo $months[$current_month]; ?></div>
      </div>
      <div  class="tab-content" data-content="week">
        <table class="w-full text-sm">
          <thead class="border-b border-gray-200 bg-black/80 text-gray-200 text-left">
            <tr>
              <th class="p-2">Автор</th>
              <th class="p-2">Кількість статей</th>
              <th class="p-2">Зароблено</th>
              <th class="p-2">Оплата</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-300">
            <?php
              arsort($quantities_now);
              $earnings_now = array_replace(array_flip(array_keys($quantities_now)), $earnings_now);
            ?>
            <?php foreach ($earnings_now as $author => $amount): ?>
              <tr class="odd:bg-white even:bg-gray-100 border-b user-row">
                <td class="border-r border-l p-2"><?php echo $author; ?></td>
                <td class="border-r p-2"><?php echo $quantities_now[$author] ?? 0; ?></td>
                <td class="border-r p-2"><?php echo $amount; ?> грн.</td>
                <td class="border-r p-2">
                  <div class="bg-gray-800 task-pay-js text-white text-center rounded cursor-pointer px-2 py-1 <?php echo ($current_user_id == '1') ? 'js-all-pay' :''; ?>" data-pay-author="<?php echo $author; ?>">Я оплатив!</div>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr class="border-b border-gray-200 bg-green-100 text-left">
              <td class="font-bold border-r border-l p-2">Загалом:</td>
              <td class="border-r border-l p-2"><?php echo array_sum($quantities_now); ?></td>
              <td class="border-r border-l p-2"><span id="all-work"><?php echo array_sum($earnings_now); ?> грн.</span></td>
              <td class="crossed"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>



<?php get_footer(); ?>