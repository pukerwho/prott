<?php
/*
Template Name: Сайти
*/
?>

<?php get_header(); $current_user_id = get_current_user_id(); ?>
<?php if ($current_user_id === 1): ?>
<div class="container py-4">

  <div class="tab-content bg-white rounded-xl px-4 py-6 mb-8 last-of-type:mb-0" data-content="websites">
    <?php get_template_part('template-parts/website-table'); ?>
  </div>

</div>
<div class="chart-week" data-week-array="<?php echo carbon_get_theme_option('crb_chart_week'); ?>"></div>
<div class="chart-week-drop" data-week-array="<?php echo carbon_get_theme_option('crb_chart_week_drops'); ?>"></div>
<?php endif; ?>
<?php get_footer(); ?>