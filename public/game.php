<?php
declare(strict_types=1);

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

$webPage->appendContent(<<<HTML
    <div class="gameD__cover"><img src="poster.php?posterId={$game->getPosterId()}"></div>
    <div class="gameD__dev">{$game->getDeveloperId()}</div>
    <div class="gameD__note">{$game->getMetacritic()}</div>
    <div class="gameD__price">{$priceEuro}€</div>
    <div class="gameD__desc">{$game->getShortDescription()}</div>
HTML);
echo $webPage->toHTML();