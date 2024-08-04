<div class="flex flex-col lg:flex-row">
  <div>
    <?php $medium_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>
    <?php if ($medium_thumb): ?>
      <div class="mb-4 lg:mb-0 mr-4">
        <img class="w-full lg:w-[200px] lg:max-w-[200px] h-[175px] lg:h-[125px] lg:min-h-[125px] object-cover rounded" alt="<?php the_title(); ?>" src="<?php echo $medium_thumb; ?>" loading="lazy">
      </div>
    <?php endif; ?>
  </div>
  <div>
    <div class="text-main-blue mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
    <div class="text-sm font-semibold mb-2"><?php echo get_the_date('d.m.Y'); ?></div>
    <div class="text-sm lg:pr-12">
      <?php 
        $content_text = wp_strip_all_tags( get_the_content() );
        echo mb_strimwidth($content_text, 0, 100, '...');
        unset($content_text);
      ?>
    </div>
  </div>
</div>