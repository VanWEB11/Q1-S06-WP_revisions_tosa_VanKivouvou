# Implémentation du fichier ``index.php``

on récupère le fichier ``ìndex.php`` dans le thème parent et on copie dans le thème enfant, à la racine.    o   n récupère la balise ``main`` dans le dossier ``/template-parts/archive.php`` dans le thème parent.

Je construit en html/css les 4 blocs qui contiendront chacun une catégorie parmi *video*,*audio*,*jeux video*,*livre*. Chaque blocs contiendront à son tour 4 produits. On met en place le dispplay flex dans chacun de ces blocs pr respecter l'affichage qui nous convient.

On se rend compte que le code se répète de nombreuses fois, pr chq articles et chq catégories. Nous allon essayer de factoriser le code le code pour éviter cette répétiton.

Avant cela, il va faloir récupérer les produits (et leurs informations) qui nous intéressent ... Càd : les custom potst de types ```produits``, qui répondent à une certaines catégories de produit (audio ou livre ou vidéo ou jeux video). C'est la classe ``WP_Query`` qui va permettre cela. On doit lui donner en arguments un tableau avec une architecture bien précise : chaque index de ce tableau précisera un critères de sélection des custom-posts.``posts_type`` précisera le type de custom-post,``tax_query`` précisera à l'intérieur d'un tableau, quelle taxonnomie il foudra respecter, ``posts_per_page`` permettra de ne sélectionner que 4 articles (par défaut, les 4 plus récents)
```php
$args = array(
    'post_type'=>'produit',
    'posts_per_page'=>4,
    'tax_query'=>array(
        array(
            'taxonomy'=>'categorie_produit',
            'field'=>'slug',
            'terms'=>'audio',
        ),
    ),
);
```
On va **instancier** la classe ``WP_Query`` pour créer une objet (= une *instance*) qui contiendra les produits que nous souhaitons afficher. On va nommer cet objet ``$loop``. On dit que ``$loop`` est une *instance* de ``WP_Query``. On peut maintenant appliquer les *méthodes* définies dans ``WP_Query`` sur ``$loop``, notamment : ``have_posts()``. C'est cette même méthode qui va permettre de boucler sur ``$loop`` et de traiter, dans cette boucle, chaque produit, à tour de rôle.
```php
$loop = new WP_Query($args);

if($loop->have_posts()){
    while($loop->have_posts()){
        $loop->the_post();
    }
}
```
On peut maintenant récupérer les infos sur le produit qui est traité dans la boucle. On va stocker chacune de ces informations dans une variable : ``$titre``, ``$description``, ``$image`` et ``$url`` avec les fonctions respectives ``get_the_title()``, ``get_the_excerpt()``, ``get_the_post_thumbnail()`` et ``get_the_permalink()``. On place ensuite le bloc qui sert à aficher un produit dans une catégorie, dans la boucle, et on remplace les données 'en dur' par les variables en PHP que l'on vient de voir.

On peut maintenant répéter ce code pour chaque catégorie et remplacer la ligne ``terms => audio,''par le slug de la catégorie qui nous intéresse, ET C TOUT...Donc , on répéte le code pour juste une information qui va être modifié d'ou la nécessité de factoriser encore le code.

On va devoir récupérer toutes les catégories 'parents' (qui ne sont pas des sous-catégories) et boucler sur celle-ci et afficher le slug de chacune à l'endroit précisé précédemment, à la place de ``audio``.

Pour récupérer les catégories de produit dans un tableau ``: 
```php
$args = array(
    'taxonnomy'=>'categorie_produit',
    'parent'=>'0',
    'orderby'=>'name',
);
$categories_array = get_terms($args);
```
Je peux maintenant boucler sur ce tableau et utiliser le bloc défini pour chaque catégorie dans cette boucle : on remplacera juste le slug de la catégorie.

````php
foreach($categorie_array as $categorie){
    ?>
    <div class="categorie_produit">
    <?php
    $slug = $categorie->slug;
    $args = array(
        'post_type'=>'produit',
        'posts_per_page'=>4,
        'tax_query'=>array(
            array(
                'taxonomy'=>'categorie_produit',
                'field'=>'slug',
                'terms'=>$slug,
            ),
        ),
    );
    ...
}
```
on peut supprimer tout le code superflu en dehors de la boucle. Pour finir, il convient de placer tout ce qui concerne l'affichage dans un template dans ``template-parts`` et d'appeler avec la fonction ``include()`` ce template.
