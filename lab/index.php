<?php
$lg="fr";
if (isset($_COOKIE['l']))
	$lg=$_COOKIE['l'];
if (isset($_GET['l']))
	if ($_GET['l']!=""){ 
		setcookie ("l",$_GET['l'], time() - 3600);
		setcookie ("l",$_GET['l'], time() + 31536000, "/");
		$lg=$_GET['l'];
	}
?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="author" content="/* / */" />
    <title>Crotos Lab</title>
    <link rel="icon" href="../favicon.ico" />
    <link rel="stylesheet" href="styles.css">
  	<script src="../js/jquery.js"></script>
<script>
$(document).ready(function(){ 
	$('#lg').change(function() {
		$('#lgform').submit();
	});
}); 

    </script>
</head>
<body>

<?php include "entete.php" ?>
<form id="lgform">
<h1>Crotos Lab - <select name="l" id="lg">
<?php 
$lgs=array("en","fr");
include "../traduction.php";
include "../functions.php";
for ($i=0;$i<count($lgs);$i++){
    echo "				<option value=\"".translate($lgs[$i],"lang_code")."\"";
	if ($lg==$lgs[$i])
		 echo " selected=\"selected\"";
	echo " >".translate($lgs[$i],"lg")."</option>\n";	
}
?></select></h1>
</form>
<ul id="stuff">
	<li><?php
if ($lg=="fr")
	echo "<a href=\"artworks/\">Liste d'œuvres d'art sur Wikidata par collection ou créateur</a><br />
	Cet outil permet de créer des listes d'œuvres par collection ou créateur, d'en choisir les métadonnées et de disposer d'un fichier au format CSV téléchargeable.";
else
	echo "<a href=\"artworks/?l=en\">Wikidata artworks items by collection or creator</a><br />
	This tool allows you to create lists of works by collection or creator, to choose the metadata and to have a file in CSV format downloadable.";
?></li>
	<li><a href="prop_nb.php"><?php
if ($lg=="fr")
	echo "Nombre d'œuvres d'art par propriété</a></br>
	En choississant une propriété (type, collection, genre...), cet outil permet d'en lister par ordre décroissant le nombre d'œuvres correspondantes et de les afficher.";
else
	echo "Number of visual artworks items by property</a><br/>
	By choosing a property (type, collection, genre ...), this tool allows to list in descending order the number of corresponding artworks and display them.";
?></li>
    <li><a href="updates.php"><?php
if ($lg=="fr")
	echo "Mises à jour du contenu de Crotos</a><br/>
	Tableau des mises à jour de Crotos (tous les 3 jours), actif depuis août 2015, qui permet de suivre les évolutions du contenu publié et de retrouver par date de mise en ligne les œuvres ou images.";
else
	echo "Content updates on Crotos</a><br/>
	Chart updates Crotos (every 3 days), active since August 2015, which tracks the developments of the published content and allows to retrieve by of publication artworks or images.";
echo "";

?></li>
    <li><a href="cpt_lg"><?php
if ($lg=="fr")
	echo "Occurences des langues selon les libellés</a><br/>
	Ce tableau affiche les volumes correspondants aux libellés selon les langues pour toutes les valeurs correspondant à toutes les propriétés utilisées (titre, auteur, élément iconographique, mouvement...). C'est un bon indicateur des dynamiques de contribution par langue.";
else
	echo "Languages occurences from labels</a><br />
	This table displays the corresponding volumes in different languages for all values of all the properties used (title, creator, depicts, movement ...). This is a good indicator of the contribution dynamics by language .";
?></li>
    <li><a href="collections"><?php
if ($lg=="fr")
	echo "Statistiques par collections</a><br/>
	Cet outil donne des indicateurs sur le nombre d'œuvres par collection mais également sur leur indexation (proportion avec numéro d'inventaire, date, créateur ou nombre moyen d'éléments iconographiques).";
else
	echo "Artworks of the Musée du Louvre by rooms</a><br />
	This tool provides indicators on the number of artworks by collection but also on indexing (proportion with inventory number, date, or creator average number of iconographic elements).";
?></li>
    <li><a href="louvre-rooms"><?php
if ($lg=="fr")
	echo "Œuvres du musée du Louvre par salles</a><br/>
	Cet outil liste les salles du Louvre et pointe vers les listes d'œuvres correspondantes, en mentionnant également les œuvres dont l'image est manquante.";
else
	echo "Artworks of the Musée du Louvre by rooms</a><br />
	This tool lists the halls of the Louvre and points to the lists of corresponding artworks, also mentioning the artworks where the image is missing.";
?></li>
    <li><a href="cropper/"><?php
if ($lg=="fr")
	echo "Cropper</a><br/>
Petit outil outil pour générer des valeurs de fragments d'image pour la propriété <a href=\"https://www.wikidata.org/wiki/Property:P2677\" target=\"_blank\">position relative dans l'image / P2677</a> dans Wikidata, avec URLs <a href=\"http://www.iiif.io\" target=\"_blank\">IIIF</a>.";
else
	echo "Cropper</a><br/>
A simple little tool to provide values of image fragments for the Wikidata property <a href=\"https://www.wikidata.org/wiki/Property:P2677\" target=\"_blank\">relative position within image / P2677</a>, with <a href=\"http://www.iiif.io\" target=\"_blank\">IIIF</a> URLs.";
?></a></li>
    <li><a href="../callisto/"><?php
if ($lg=="fr")
	echo "Callisto</a><br/>
	Carte interactive pour explorer et visualiser œuvres, musées et éléments dépeints selon leur géolocalisation.";
else
	echo "Callistos</a><br/>
Interactive map to explore and visualize material, museum items and portrayed them as geolocation.";
?></a></li>

</ul>
<p id="source">
Source: <a href="https://github.com/zone47/CROTOS" class="externe">Github/Crotos</a>
</p>
</body>
</html>