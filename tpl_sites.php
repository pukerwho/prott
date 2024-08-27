<?php
/*
Template Name: Сайти
*/
?>

<?php get_header(); $current_user_id = get_current_user_id(); ?>
<?php if ($current_user_id === 1): ?>
<div class="container py-12">
  <div class="flex items-center -mx-4 mb-6">
    <div class="websites tab active cursor-pointer px-4" data-tab="websites">
      <div><h2 class="text-3xl text-center font-bold p-4">👑 Основні сайти</h2></div>
    </div>
    <div class="drops tab cursor-pointer" data-tab="drops">
      <div><h2 class="text-3xl text-center font-bold p-4">🖇️ Дропи</h2></div>
    </div>
  </div>

  <div class="tab-content bg-white rounded p-8 mb-8 last-of-type:mb-0" data-content="websites">
    <?php get_template_part('template-parts/website-table'); ?>
  </div>

  <!-- Drop Table -->
  <div class="tab-content hidden bg-white rounded p-8 mb-8 last-of-type:mb-0" data-content="drops">
    <?php get_template_part('template-parts/drop-table'); ?>
  </div>

</div>
<div class="chart-week" data-week-array="<?php echo carbon_get_theme_option('crb_chart_week'); ?>"></div>
<div class="chart-week-drop" data-week-array="<?php echo carbon_get_theme_option('crb_chart_week_drops'); ?>"></div>
<?php endif; ?>
<?php get_footer(); ?>