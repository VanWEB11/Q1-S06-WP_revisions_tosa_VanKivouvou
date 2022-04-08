
<div class ='categorie_produit'> 
<?php
$arg = array (
	//permet de séléctionner par post-type
	'post_type'=>'produit',
	// précise le nombre max de posts à afficher
	'posts_per_page'=> 4,
	//permet de selectionner par taxonnomie
	'tax_query' => array(
        array(
            'taxonomy' => 'categorie_produit',
            'field'    => 'slug',
			// c'est ici quon place le slug récupéré plus haut 
            'terms'    => $slug,
        ),
    ),

);
$query= new WP_Query( $arg );
if($query->have_posts()){
	while($query->have_posts()){
		$query->the_post();
		$image = get_the_post_thumbnail();
		$title= get_the_title();
		$description = get_the_excerpt();
		$url = get_post_permalink();
?>
			<a class="categorie_produit_item" href="<?=$url?>">
				<?=$image?>
				<h3><?=$title?></h3>
				<p><?=$description?></p>
			</a>

<?php
	}
}
?>
</div>
