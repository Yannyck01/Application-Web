<?php
declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use Entity\Developer;
use Entity\Exception\EntityNotFoundException;
use Entity\Game;
use Html\WebPage;

if (isset($_GET['gameId']) && ctype_digit($_GET['gameId'])) {
    $gameId = $_GET['gameId'];
} else {
    header('Location: index.php', true, 302);
    exit();
}

try{
    $game = Game::findById((int)$gameId);

} catch(EntityNotFoundException $e) {
    header('HTTP/1.1 404 Not Found');
    exit();
}
$webPage = new WebPage();
$webPage->setTitle("Jeux vidéo : {$webPage->escapeString($game->getName())}");
$webPage->appendCssUrl("css/style.css");
$webPage->appendContent("<div class='header'> <h1>Jeux vidéo : {$webPage->escapeString($game->getName())}</h1></div>");
$webPage->appendContent('<div class="list">');
$priceEuro=$game->getPrice()/10;
$dev = Developer::findById($game->getDeveloperId());

$webPage->appendToHead(<<<HTML
    <a href="index.php" class="homepage">
        <button class ='homepage' type='button' >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
              <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
              <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
            </svg>
        </button>
    </a>
HTML);

$webPage->appendContent(<<<HTML
    <div class="gameD__container">
        <div class="gameD__cover">
            <img src="poster.php?posterId={$game->getPosterId()}">
            <div class="gameD__dev">{$dev->getName()}</div>
        </div>
    </div>
    <div class="gameD__infos">
        <div class="gameD__topline">
            <div class="gameD__note">{$game->getMetacritic()}</div>
            <div class="gameD__price">{$priceEuro}€</div>
        </div>
    </div>
    
    <div class="gameD__desc">{$game->getShortDescription()}</div>
HTML);

$genres=GenreCollection::findByGameId((int) $gameId);
$webPage->appendContent("<div class='gameD__genres'><h3>Genres : </h3>");
foreach ($genres as $genre){
    $webPage->appendContent("<div class='gameD__genre'>\n<p><a href='genre.php?genreId={$genre->getId()}'>{$webPage->escapeString($genre->getDescription())}</a></p></div>");
}

$webPage->appendContent("</div>");

$categories=CategoryCollection::findByGameId((int) $gameId);
$webPage->appendContent("<div class='gameD__ctg'><h3>Catégories : </h3>");
foreach ($categories as $category){
    $webPage->appendContent("<div class='gameD__genre'>\n<p><a href='category.php?idCtg={$category->getId()}'>{$webPage->escapeString($category->getDescription())}</a></p></div>");
}

$webPage->appendContent("</div>");


echo $webPage->toHTML();