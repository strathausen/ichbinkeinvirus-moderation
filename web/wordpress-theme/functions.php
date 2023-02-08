<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
 
    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
    wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
    wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js');
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version') );
    wp_enqueue_style( 'child-style-1', get_stylesheet_directory_uri() . '/page-akteurin.css', array( $parent_style ), wp_get_theme()->get('Version') );
    wp_enqueue_style( 'child-style-2', get_stylesheet_directory_uri() . '/page-akteurinnen.css', array( $parent_style ), wp_get_theme()->get('Version') );
    wp_enqueue_style( 'child-style-3', get_stylesheet_directory_uri() . '/page-erfahrungsbericht.css', array( $parent_style ), wp_get_theme()->get('Version') );
    wp_enqueue_style( 'child-style-4', get_stylesheet_directory_uri() . '/page-erfahrungsberichte.css', array( $parent_style ), wp_get_theme()->get('Version') );
    wp_enqueue_style( 'child-style-5', get_stylesheet_directory_uri() . '/page-report-form.css', array( $parent_style ), wp_get_theme()->get('Version') );
}


function offerTranslation($offerCode) {
	$offerTranslations = array(
		"actor" => "Akteur*in",
		"help_offer" => "Hilfsangebot",
		"art" => "Kunst",
		"event" => "Veranstaltung",
		"culture" => "Kultur",
		"podcast" => "Podcast",
		"project" => "Projekt",
		"organization" => "Organisation"
	);
	return $offerTranslations[$offerCode] ?? $offerCode;
}

$offerOptions = array('actor','organization','help_offer','project','art','event','culture','podcast');
$locationOptions = array('Baden-Württemberg', 'Bayern', 'Berlin', 'Brandenburg', 'Bremen', 'Hamburg', 'Hessen', 'Mecklenburg-Vorpommern', 'Niedersachsen', 'Nordrhein-Westfalen', 'Rheinland-Pfalz', 'Saarland', 'Sachsen', 'Sachsen-Anhalt', 'Schleswig-Holstein', 'Thüringen');



