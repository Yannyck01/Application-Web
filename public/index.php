<?php

declare(strict_types=1);

use Html\WebPage;

$pageTest = new WebPage("Page d'accueil");

$pageTest->appendContent("<h1>Jeux vidéo</h1>");

$pageTest->appendContent("<div class='list'>");

$genres = \Entity\Collection\GenreCollection::findAll();
$categories = \Entity\Collection\CategoryCollection::findAll();

foreach ($genres as $genre) {
    $pageTest ->appendContent("<p><a href='genre?Id = {$genre->getId()}'><br>{$pageTest->escapeString($genre->getDescription())}</a></p><br>");
}
foreach ($categories as $category) {
    $pageTest->appendContent("<p><a href='category?Id = {$category->getId()}'><br>");
}
echo $pageTest->toHTML();
