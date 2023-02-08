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
parse_str($_SERVER['QUERY_STRING'], $get_parameters);
$id = $wpdb->_escape($get_parameters['id']);
$report = $wpdb->get_row("SELECT * FROM ibkv_reports WHERE id=$id AND published=1");

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

		
		<article class="page-erfahrungsbericht page type-page status-publish ast-article-single">
			<div id="actor-<?=$report->id?>" class="report-detail-card">
				<div class="report-where"><?=$report->happened_where?></div>
				<div class="report-date"><?=$report->happened_at ? date_format(date_create($report->happened_at), 'd.m.Y') : ''?></div>
				<div class="report-reported"><?=!is_null($report->reported) ? ($report->reported ? "Gemeldet" : "Nicht gemeldet") : '' ?></div>
				<div class="report-found-solution"><?=!is_null($report->found_solution) ? 'Lösung gefunden: ' . $report->found_solution : '' ?></div>
				<p class="report-text"><?=nl2br(stripslashes($report->text))?></p>
			</div>
			<div class="button-container button-container--margin">
				<a href="/erfahrungsberichte/">
					<button class="button-subpages" title="zum Bericht-Formular">
						zurück zu allen Erfahrungsberichten
					</button>
				</a>
			</div>
		</article>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

