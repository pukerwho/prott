<?php 
get_header(); 
$current_user_id = get_current_user_id();
?>

<?php if ($current_user_id === 1 || $current_user_id === 2): ?>
<div class="container py-12">
  <h2 class="text-3xl text-center font-bold mb-6">💪 Всі завдання</h2>
  <div class="flex space-x-4 mb-6">
    <div class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 cursor-pointer modal-open-js" data-modal-id="modal-pay">
      <div class="mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[21px] h-[21px]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
      </div>
      <div>Оплата</div>
    </div>
  </div>
  <?php $tasks = new WP_Query( array( 'post_type' => 'tasks', 'posts_per_page' => 90) );?>
  <?php 
  $posts_by_day = array_reduce( $tasks->posts, function( $r, $v ) {
    $r[ date( 'Y-m-d', strtotime( $v->post_date ) ) ][] = $v;
    return $r;  
  });
  ?>

  <?php if ( $posts_by_day ) : ?>
    <div class="day-posts">
      <?php $current_week = array_slice($posts_by_day, 0, 7); ?>
      <?php foreach( $current_week as $day => $day_posts ) : ?>
        <?php 
          $month = date( 'm', strtotime( $day ) );
          $current_month = date('n');
          // if ($month === $current_month ): 
        ?>
        <div class="day bg-white rounded p-8 mb-8 last-of-type:mb-0">
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
                              <option value="Ана-Катаріна Кузмицька">Ана-Катаріна Кузмицька</option>
                              <option value="Лідія Кулик">Лідія Кулик</option>
                              <option value="Світлана">Світлана</option>
                              <option value="Аліна Трикіша">Аліна Трикіша</option>
                              <option value="Настя Можаровська">Настя Можаровська</option>
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
                              <div class="<?php echo ($get_tasks_complete == 'yes') ? 'bg-green-500 text-white' : 'border border-gray-800 text-gray-800'; ?> <?php echo ($current_user_id == '1') ? 'task-complete-js': ''; ?> flex items-center justify-center rounded cursor-pointer px-2 py-1" data-post-id="<?php echo $current_id; ?>">
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

      <?php $mykolaev = 0; $kuzmitska = 0; $major = 0; $svitlana = 0; $trikisha = 0; ?>
      <?php $current_week = array_slice($posts_by_day, 0, 7); ?>
      <?php foreach( $current_week as $day => $day_posts ) : ?>
        <!-- stat -->
        <?php 
          $month = date( 'm', strtotime( $day ) );
          $current_month = date('n');
          // if ($month === $current_month): 
        ?>
        
          <?php foreach( $day_posts as $post ) : setup_postdata( $post ); ?>
            <?php
              $author_write = carbon_get_the_post_meta("crb_tasks_author");
              $check_pay_status = carbon_get_the_post_meta("crb_tasks_pay");
              if ($check_pay_status != "yes") {
                if ($author_write === 'Лідія Кулик') {
                  $mykolaev = $mykolaev + 225;
                } elseif ($author_write === 'Ана-Катаріна Кузмицька') {
                  $kuzmitska = $kuzmitska + 175;
                  $mykolaev = $mykolaev + 50;
                } elseif ($author_write === 'Аліна Трикіша') {
                  $trikisha = $trikisha + 175;
                  $mykolaev = $mykolaev + 50;
                } elseif ($author_write === 'Настя Можаровська') {
                  $major = $major + 175;
                  $mykolaev = $mykolaev + 50;
                } elseif ($author_write === 'Світлана') {
                  $svitlana = $svitlana + 175;
                  $mykolaev = $mykolaev + 50;
                }
              }
            ?>
          <?php endforeach; ?>
        
        <?php 
          // endif; 
        ?>
      <?php endforeach; wp_reset_postdata(); ?>
      
    </div>
  <?php endif; ?>
</div>

<div class="modal px-8 py-6" data-modal-id="modal-pay">
  <div class="modal-content">
    <div class="modal-box w-2/3 bg-white min-h-full rounded-lg px-6 py-4">
      <div class="flex flex-wrap justify-between items-center border-b border-gray-300 border-dashed mb-2 pb-2">
        <div class="flex items-center">
          <div class="mr-2">Лідія Кулик</div>
          <div class="font-bold"><?php echo $mykolaev; ?> грн.</div>
        </div>
        <div class="w-1/3">
          <div class="bg-gray-800 task-pay-js text-white text-center rounded cursor-pointer px-2 py-1 <?php echo ($current_user_id == '1') ? 'js-all-pay' :''; ?>" data-pay-author="Лідія Кулик">Я оплатив!</div>
        </div>
      </div>
      <div class="flex flex-wrap justify-between items-center border-b border-gray-300 border-dashed mb-2 pb-2">
        <div class="flex items-center">
          <div class="mr-2">Ана-Катаріна Кузмицька</div>
          <div class="font-bold"><?php echo $kuzmitska; ?> грн.</div>
        </div>
        <div class="w-1/3">
          <div class="bg-gray-800 task-pay-js text-white text-center rounded cursor-pointer px-2 py-1 <?php echo ($current_user_id == '1') ? 'js-all-pay' :''; ?>" data-pay-author="Ана-Катаріна Кузмицька">Я оплатив!</div>
        </div>
      </div>
      <div class="flex flex-wrap justify-between items-center border-b border-gray-300 border-dashed mb-2 pb-2">
        <div class="flex items-center">
          <div class="mr-2">Настя Можаровська</div>
          <div class="font-bold"><?php echo $major; ?> грн.</div>
        </div>
        <div class="w-1/3">
          <div class="bg-gray-800 task-pay-js text-white text-center rounded cursor-pointer px-2 py-1 <?php echo ($current_user_id == '1') ? 'js-all-pay' :''; ?>" data-pay-author="Настя Можаровська">Я оплатив!</div>
        </div>
      </div>
      <div class="flex flex-wrap justify-between items-center border-b border-gray-300 border-dashed mb-2 pb-2">
        <div class="flex items-center">
          <div class="mr-2">Аліна Трикіша</div>
          <div class="font-bold"><?php echo $trikisha; ?> грн.</div>
        </div>
        <div class="w-1/3">
          <div class="bg-gray-800 task-pay-js text-white text-center rounded cursor-pointer px-2 py-1 <?php echo ($current_user_id == '1') ? 'js-all-pay' :''; ?>" data-pay-author="Аліна Трикіша">Я оплатив!</div>
        </div>
      </div>
      <div class="flex flex-wrap justify-between items-center border-b border-gray-300 border-dashed mb-2 pb-2">
        <div class="flex items-center">
          <div class="mr-2">Світлана</div>
          <div class="font-bold"><?php echo $svitlana; ?> грн.</div>
        </div>
        <div class="w-1/3">
          <div class="bg-gray-800 task-pay-js text-white text-center rounded cursor-pointer px-2 py-1 <?php echo ($current_user_id == '1') ? 'js-all-pay' :''; ?>" data-pay-author="Світлана">Я оплатив!</div>
        </div>
      </div>
      <div class="flex flex-wrap justify-between items-center">
        <div class="flex items-center text-lg">
          <div>Загалом:</div>
        </div>
        <div class="w-1/3">
          <span class="font-bold"><?php $total = $mykolaev + $trikisha + $kuzmitska + $major + $svitlana; echo $total; ?></span> грн.
        </div>
      </div>
    </div>
  </div>

  
