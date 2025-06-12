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