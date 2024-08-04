<?php get_header(); ?>

<div class="container my-6">
  <h1 class="text-3xl lg:text-4xl text-center text-white font-extrabold -rotate-1 mb-6"><span class="bg-black/90 rounded px-4 py-2"><?php the_title(); ?></span></h1>
  <div class="w-full lg:w-2/3 content mx-auto">
    <?php the_content(); ?>
  </div>
</div>

<?php get_footer(); ?>