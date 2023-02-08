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
/*
if (
	isset($_POST['report-name']) && $_POST['report-name'] !== '' &&
	isset($_POST['report-email']) && $_POST['report-email'] !== '' &&
	isset($_POST['report-what']) && $_POST['report-what'] !== ''
) {
	$wpdb->insert(
		'ibkv_reports',
		array(
			'name' => $_POST['report-name'],
			'email' => $_POST['report-email'],
			'happened_at' => $_POST['report-when'],
			'happened_where' => $_POST['report-where'],
			'reported' => $_POST['report-reported'],
			'found_solution' => $_POST['report-solution'],
			'text' => $_POST['report-what'],
		),
	);
	echo '
	<p>Dein Erfahrungsbericht wurde erfolgreich abgeschickt. Danke, dass du mit uns allen deine Erfahrung teilst!</p>
	<p>Wenn dein Bericht von uns geprüft und freigeschaltet wird, kannst du diesen dann unter <a href="/erfahrungsberichte/" style="text-decoration: underline;">Erfahrungen</a> finden.</p>
	';
} else {
?>
<!----------------------------------------- BOOTSTRAP FORM   ---------------------------------------------->

			Schön, dass du dich entschlossen hast deine Erfahrungen mit anderen zu teilen. Wir finden, dass sehr mutig von dir.<br>

Bitte beachte, dass die * - Felder ausgefüllt sein müssen.<br><br>

		<span>Dein Eintrag wird erst geprüft und wird dann nach der Freischaltung bei Erfahrungen zu sehen sein.<br>
		Wir geben unser Bestes, dass dein Eintrag so schnell möglich veröffentlicht wird.</span><br><br><br>
		<!--	<p><b>Das Formular ist vorübergehend nicht verfügbar. Wir sind bald wieder für euch da</b></p>-->

		
<form id="report-form" method="post" class="ibkv-form">

	<div class="form-group">
		<label for="label_what" required>Was ist passiert? *</label>
		<textarea class="form-control" required id="label_what" rows="5" name="report-what"><?=$_POST['report-what']?></textarea>
	</div>
	
	<div class="row">
		<div class="col col-md-6">
			<label for="label_where">Wo ist es passiert?</label>
		  	<input type="text" class="form-control form-control-sm" id="label_where" name="report-where" placeholder="z.B. Stadt XY, Supermarkt, U-Bahn, etc.">
		</div>
		<div class="col-12 col-md-6">
			<label for="label_when" name="report-when">Wann ist es passiert?</label>
    		<input class="form-control form-control-sm" type="date" value="" id="label_when" name="report-when">
		</div>
	</div>
	
	<p></p>
	
	<div class="row">
		<div class="col-12 col-md-6">
			<label for="label_solution">Konntest du eine Lösung erzielen?</label>
		  <input type="text" class="form-control form-control-sm" id="label_solution" name="report-solution">
		</div>
		
		<div class="col-12 col-md-6">
			<label for="label_reported">Hast du den Vorfall gemeldet?</label>
			<select class="custom-select" id="label_reported" name="report-reported">
				<option value="0">Nein</option>
				<option value="1">Ja</option>
			</select>
    	</div>
  	</div>
	
	<p></p>
	<div class="row">
		<div class="col-12 col-md-6">
			<label for="label_name">Name *</label>
      		<input type="text" class="form-control form-control-sm" value="<?=$_POST['report-name']?>" id="label_name" name="report-name" placeholder="z.B. Vorname, Nickname, Synonym, etc." required>
		</div>
		<div class="col-12 col-md-6">
			<label for="label_name">E-Mail *</label>
      		<input type="text" class="form-control form-control-sm" value="<?=$_POST['report-email']?>" id="label_email" name="report-email" required>
		</div>
	</div>
	<div class="button-container button-container--margin">
			<button class="button-subpages" type="submit" title="Erfahrungsbericht abschicken">
				Abschicken
			</button>
	</div>
	
</form>

<?php
}
*/
?>
		</article>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

