<?php 
/*
Template Name: Оплата
*/
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
      // 'after' => '33 days ago',
      'inclusive' => true,
    ),
  ),
);
$tasks = new WP_Query($args);

?>

<?php if ($current_user_id === 1 || $current_user_id === 2): ?>
<div class="container py-4">
  <div class="flex items-center justify-between mb-4">
    <div class="flex items-center space-x-4">
      <div class="relative bg-gray-600 text-white rounded cursor-pointer p-1">
        <a href="/" class="w-full h-full absolute top-0 left-0 z-1"></a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" /></svg>
      </div>
      <div class="text-lg font-bold">Оплата</div>
    </div>
    <div class="relative inline-flex items-center px-4 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg cursor-pointer">
      <a href="/pay" class="w-full h-full absolute top-0 left-0 z-1"></a>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
      Оплата
    </div>
  </div>
  
  <div class="day bg-white rounded-lg p-4 mb-4 last-of-type:mb-0">
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
                <div class="bg-gray-800 task-pay-js text-white text-center rounded cursor-pointer px-2 py-1 <?php echo ($current_user_id == '1') ? 'js-all-pay' :''; ?>" data-pay-author="<?php echo $author; ?>">Я оплатив</div>
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
<?php endif; ?>

<?php get_footer(); ?>