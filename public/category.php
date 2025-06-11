<?php
declare(strict_types=1);


use Entity\Category;
use Entity\Exception\EntityNotFoundException;
use Entity\Game;
use Html\WebPage;

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

$catObject=Category::findById((int) $categoryId);
$categoryPage = new WebPage();
$categoryPage->setTitle("Jeux vidéo : {$categoryPage->escapeString($catObject->getDescription())}");
$categoryPage->appendCssUrl("css/style.css");
$categoryPage->appendContent("<div class='header'> <h1>Jeux vidéo : {$categoryPage->escapeString($catObject->getDescription())} </h1></div>");

$categoryPage->appendContent("<div class='list'>");
foreach ($category as $game){

    $year = $game->getReleaseYear();
    $title = $game->getName();
    $posterId = $game->getPosterId();
    $description = $game->getShortDescription();
    $categoryPage->appendContent(<<<HTML
                <div class="all_games">
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
                </div>
HTML);

}
$categoryPage->appendContent("</div>");
echo $categoryPage->toHTML();