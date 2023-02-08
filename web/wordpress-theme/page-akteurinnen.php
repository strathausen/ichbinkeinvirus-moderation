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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

parse_str($_SERVER['QUERY_STRING'], $get_parameters);

$where = 'published=1';

$location = $wpdb->_escape($get_parameters['location']);
$where.= $location != '' ? " AND (locations = 'bundesweit' OR FIND_IN_SET('$location', locations) > 0) " : '';

$offer = $wpdb->_escape($get_parameters['offer']);
$where.= $offer != '' ? " AND offers LIKE '%$offer%' " : '';

$search = $wpdb->_escape($get_parameters['search']);
$where.= $search != '' ? " AND lower(concat(description, name)) LIKE lower('%$search%') " : '';

$limit = $wpdb->_escape($get_parameters['limit']);
$limit = $limit == '' ? 20 : $limit;

$offset = $wpdb->_escape($get_parameters['offset']);

$query = "SELECT * FROM akteur_innen WHERE $where ORDER BY name";// LIMIT $limit";
$actors = $wpdb->get_results($query);

function shorten($in, $len) {
	return strlen($in) > 50 ? substr($in, 0, $len)."..." : $in;
}

get_header(); ?>

<script>
(function akteurInnenStart(){

var $ = jQuery;
$(document).ready(function() {
  function submitForm() {
    $('#ibkv-actor-form').submit();
  };
  $('#ibkv-actor-offer-select, #ibkv-actor-location-select').on('change', function() {
	submitForm();
  });
  var formElements = document.forms['ibkv-actor-form'].elements;
  jQuery('#ibkv-actor-form').on('submit', function(event) {
    var location = formElements.location.value;
    var offer = formElements.offer.value;
    var search = formElements.search.value;
    window.history.pushState("ibkv", "ibkv", "?" + jQuery.param({ search, location, offer }));
    jQuery('#ibkv-actor-list').addClass('loading');
    fetch(window.location).then(function(res) { return res.text(); }).then(function(html) {
      jQuery('#ibkv-actor-list').html(jQuery('#ibkv-actor-list', html));
	   jQuery('#ibkv-actor-list').removeClass('loading');
    });
    return false;
  })
});

})();
</script>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" class="<?php astra_primary_class(); ?>">

		<?php astra_primary_content_top(); ?>

		<?php astra_content_page_loop(); ?>
		<div class="button-container button-container--margin">
			<a href="/actor-form/">
				<button class="button-subpages" title="zum AkteurInnen-Formular">
					Akteur*innen hinzufügen
				</button>
			</a>
		</div>

		<article class="page-akteurinnen page type-page status-publish ast-article-single">
		<div class="actor-searchbar">
			<form id="ibkv-actor-form" class="ibkv-form">
				<div class="form-row">
					<div class="form-group col-md-4">
						<input name="search" placeholder="Dein Suchbegriff" class="form-control" value="<?=$search?>"/>
					</div>
					<div class="form-group col-md-4">
						<select id="ibkv-actor-offer-select" name="offer" class="custom-select">
							<option value="" <?=$offer == '' ? 'selected' : ''?>>Alle Akteur*innen</option>
							<?php
							foreach($offerOptions as $offerOption) {
								$selected = $offer == $offerOption ? 'selected' : '';
								echo "<option value=\"$offerOption\" $selected>".offerTranslation($offerOption)."</option>";
							}
							?>
						</select>
					</div>
					<div class="form-group col-md-4">
						<select id="ibkv-actor-location-select" name="location" class="custom-select">
							<option value="" <?=$location == '' ? 'selected' : ''?>>Alle Bundesländer</option>
							<?php
							foreach($locationOptions as $locationOption) {
								$selected = $location == $locationOption ? 'selected' : '';
								echo "<option value=\"$locationOption\" $selected>$locationOption</option>";
							}
							?>
						</select>
					</div>
				</div>
			</form>
		</div>
		<ul class="actor-list" id="ibkv-actor-list">
		<?php foreach($actors as $actor) {
			$website = json_decode($actor->website);
			$locations = explode(',', $actor->locations);
			$offers = array_map('offerTranslation', explode(',', $actor->offers));
		?>
			<li id="actor-<?=$actor->id?>" class="actor-card" data-offers="<?=$actor->offers?>" data-locations="<?=$actor->locations?>">
			<a href="/akteurin?id=<?=$actor->id?>">
				<div class="actor-name"><?=$actor->name?></div>
				<div class="actor-offers"><?=join(', ', $offers)?></div>
				<div class="actor-locations"><?=join(', ', $locations)?></div>
				<div class="actor-description"><?=shorten($actor->description, 350)?>
					<small><b>Weiterlesen</b></small>
				</div>
			</a>
			</li>
		<?php } ?>
		<?php if (count($actors) == 0) { ?>
			<li>Keine Ergebnisse gefunden.</li>
		<?php } ?>
		</ul>
		</article>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

