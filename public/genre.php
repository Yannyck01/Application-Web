<?php
declare(strict_types=1);

use Entity\Game;
use html\WebPage;

if (isset($_GET['genreId']) && ctype_digit($_GET['genreId'])) {
    $genreId = $_GET['genreId'];
} else {
    header('Location: index.php', true, 302);
    exit();
}


$games=Game::findByGenreId((int)$genreId);
$webPage = new WebPage("Jeux vidéo : ");
$webPage->appendCssUrl("css/style.css");
$webPage->appendContent("<div class='header'> <h1>Jeux vidéo : </h1></div>");

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

