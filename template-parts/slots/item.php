<div class="relative">
  <a href="<?php the_permalink(); ?>" class="w-full h-full absolute top-0 left-0 z-1"></a>
  <?php $large_thumb = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?> 
  <img src="<?php echo $large_thumb; ?>"  alt="<?php echo get_the_title(); ?>" loading="lazy" class="w-full h-full rounded-lg">
</div>