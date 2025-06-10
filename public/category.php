<?php
declare(strict_types=1);


use Entity\Exception\EntityNotFoundException;
use Entity\Game;
use Html\AppWebPage;

if (isset($_GET['idCtg']) && ctype_digit($_GET['idCtg'])) {
    $categoryId = $_GET['idCtg'];
} else {
    header('Location: index.php', true, 302);
    exit();
}

try{
    $category = Game::findByCategoryId((int)$categoryId);

} catch(EntityNotFoundException $e) {
    header('HTTP/1.1 404 Not Found');
    exit();
}
$categoryPage = new AppWebPage("Jeux vidéo : ");

$categoryPage->appendContent("<div class='list'>");
foreach ($category as $game){

    $year = $game->getReleaseYear();
    $title = $game->getName();
    $posterId = $game->getPosterId();
    $description = $game->getShortDescription();
    $categoryPage->appendContent(<<<HTML
                <div class="game">
                    <div class="game__cover"><img src="poster.php?posterId=$posterId"></div>
                    <div class="game__details">
                        <div class="game__year">$year</div>
                        <div class="game__name">$title</div>
                        <div class="game__desc">$description</div>
                    </div>
                </div>
HTML);
}
$categoryPage->appendContent("</div>");
echo $categoryPage->toHTML();