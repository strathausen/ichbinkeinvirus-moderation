<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

global $wpdb;
$items = $wpdb->get_results("SELECT * FROM ibkv_reports WHERE published=1 ORDER BY ID DESC");

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>



<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php astra_content_page_loop(); ?>
		
		<div class="button-container button-container--margin">
			<a href="/report-form/">
				<button class="button-subpages" title="zum Bericht-Formular">
					Erfahrungsbericht teilen
				</button>
			</a>
		</div>

		<article class="page-erfahrungsberichte page type-page status-publish ast-article-single">

			
		<!--<ul style="list-style: none">-->
		<?php foreach($items as $item) {
		?>
			<div id="actor-<?=$item->id?>" class="report-card col-sm" data-offers="<?=$item->offers?>" data-locations="<?=$actor->locations?>">
				<span class="report-teaser"><a href="/erfahrungsbericht?id=<?=$item->id?>"><?=stripslashes($item->teaser)?> <small><b>Weiterlesen</b></small></a> </span>
				<p class="page-erfahrungsberichte-info erfahrungsberichte-info-fontsize">
					<span class="report-when"><?=$item->happened_at?></span> /
					<span class="report-where"><?=$item->happened_where?></span> / 
					<span class="report-name">Von <?=$item->name?></span>
				</p>
			</div>
			
		<?php } ?>
		<!--</ul>-->
			
		</article>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

