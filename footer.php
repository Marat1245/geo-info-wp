<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GeoInfo
 */

?>
</div><!-- #content -->

<!-- NOTIFICATION -->
<?php get_template_part('component/notification'); ?>
<!-- NOTIFICATION END -->

<!-- MOBILE MENU -->
<?php get_template_part('component/menu/mobile-menu'); ?>
<!-- MOBILE MENU END -->

<!-- MOBILE SELECTOR -->
<?php get_template_part('component/menu/mobile-selector'); ?>
<!-- MOBILE SELECTOR END -->

<?php wp_footer(); ?>

</body>
</html>
