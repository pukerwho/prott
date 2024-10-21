<?php get_header(); 
$current_user_id = get_current_user_id();
?>

<?php if ($current_user_id === 1): ?>


<div class="mb-6">
  <h1 class="text-2xl lg:text-3xl font-semibold mb-2"><?php echo get_the_archive_title(); ?></h1>
  <div class="card">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div class="border-b border-main-border px-4 py-4">
        <?php get_template_part("template-parts/posts/post-item"); ?>
      </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>
  </div>
  <div>
    <?php posts_nav_link(); ?>	
  </div>
</div>
<?php endif; ?>
<?php get_footer(); ?>