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
        <button class ='homepage' type='button'>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
          <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
          <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
        </svg>
        </button>
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
