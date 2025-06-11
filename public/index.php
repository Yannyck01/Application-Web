<?php

declare(strict_types=1);

use Html\WebPage;

$pageTest = new WebPage("Page d'accueil");
$pageTest->appendCssUrl("css/style.css");

$pageTest->appendContent("<h1>Jeux vidéo</h1>");

$pageTest->appendContent("<div class='list'>");
$pageTest->appendContent("<div class='genre'><h1>Genres</h1>");

$genres = \Entity\Collection\GenreCollection::findAll();
$categories = \Entity\Collection\CategoryCollection::findAll();

foreach ($genres as $genre) {
    $pageTest ->appendContent("<p><a href='genre.php?genreId={$genre->getId()}'>{$pageTest->escapeString($genre->getDescription())}</a></p>");
}
$pageTest->appendContent("</div>");
$pageTest->appendContent("<div class='categories'><h1>Catégories</h1>");
foreach ($categories as $category) {
    $pageTest->appendContent("<p><a href='category.php?idCtg={$category->getId()}'>{$pageTest->escapeString($category->getDescription())}</a></p>");
}
$pageTest->appendContent("</div>");


echo $pageTest->toHTML();
