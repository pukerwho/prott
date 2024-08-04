<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package G-Info
 */

get_header();
?>

	<main id="primary" class="bg-gray-100 pt-10 pb-10">

		<div class="container px-2 lg:px-0 mx-auto">
			<div class="w-9/12 bg-white rounded-lg p-5 mx-auto">
				<h1 class="text-3xl lg:text-5xl font-semibold mb-4"><?php _e('Упс, такой страницы нет', 'g-info'); ?></h1>
				<div class="text-lg text-gray-700">
					<?php _e('Предлагаем воспользоваться поиском, либо перейти на главную страницу сайта', 'q-info'); ?>
				</div>
				<div class="mt-8 mb-4">
					<a href="<?php echo home_url(); ?>" class="bg-indigo-500 rounded-lg text-white hover:bg-white hover:text-gray-700 px-6 py-4">
						<?php _e('На главную', 'g-info'); ?>
					</a>
				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php get_footer(); ?>