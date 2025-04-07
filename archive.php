<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GeoInfo
 */

get_header();
$post_type = get_post_type();
?>

<div class="seamless_bg">

	<div class="seamless_bg_grad"></div>
	<!-- Artical -->
	<section class="container main_block inner_page inner_page_archives news_list_page two_block_grid"
		data-post-type="<?= $post_type; ?>">

		<div class="inner_menu inner_menu_fixed">

			<?php get_template_part('component/menu/menu'); ?>
			<?php
			// БЛОК СО СПНСОРАМИ
			get_template_part('template-parts/sponsors');
			?>

		</div>

		<div class=" show_list_wrap">

			<div
				class="content_block preprints_wraps archive_list <?= $post_type == 'post_users' ? 'post_users_wraps' : ''; ?>">

				<?php
				// ВСТАВЛЯЕМ ТАЙТЛ
				get_template_part('component/tags/tags_search');

				if ($post_type == 'news') { ?>
					<div class="news paper">
						<div class="new_list upload_list" id="news-container">
							<?php
							PostController::show_post(1, $post_type);
							?>
						</div>
					</div>
					<?php
				} else if ($post_type == 'post_users') { ?>
						<div class="post_users_wraps">
							<div class="posts upload_list" data-type="post_users ">

								<?php
								// ВСТАВЛЯЕМ ПОСТЫ                        
								PostController::show_post(1, 'post_users');
								?>

							</div>
						</div>
				<?php } else if ($post_type == 'post') { ?>
							<div class="posts upload_list">

							<?php
							// ВСТАВЛЯЕМ ПОСТЫ                        
							PostController::show_post(1, 'post');
							?>
							</div>
				<?php } ?>

			</div>
		</div>

	</section>

	<!-- Artical END /-->
</div>

<?php

get_footer();