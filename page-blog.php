<?php
/*
Template Name: БЛОГ
*/
?>

<?php get_header(); ?>


<div>
  <h1 class="text-2xl lg:text-3xl font-semibold mb-4"><?php the_title(); ?></h1>
  <div class="card mb-6">
    <?php 
      $top_post = new WP_Query( array( 
        'post_type' => 'post', 
        'posts_per_page' => -1,
      ) );
      if ($top_post->have_posts()) : while ($top_post->have_posts()) : $top_post->the_post(); 
    ?>
      <div class="border-b border-main-border px-4 py-4">
        <?php get_template_part("template-parts/posts/post-item"); ?>
      </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>
  </div>
</div>

<?php get_footer(); ?>