</div>
<?php endif; ?>

<!-- For Month -->
<div class="hidden container mx-auto mb-16">
  <?php 
  $tasks_month = new WP_Query( array( 'post_type' => 'tasks', 'posts_per_page' => 1) );
  $tasks_month_posts_by_day = array_reduce( $tasks_month->posts, function( $r, $v ) {
    $r[ date( 'Y-m-d', strtotime( $v->post_date ) ) ][] = $v;
    return $r;  
  });
  $mykolaev_month = 0;
  $kuzmitska_month = 0;
  $trikisha_month = 0;
  $major_month = 0;
  $svitlana_month = 0;

  $mykolaev_qty = 0;
  $kuzmitska_qty = 0;
  $trikisha_qty = 0;
  $major_qty = 0;
  $svitlana_qty = 0;
  foreach( $tasks_month_posts_by_day as $day => $day_posts ) : ?>
    <?php 
      $month = date( 'm', strtotime( $day ) );
      $current_month = date('n');
      if ($month === '01' ): 
    ?>
      <?php foreach( $day_posts as $post ) : setup_postdata( $post ); ?>
        <?php
        
          $author_write = carbon_get_the_post_meta("crb_tasks_author");

          if ($author_write === 'Лідія Кулик') {
            $mykolaev_month = $mykolaev_month + 200;
            $mykolaev_qty = $mykolaev_qty + 1;
          } elseif ($author_write === 'Ана-Катаріна Кузмицька') {
            $kuzmitska_month = $kuzmitska_month + 150;
            $kuzmitska_qty = $kuzmitska_qty + 1;
            $mykolaev_month = $mykolaev_month + 50;
          } elseif ($author_write === 'Аліна Трикіша') {
            $trikisha_month = $trikisha_month + 150;
            $trikisha_qty = $trikisha_qty + 1;
            $mykolaev_month = $mykolaev_month + 50;
          } elseif ($author_write === 'Настя Можаровська') {
            $major_month = $major_month + 150;
            $major_qty = $major_qty + 1;
            $mykolaev_month = $mykolaev_month + 50;
          } elseif ($author_write === 'Світлана') {
            $svitlana_month = $svitlana_month + 150;
            $svitlana_qty = $svitlana_qty + 1;
            $mykolaev_month = $mykolaev_month + 50;
          }
        ?>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endforeach; ?>
  <div>
    <table class="min-w-full border border-gray-300 shadow-lg rounded-lg overflow-hidden">
      <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
        <tr>
          <th class="px-6 py-3 text-left">Автор</th>
          <th class="px-6 py-3 text-left">Кількість статей</th>
          <th class="px-6 py-3 text-left">Зароблено</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-300">
        <tr class="hover:bg-gray-100">
          <td class="px-6 py-4">Лідія Кулик</td>
          <td class="px-6 py-4"><?php echo $mykolaev_qty; ?></td>
          <td class="px-6 py-4"><?php echo $mykolaev_month; ?></td>
        </tr>
        <tr class="hover:bg-gray-100">
          <td class="px-6 py-4">Ана-Катаріна Кузмицька</td>
          <td class="px-6 py-4"><?php echo $kuzmitska_qty; ?></td>
          <td class="px-6 py-4"><?php echo $kuzmitska_month; ?></td>
        </tr>
        <tr class="hover:bg-gray-100">
          <td class="px-6 py-4">Аліна Трикіша</td>
          <td class="px-6 py-4"><?php echo $trikisha_qty; ?></td>
          <td class="px-6 py-4"><?php echo $trikisha_month; ?></td>
        </tr>
        <tr class="hover:bg-gray-100">
          <td class="px-6 py-4">Настя Можаровська</td>
          <td class="px-6 py-4"><?php echo $major_qty; ?></td>
          <td class="px-6 py-4"><?php echo $major_month; ?></td>
        </tr>
        <tr class="hover:bg-gray-100">
          <td class="px-6 py-4">Світлана</td>
          <td class="px-6 py-4"><?php echo $svitlana_qty; ?></td>
          <td class="px-6 py-4"><?php echo $svitlana_month; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?php get_footer(); ?>