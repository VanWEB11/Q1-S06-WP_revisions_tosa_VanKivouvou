<?php
/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

//on récupère les catégories à afficher (pas les sous-catégories) dans $term_array
$terms_arg = array(
	'taxonomy'=>'categorie_produit',
	'orderby'=>'name',
	'parent'=>'0',
);

$terms_array = get_terms($terms_arg);

//je vais faire une boucle sur ce tableau $term_array pr ne garder que la proprièté 'slug' de chaque catégories. Je stocke ces slugs dans le tableau $slug_array
$slug_array = [];
foreach($terms_array as $term){
	$slug= $term->slug;
	array_push($slug_array, $slug);
}
?>
<main id="content" class="site-main" role="main">
<?php

// grâce aux slugs on peut faire une boucle html qui ssert à afficher chaque catégorie.
foreach($slug_array as $slug){
	include 'template-parts/categorie_produit.php';
}
?>
</main>
<?php


get_footer();
