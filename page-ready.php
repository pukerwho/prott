<?php 
/*
Template Name: Готові
*/
get_header(); 
$current_user_id = get_current_user_id();

$args = array(
  'post_type' => 'tasks',
  'posts_per_page' => -1,
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key'     => '_crb_tasks_type',
      'value'   => 'collaborator',
      'compare' => 'LIKE',
    ),
    array(
      'key'     => '_crb_tasks_status',
      'value'   => 'Перевірено',
      'compare' => 'NOT LIKE',
    ),
    
  ),
  'date_query' => array(
    array(
      // 'after' => '8 days ago',
      'inclusive' => true,
    ),
  ),
);
$tasks = new WP_Query($args);

?>

<?php if ($current_user_id === 1 || $current_user_id === 3): ?>
<div class="container py-4">
  <div class="flex items-center justify-between mb-4">
    <?php if ($current_user_id === 1): ?>
    <div class="flex items-center space-x-6">
      <!-- Меню -->
      <div class="inline-flex items-center rounded-lg bg-white p-1 space-x-1">
        <a href="/" class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900">
          Всі
        </a>
        <a href="/write" class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900">
          З написанням
        </a>
        <a href="/ready" class="px-4 py-1.5 text-sm font-medium rounded-lg bg-gray-200 text-gray-900">
          Готові
        </a>
      </div>
    </div>
    
    <div class="relative inline-flex items-center px-4 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg cursor-pointer">
      <a href="/pay" class="w-full h-full absolute top-0 left-0 z-1"></a>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
      Оплата
    </div>
    <?php endif; ?>
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
            <th class="text-left whitespace-nowrap py-2 prott-sort-js" data-sort-id="3">
              <div class="flex items-center">
                <div class="text-left font-bold"><?php _e("Дата", "treba-wp"); ?></div>
                <div class="sort-arrow hidden ml-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
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
              $current_id = get_the_ID();
              $task_id = carbon_get_the_post_meta("crb_tasks_id");
              $get_status = carbon_get_the_post_meta("crb_tasks_status");
              $task_post_link = carbon_get_the_post_meta('crb_tasks_post_link');
              $task_type = carbon_get_the_post_meta('crb_tasks_type');
              $task_site = carbon_get_the_post_meta("crb_tasks_site");
              $is_collaborator = strpos($task_type, 'collaborator') !== false;
            ?>
            <tr class="border-b border-gray-200 last:border-transparent">
              <td class="whitespace-nowrap py-2">
                <div class="flex items-center">
                  <?php echo esc_html($task_id); ?>
                </div>
              </td>
              <td class="whitespace-nowrap py-2">
                <?php if ($task_post_link): ?>
                  <div class="flex items-center">
                    <div class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="12px" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h560v-280h80v280q0 33-23.5 56.5T760-120H200Zm188-212-56-56 372-372H560v-80h280v280h-80v-144L388-332Z"></path></svg></div>
                    <a href="<?php echo $task_post_link; ?>" target="_blank" class="text-blue-500"><?php echo $task_site; ?></a>
                  </div>
                <?php else: ?>
                  <?php echo $task_site; ?>
                <?php endif; ?>
              </td>
              <td class="whitespace-nowrap py-2">
                <div class="">
                  <span class="data-sort-prott"><?php 
                    echo get_the_date("d.m, H:i");
                    // echo carbon_get_the_post_meta('crb_tasks_date_create'); 
                  ?></span>
                </div>
              </td>
              <td class="whitespace-nowrap py-2">
                <div>
                  <div class="inline-flex bg-gray-200 text-gray-800 rounded text-center px-6 py-1 detail-click-js cursor-pointer" data-detail-id="<?php echo $current_id; ?>">Деталі</div>
                </div>
                
                <div class="detail-modal px-8 py-6 " data-detail-modal="<?php echo $current_id; ?>">
                  <div class="modal-content">
                    <?php 
                      $task_content = get_the_content();
                      $task_type = carbon_get_the_post_meta('crb_tasks_type');
                    ?>
                    <div class="modal-box w-full lg:w-3/4 min-h-full bg-white rounded-lg px-6 py-4">
                      <div class="text-xl mb-4">Завдання <?php echo carbon_get_the_post_meta('crb_tasks_id'); ?> - <span class="font-light text-gray-600"><?php echo carbon_get_the_post_meta('crb_tasks_site'); ?></span></div>
                      <?php 
                        $title = carbon_get_the_post_meta('crb_tasks_title');
                        $url = carbon_get_the_post_meta('crb_tasks_url');
                        $metaTitle = carbon_get_the_post_meta('crb_tasks_metatitle');
                        $metaDescription = carbon_get_the_post_meta('crb_tasks_metadescription');
                        $html = wp_kses_post(get_post_meta(get_the_ID(), '_crb_tasks_html', true));
                        $cleaned_html = remove_div_tags($html);
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

                      <!-- HTML статті -->
                      <div class="font-bold mb-1">Текст публікації:</div>
                      <?php 
                        $has_images = stripos($html, '&lt;img') !== false || stripos($html, '<img') !== false;
                      ?>
                      <div class="border border-gray-300 rounded-lg p-2 mb-2">
                        <pre class="h-64 overflow-auto whitespace-pre-wrap break-words bg-gray-100 p-4 rounded text-sm"><code class="download-html-source"><?php echo htmlspecialchars($cleaned_html); ?></code></pre>
                      </div>
                      <?php if ($has_images): ?>
                        <a href="<?php echo get_template_directory_uri(); ?>/inc/download-images.php?post_id=<?php echo $current_id; ?>" class="bg-gray-200 text-black text-center rounded-lg p-2 cursor-pointer mb-1 block" target="_blank">Завантажити картинки</a>
                      <?php endif; ?>
                      <div class="relative mb-4">
                        <div class="bg-gray-600 text-white text-center rounded-lg p-2 cursor-pointer copy-click" data-clipboard-text="<?php echo htmlspecialchars($cleaned_html); ?>">Скопіювати</div>
                        <div class="copy-tooltip hidden absolute -top-[4px] left-0 bg-black/80 text-white rounded text-center -translate-y-full px-2 py-1" data-copy-text="<?php echo htmlspecialchars($cleaned_html); ?>">Скопійовано 🙂</div>
                      </div>
                      <!-- Посилання -->
                      <div class="text-xl mb-2">Посилання на статтю</div>
                      <?php 
                        
                      if ($task_post_link): ?>
                        <a href="<?php echo $task_post_link; ?>" target="_blank"><?php echo $task_post_link; ?></a>
                      <?php else: ?> 
                        <?php 
                        $task_author_accept = carbon_get_the_post_meta('crb_tasks_author_accept'); if ($task_author_accept): ?>
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
                            <div class="italic">Треба прийняти завдання</div>
                          </div>
                        <?php endif; ?>
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
                  <?php 
                    $author_accept = carbon_get_the_post_meta('crb_tasks_author_accept');
                    $user_info = get_userdata($author_accept);
                    if ($user_info) {
                      echo esc_html($user_info->display_name);
                    } else {
                      echo 'Невідомий користувач';
                    } 
                  ?>
                <?php endif; ?>
              </td>
              <td class="whitespace-nowrap py-2">
                <?php if ($get_status === 'Нове завдання'): ?>
                  <div class="task-accept flex items-center justify-center bg-blue-500 text-white rounded text-center cursor-pointer px-6 py-1 task-accept-js" data-post-id="<?php echo $current_id; ?>" data-author-accept="<?php echo $current_user_id; ?>">
                    <div class="mr-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                    </div>
                    <div>Прийняти</div>
                  </div>
                <?php else: ?>
                  <?php if ($task_post_link): ?>
                    <?php $get_tasks_complete = carbon_get_the_post_meta("crb_tasks_complete"); ?>
                    <?php if ($get_tasks_complete == 'yes'): ?>
                      <div class="border border-green-500 bg-green-500 text-white rounded text-center px-6 py-1">Перевірено</div>
                    <?php else: ?>
                      <div class="btn-complete btn-complete-ready border border-green-500 rounded text-center cursor-pointer px-6 py-1 <?php echo ($current_user_id == '1') ? 'task-complete-js': ''; ?>" data-post-id="<?php echo $current_id; ?>">На перевірці</div>
                    <?php endif; ?>
                    
                  <?php else: ?>
                    <div class="border border-blue-500 rounded text-center px-6 py-1">В роботі</div>
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