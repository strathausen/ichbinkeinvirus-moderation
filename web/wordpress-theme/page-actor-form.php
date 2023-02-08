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

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php astra_content_page_loop(); ?>
		<article class="page type-page status-publish ast-article-single">
<?php
// If the form is submitted
if (isset($_POST['actor-name']) && $_POST['actor-name'] !== '' && $_POST['actor-offers'] !== '' && $_POST['actor-description'] !== '') {
	$rawWebsite = $_POST['actor-website'];
	if (preg_match('#^((https?://)|www\.?)#i', $url) !== 1) {
		$websiteWithHttp = 'https://' . $rawWebsite;
	} else {
		$websiteWithHttp = $rawWebsite;
	}
	$wpdb->insert(
		'akteur_innen',
		array(
			'name' => $_POST['actor-name'],
			'website' => json_encode(array('label' => $rawWebsite, 'url' => $websiteWithHttp, 'target' => '')),
			'offers' => implode(',', $_POST['actor-offers']),
			'locations' => implode(',', $_POST['actor-locations']),
			'description' => $_POST['actor-description'],
		),
	);
	echo '
	<p>Dein Beitrag wurde erfolgreich abgeschickt. Danke, dass du dich für das Thema einsetzt.</p>
	<p>Wenn dein Beitrag von uns geprüft und freigeschaltet wird, kannst du diesen dann unter <a href="akteurinnen/" style="color: #565656; text-decoration: underline;">Akteur*innen</a> finden.</p>
	';
} else {
?>
<!----------------------------------------- BOOTSTRAP FORM   ---------------------------------------------->
			
			<p>
				Du solltest von Betroffenen gefunden werden oder möchtest sie empowern? Hier hast du die Möglichkeit, dich auf unserer Plattform sichtbar zu machen. Nutze hierfür das folgende Formular und lass es uns zukommen.<br><br>Wenn du in mehreren Bundesländern aktiv bist oder du mehrere Inhalte anbietest, kannst du eine Mehrfachauswahl durch "Command" gedrückt halten + Klick auf die entsprechenden Positionen tätigen. Bitte trag dich hier nur ein, wenn du selber des Angebots angehörig bist. Sobald wir den Inhalt geprüft haben, stellen wir dich oder dein Angebot live. <br><br> Bitte beachte, dass die * - Felder ausgefüllt sein müssen. <br><br>Vielen Dank für dein Engagement und deine Arbeit!<br><br>
			</p>
<form id="actor-form" method="post" class="ibkv-form">

	<div class="form-group">
		<label for="label_description">Kurzbeschreibung*</label>
		<textarea class="form-control" id="label_description" rows="5" name="actor-description"><?=$_POST['actor-description']?></textarea>
	</div>
	<p></p>
	<div class="row">
		<div class="col-12 col-md-6">
			<label for="label_locations">Wo bist du aktiv?*</label>
			<select class="custom-select" name="actor-locations[]" id="label_locations" multiple>
				<option value="bundesweit" selected>Alle Bundesländer</option>
				<?php
					foreach($locationOptions as $location) {
						echo "<option>$location</option>";
					}
				?>
			</select>
		</div>
		<div class="col-12 col-md-6">
			<label for="label_offers">Was bietest du an?*</label>
			<select class="custom-select" name="actor-offers[]" id="label_offers" multiple>
				<?php
					foreach($offerOptions as $offer) {
						echo "<option value=\"$offer\">".offerTranslation($offer)."</option>";
					}
				?>
			</select>
		</div>
	</div>
	<p></p>
  	<div class="row">
		<div class="col-12 col-md-6">
			<label for="label_name">Name*</label>
      		<input type="text" class="form-control form-control-sm" value="<?=$_POST['actor-name']?>" id="label_name" name="actor-name">
		</div>
		<div class="col-12 col-md-6">
			<label for="label_name">Website*</label>
      		<input type="text" class="form-control form-control-sm" value="<?=$_POST['actor-website']?>" id="label_website" name="actor-website">
		</div>
	</div>
	<div class="button-container button-container--margin">
		<button class="button-subpages" type="submit" title="AkteurIn abschicken">
			Abschicken
		</button>
	</div>
	
</form>

<?php
}
?>
		</article>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

