<?php
/*
Template Name: OLD
*/
?>

<?php 
get_header(); 
$current_user_id = get_current_user_id();
?>

<?php if ($current_user_id === 1): ?>
<div class="container py-12">
  <div class="flex flex-wrap lg:-mx-2">
    <div class="w-full lg:w-1/5 lg:px-2 mb-6 lg:mb-0">
      <div class="order tab active cursor-pointer mb-2" data-tab="order">
        <div class="flex items-center p-4">
          <div class="mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
            </svg>
          </div>
          <div>Замовлення</div>
        </div>
      </div>
      <div class="tasks tab cursor-pointer" data-tab="tasks">
        <div class="flex items-center p-4">
          <div class="mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
            </svg>
          </div>
          <div>Архів задач</div>
        </div>
      </div>
    </div>
    <div class="w-full lg:w-4/5 lg:px-2">
      <div class="tab-content bg-white rounded px-8 py-6" data-content="order">
        <?php
        $collab_one = carbon_get_theme_option('crb_collab_one');
        $collab_two = carbon_get_theme_option('crb_collab_two');
        $opts_one = array( "ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,), 'http'=>array('method'=>"GET",'header'=>"X-Api-Key: $collab_one\r\n" . "accept: application/json\r\n"));
        $opts_two = array( "ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,), 'http'=>array('method'=>"GET",'header'=>"X-Api-Key: $collab_two\r\n" . "accept: application/json\r\n"));

        $context_one = stream_context_create($opts_one);
        $context_two = stream_context_create($opts_two);
        $file_one = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?per-page=40&page=1&language=ua", false, $context_one); 
        // $file_one_twopage = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?page=2&language=ua", false, $context_one); 
        $file_two = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?per-page=40&page=1&language=ua", false, $context_two); 
        // $file_two_twopage = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?page=2&language=ua", false, $context_two); 

        $items_one = json_decode($file_one, true);
        $items_two = json_decode($file_two, true);
        $items_one_twopage = json_decode($file_one_twopage, true);
        $items_two_twopage = json_decode($file_two_twopage, true);
        $items = array_merge($items_one['items'], $items_two['items']);

        function array_orderby() {
          $args = func_get_args();
          $data = array_shift($args);
          foreach ($args as $n => $field) {
            if (is_string($field)) {
              $tmp = array();
              foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
          }
          $args[] = &$data;
          call_user_func_array('array_multisort', $args);
          return array_pop($args);
        }
        $sortItems = array_orderby($items, 'id', SORT_DESC);
        ?>        
        <div>
          <h2 class="text-3xl font-bold mb-4">Замовленя</h2>
          <table class="w-full table-auto">
            <thead class="border-b border-gray-200 text-gray-600">
              <tr>
                <th class="text-left whitespace-nowrap py-2">
                  <div class="text-left font-bold"><?php _e("ID", "treba-wp"); ?></div>
                </th>
                <th class="text-left whitespace-nowrap py-2">
                  <div class="text-left font-bold"><?php _e("Сайт", "treba-wp"); ?></div>
                </th>
                <th class="text-left whitespace-nowrap py-2">
                  <div class="text-left font-bold"><?php _e("Статус", "treba-wp"); ?></div>
                </th>
                <th class="text-left whitespace-nowrap py-2">
                  <div class="text-left font-bold"><?php _e("Дата", "treba-wp"); ?></div>
                </th>
                <th class="text-left whitespace-nowrap py-2">
                  <div class="text-left font-bold"><?php _e("Деталі", "treba-wp"); ?></div>
                </th>
                <th class="text-left whitespace-nowrap py-2">
                  <div class="text-left font-bold"><?php _e("Хто пише", "treba-wp"); ?></div>
                </th>
              </tr>
            </thead>
            <tbody class="text-sm">
            <?php foreach ($sortItems as $i): ?>
              <?php 
              $status = $i['status'];
              $publicationType = $i['publicationType'];
              if ($status === 'В роботі' && $publicationType === 'Ви пишете'): ?>
                <?php 
                  $task_id = $i['id']; 
                  $get_task_id = get_task_ID($task_id);
                ?>
                <tr class="border-b border-gray-200 last:border-transparent">
                  <td class="whitespace-nowrap py-2"><?php echo $i['id'] ?></td>
                  <td class="whitespace-nowrap py-2"><?php echo $i['site'] ?></td>
                  <td class="whitespace-nowrap py-2">
                    <?php if (!$get_task_id): ?>
                      <div class="flex items-center">
                        <div class="w-[8px] h-[8px] rounded-full bg-yellow-400 mr-2"></div>
                        <div>Нове завдання</div>
                      </div>
                      <?php else: ?>
                      <?php $get_status = carbon_get_post_meta($get_task_id[0]->post_id, "crb_tasks_status"); 
                      if ($get_status === 'В процесі написання'): ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] rounded-full bg-blue-400 mr-2"></div>
                          <div>В процесі написання</div>
                        </div>
                      <?php elseif ($get_status === 'На перевірці'): ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] rounded-full bg-green-400 mr-2"></div>
                          <div>На перевірці</div>
                        </div>
                      <?php else: ?>
                        <div class="flex items-center">
                          <div class="w-[8px] h-[8px] bg-green-400 mr-2"></div>
                          <div><?php echo $get_status; ?></div>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>
                  </td>
                  <td class="whitespace-nowrap py-2">
                    <div class="text-blue-500 date-click-js cursor-pointer" data-date-id="<?php echo $i['id']; ?>"><?php echo date("d.m, H:i", strtotime($i['createdAt'])); ?></div>
                    <div class="date-modal px-8 py-6 " data-date-modal="<?php echo $i['id']; ?>">
                      <div class="modal-content">
                        <div class="modal-box max-w-[640px] min-h-full bg-white rounded-lg px-6 py-4">
                          <div class="text-xl mb-2">Дата і час</div>
                          <div class="flex items-center mb-3 last-of-type:mb-0">
                            <div class="mr-2">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            </div>
                            <div>Створена заявка: <?php echo date("d.m, H:i ", strtotime($i['createdAt'])); ?></div>
                          </div>
                          <?php if (!empty($get_task_id)): ?>
                            <div class="flex items-center mb-3 last-of-type:mb-0">
                              <div class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                              </div>
                              <div>Передано копірайтеру: <?php echo get_the_date('d.m, H:i', $get_task_id[0]->post_id); ?></div>
                            </div>
                            <?php 
                            $get_task_link_date = carbon_get_post_meta($get_task_id[0]->post_id, "crb_tasks_link_date");
                            if ($get_task_link_date): ?>
                              <div class="flex items-center">
                                <div class="mr-2">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" /></svg>
                                </div>
                                <div>Додано посилання: <?php echo $get_task_link_date; ?></div>
                              </div>
                            <?php endif; ?>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <!-- Детальніше -->
                  <td class="whitespace-nowrap py-2">
                    <div class="text-blue-500 detail-click-js cursor-pointer" data-detail-id="<?php echo $i['id']; ?>">Детальніше</div>
                    <div class="detail-modal px-8 py-6 " data-detail-modal="<?php echo $i['id']; ?>">
                      <div class="modal-content">
                        <div class="modal-box max-w-[640px] min-h-full bg-white rounded-lg px-6 py-4">
                          <div class="text-xl mb-2">Завдання <?php echo $i['id'] ?></div>
                          <div class="content text-balance mb-4">
                            <?php echo nl2br($i['task']['task']); ?>
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
                            <?php foreach ($i['task']['anchors'] as $anchor): ?>
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
                          <!-- Кнопки -->
                          <!-- Перевіряємо, чи є вже таке завдання -->
                          <?php if (!$get_task_id): ?>
                          <div class="task-btns hidden items-center -mx-1">
                            <div class="w-1/2 px-1">
                              <div class="task-accept flex items-center justify-center bg-green-500 text-white rounded text-center cursor-pointer px-4 py-2" data-task-id="<?php echo $i['id'] ?>" data-task-user="<?php echo $current_user_id; ?>" >
                                <div class="mr-2">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                </div>
                                <div>Прийняти</div>
                              </div>
                            </div>
                            <div class="w-1/2 px-1">
                              <div class="task-delivery flex items-center justify-center bg-blue-500 text-white rounded text-center cursor-pointer px-4 py-2" data-task-id="<?php echo $i['id'] ?>" data-task-user="<?php echo $current_user_id; ?>">
                                <div class="mr-2">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" /></svg>
                                </div>
                                <div>Передати</div>
                              </div>
                            </div>
                          </div>
                          <?php endif; ?>
                          <div class="task-wait hidden" >
                            <div class="flex items-center justify-center bg-black/70 text-white rounded text-center cursor-pointer px-4 py-2">
                              <div class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                              </div>
                              <div>Чекайте...</div>
                            </div>
                          </div>
                          <div class="task-create hidden">
                            <div class="bg-green-200 rounded px-4 py-2">
                              <span class="task-create-accept hidden">Чудово, ви прийняли завдання. Оновіть сторінку.</span>
                              <span class="task-create-delivery hidden">Чудово, ви передали завдання. Оновіть сторінку та оберіть автора.</span>
                            </div>
                          </div>
                          <!-- END Кнопки -->
                          <!-- Посилання -->
                          <div class="text-xl mb-2">Посилання на статтю</div>
                          <?php $task_post_link = carbon_get_post_meta($get_task_id[0]->post_id, "crb_tasks_post_link"); if ($task_post_link): ?>
                            <a href="<?php echo $task_post_link; ?>"><?php echo $task_post_link; ?></a>
                          <?php else: ?> 
                            <div>
                              <div class="mb-2"><input type="text" class="task-link w-full border border-gray-200 bg-gray-100 rounded px-4 py-2" data-inputlink-id="<?php echo $i['id'] ?>"></div>
                              <div class="task-link-js" data-post-id="<?php echo $get_task_id[0]->post_id; ?>" data-task-id="<?php echo $i['id'] ?>"><div class="bg-blue-500 text-white text-center rounded cursor-pointer px-4 py-2">Відправити</div></div>
                            </div>
                          <?php endif; ?>
                          <!-- END Посилання -->
                        </div>
                      </div>
                    </div>
                  </td>
                  <!-- Хто пише -->
                  <td class="who-write whitespace-nowrap py-2">
                    <!-- Чи є вже таке завдання/ Прийнято чи ні -->
                    <?php if (!$get_task_id): ?>
                      <!-- Якщо завдання такого немає, то показуємо кнопку Прийняти -->
                      <div class="task-accept flex items-center justify-center bg-blue-500 text-white rounded text-center cursor-pointer px-2 py-1" data-task-id="<?php echo $i['id'] ?>" data-task-user="<?php echo $current_user_id; ?>" >
                        <div class="mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        </div>
                        <div>Прийняти</div>
                      </div>
                    <?php else: ?>
                      <!-- Якщо вже є таке завдання, то перевіряємо чи вибран автор -->
                      <?php 
                      $author = carbon_get_post_meta($get_task_id[0]->post_id, "crb_tasks_author");
                      if ($author): ?>
                        <div class="author-block">
                          <div class="flex items-center">
                            <div class="mr-2"><?php echo carbon_get_post_meta($get_task_id[0]->post_id, "crb_tasks_author"); ?></div>
                            <div class="change-author-js">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                              </svg>
                            </div>
                          </div>
                        </div>
                      <?php else: ?>
                        <!-- Обираємо автора -->
                        <div>
                          <div class="flex items-center">
                            <div class="mr-2">
                              <select class="author-select" name="select-author-name" data-select-id="<?php echo $i['id'] ?>">
                                <option selected>Оберіть автора</option>
                                <option value="Каріна Туленіна">Каріна Туленіна</option>
                                <option value="Катерина Кузмицька">Катерина Кузмицька</option>
                                <option value="Лідія Миколаїв">Лідія Миколаїв</option>
                                <option value="Світлана">Світлана</option>
                              </select>
                            </div>
                            <div class="task-author-js" data-task-id="<?php echo $i['id'] ?>" data-task-site="<?php echo $i['site'] ?>">
                              <div class="flex items-center bg-blue-500 text-white rounded cursor-pointer px-2 py-1">
                                <div class="mr-2">Save</div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                                </svg>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>
                    <!-- Блок заміни автора -->
                    <div class="hidden change-author-block">
                      <div class="flex items-center">
                        <div class="mr-2">
                          <select class="author-select" name="select-author-name" data-select-id="<?php echo $i['id'] ?>">
                            <option selected>Оберіть автора</option>
                            <option value="Каріна Туленіна">Каріна Туленіна</option>
                            <option value="Катерина Кузмицька">Катерина Кузмицька</option>
                            <option value="Лідія Миколаїв">Лідія Миколаїв</option>
                            <option value="Світлана">Світлана</option>
                          </select>
                        </div>
                        <div class="task-author-js" data-task-id="<?php echo $i['id'] ?>" data-task-site="<?php echo $i['site'] ?>">
                          <div class="flex items-center bg-blue-500 text-white rounded cursor-pointer px-2 py-1">
                            <div class="mr-2">Save</div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                            </svg>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-content hidden bg-white rounded px-8 py-6" data-content="tasks">
        <h2 class="text-3xl font-bold mb-4">Всі задачі</h2>
        <?php $tasks = new WP_Query( array( 'post_type' => 'tasks', 'posts_per_page' => -1) );?>
        <?php 
        $posts_by_day = array_reduce( $tasks->posts, function( $r, $v ) {
          $r[ date( 'Y-m-d', strtotime( $v->post_date ) ) ][] = $v;
          return $r;  
        });
        ?>

        <?php if ( $posts_by_day ) : ?>
          <div class="day-posts">
            <?php foreach( $posts_by_day as $day => $day_posts ) : ?>
              <div class="day mb-8">
                <div class="text-lg font-bold mb-2"><?php echo date( 'd.m', strtotime( $day ) ); ?></div>
                <div class="posts">
                  <table class="w-full table-auto">
                    <thead class="border-b border-gray-200 text-gray-600">
                      <tr>
                        <th class="text-left whitespace-nowrap py-2">
                          <div class="text-left font-bold"><?php _e("ID", "treba-wp"); ?></div>
                        </th>
                        <th class="text-left whitespace-nowrap py-2">
                          <div class="text-left font-bold"><?php _e("Сайт", "treba-wp"); ?></div>
                        </th>
                        <th class="text-left whitespace-nowrap py-2">
                          <div class="text-left font-bold"><?php _e("Статус", "treba-wp"); ?></div>
                        </th>
                        <th class="text-left whitespace-nowrap py-2">
                          <div class="text-left font-bold"><?php _e("Дата", "treba-wp"); ?></div>
                        </th>
                        <th class="text-left whitespace-nowrap py-2">
                          <div class="text-left font-bold"><?php _e("Автор", "treba-wp"); ?></div>
                        </th>
                        <th class="text-left whitespace-nowrap py-2">
                          <div class="text-left font-bold"><?php _e("Посилання", "treba-wp"); ?></div>
                        </th>
                        <th class="text-left whitespace-nowrap py-2">
                          <div class="text-left font-bold"><?php _e("Оплата", "treba-wp"); ?></div>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="text-sm">
                      <?php foreach( $day_posts as $post ) : setup_postdata( $post ); ?>
                        <tr class="border-b border-gray-200 last:border-transparent">
                          <td class="whitespace-nowrap py-2"><?php echo carbon_get_the_post_meta("crb_tasks_id"); ?></td>
                          <td class="whitespace-nowrap py-2"><?php echo carbon_get_the_post_meta("crb_tasks_site"); ?></td>
                          <td class="whitespace-nowrap py-2">
                            <?php $get_status = carbon_get_the_post_meta("crb_tasks_status"); 
                            if ($get_status === 'В процесі написання'): ?>
                              <div class="flex items-center">
                                <div class="w-[8px] h-[8px] rounded-full bg-blue-400 mr-2"></div>
                                <div>В процесі написання</div>
                              </div>
                            <?php elseif ($get_status === 'На перевірці'): ?>
                              <div class="flex items-center">
                                <div class="w-[8px] h-[8px] rounded-full bg-green-400 mr-2"></div>
                                <div>На перевірці</div>
                              </div>
                            <?php else: ?>
                              <div class="flex items-center">
                                <div class="w-[8px] h-[8px] bg-green-400 mr-2"></div>
                                <div><?php echo $get_status; ?></div>
                              </div>
                            <?php endif; ?>
                          </td>
                          <td class="whitespace-nowrap py-2">
                            <div>
                              <?php 
                                $author_date = carbon_get_the_post_meta("crb_tasks_author_date"); 
                                $author_date = date('Y-m-d H:i:s', $author_date);
                                if ($link_date) {
                                  $link_date = carbon_get_the_post_meta("crb_tasks_link_date"); 
                                  $link_date = date('Y-m-d H:i:s', $link_date);
                                }
                                $current_time = current_time( 'timestamp' );
                                $current_time = date('Y-m-d H:i:s', $current_time);
                                if (!$link_date) {
                                  $start_datetime = new DateTime($author_date);
                                  $diff = $start_datetime->diff(new DateTime($current_time)); 
                                  $hours = $diff->h;
                                  echo '<div class="text-gray-700">'. $hours .' годин</div>';
                                } else {
                                  $start_datetime = new DateTime($author_date);
                                  $diff = $start_datetime->diff(new DateTime($link_date)); 
                                  $hours = $diff->h;
                                  if ($hours > 12) {
                                    echo '<div class="text-red-500">'. $hours .' годин</div>';
                                  } else {
                                    echo '<div class="text-green-500">'. $hours .' годин</div>';
                                  }
                                  // echo $link_date;
                                }
                              ?>
                            </div>
                          </td>
                          <td class="whitespace-nowrap py-2"><?php echo carbon_get_the_post_meta("crb_tasks_author"); ?></td>
                          <td class="whitespace-nowrap py-2">
                            <?php $get_task_link = carbon_get_the_post_meta("crb_tasks_post_link");
                            if ($get_task_link): ?>
                              <a href="<?php echo carbon_get_the_post_meta("crb_tasks_post_link"); ?>" class="text-blue-500">Link</a>
                            <?php endif; ?>
                          </td>
                          <td class="whitespace-nowrap py-2" data-post-id="<?php echo get_the_ID(); ?>">
                            <?php $get_pay_status = carbon_get_the_post_meta("crb_tasks_pay"); 
                            if ($get_pay_status === 'Оплачено'): ?>
                              <div class="task-pay-success-js bg-green-500 text-white text-center rounded cursor-pointer px-2 py-1" data-post-id="<?php echo get_the_ID(); ?>">
                                Оплачено
                              </div>
                            <?php else: ?>
                              <div class="task-pay-js task-pay-wait-js bg-gray-800 text-white text-center rounded cursor-pointer px-2 py-1" data-post-id="<?php echo get_the_ID(); ?>">
                                Не оплачено
                              </div>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            <?php endforeach; wp_reset_postdata(); ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
  
</div>
<?php endif; ?>
<?php 

?>
<?php get_footer(); ?>