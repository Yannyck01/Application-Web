<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Game;
use Entity\Genre;
use html\WebPage;

if (isset($_GET['genreId']) && ctype_digit($_GET['genreId'])) {
    $genreId = $_GET['genreId'];
} else {
    header('Location: index.php', true, 302);
    exit();
}

try{
    $games=Game::findByGenreId((int)$genreId);

} catch(EntityNotFoundException $e) {
    header('HTTP/1.1 404 Not Found');
    exit();
}

$webPage = new WebPage("Jeux vidéo : ");
$webPage->appendCssUrl("css/style.css");
$genreObject=Genre::findById((int) $genreId);
$webPage->appendContent("<div class='header'> <h1>Jeux vidéo : {$webPage->escapeString($genreObject->getDescription())}</h1></div>");

$webPage->appendContent('<div class="list">');
foreach ($games as $game) {
    $year = $game->getReleaseYear();
    $title = $game->getName();
    $posterId = $game->getPosterId();
    $description = $game->getShortDescription();
    $webPage->appendContent(<<<HTML
                <div class="game">
                    <div class="game__cover"><img src="poster.php?posterId=$posterId"></div>
                    <div class="game__details">
                        <div class="game__year">$year</div>
                        <div class="game__name">$title</div>
                        <div class="game__desc">$description</div>
                    </div>
                </div>
\n
HTML
    );
}
$webPage->appendContent("</div>");
echo $webPage->toHTML();

