<?php get_header(); ?>
<div class="container pt-20 lg:pt-32">
  <h1 class="text-4xl font-bold mb-6"><?php printf( esc_html__('Результаты поиска', 'tarakan' )); ?></h1>
  <div class="mb-6">
    <form role="search" method="get" class="search-form flex items-center relative" action="<?php echo home_url( '/' ); ?>">
      <div class="absolute left-3 top-3 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
        </svg>  
      </div>
      <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" class="w-full border border-gray-300 text-gray-700 shadow-sm rounded px-4 pl-10 py-2" placeholder="<?php _e('Поиск', 'tarakan'); ?>" />
      <input type="hidden" name="post_type" value="places" />
      <input type="submit" class="search-submit hidden" value="<?php echo esc_attr_x( 'Найти', 'submit button' ) ?>" />
    </form>
  </div>
  <div class="flex flex-wrap md:-mx-4 mb-6">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <div class="w-full md:w-1/2 lg:w-1/3 md:px-4 mb-8">
        <?php get_template_part('template-parts/places/modern-style-other'); ?>
      </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>
  </div>
</div>
<?php get_footer(); ?>