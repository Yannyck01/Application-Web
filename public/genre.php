<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Game;
use Entity\Genre;
use Html\WebPage;

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

$genreObject=Genre::findById((int) $genreId);
$webPage = new WebPage();
$webPage->setTitle("Jeux vidéo : {$webPage->escapeString($genreObject->getDescription())}");
$webPage->appendCssUrl("css/style.css");
$webPage->appendContent(<<<HTML
    <div class='header'> 
        <h1>Jeux vidéo : {$webPage->escapeString($genreObject->getDescription())}</h1>
        <button class ='homepage' type='button'>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
          <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
          <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
        </svg>
        </button>
    </div>
HTML);

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
                            <div class="game__details2">
                                <div class="game__name">$title</div>
                                <div class="game__year"> ($year)</div>
                            </div>
                            <div class="game__desc">$description</div>
                    </div>
                </div>
\n
HTML
    );
}
$webPage->appendContent("</div>");
echo $webPage->toHTML();

