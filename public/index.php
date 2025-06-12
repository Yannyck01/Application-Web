<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use Html\WebPage;

$pageTest = new WebPage("Page d'accueil");
$pageTest->appendCssUrl("css/style.css");

$pageTest->appendContent(<<<HTML
    <div class="header">
        <h1>Jeux vidéo</h1>
        
    </div>
    <div class='list__genre'>
        <div class='genre'>
            <h1>Genres</h1>\n
HTML);

$genres = GenreCollection::findAll();
$categories = CategoryCollection::findAll();

foreach ($genres as $genre) {
    $pageTest ->appendContent("<p><a href='genre.php?genreId={$genre->getId()}'>{$pageTest->escapeString($genre->getDescription())}</a></p>\n");
}

$pageTest->appendContent(<<<HTML
        </div>
        <div class='categories'>
            <h1>Catégories</h1>\n
 HTML);

foreach ($categories as $category) {
    $pageTest->appendContent("<p><a href='category.php?idCtg={$category->getId()}'>{$pageTest->escapeString($category->getDescription())}</a></p>\n");
}

$pageTest->appendContent("</div>\n</div>");
echo $pageTest->toHTML();
