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
$categoryPage->appendContent(<<<HTML
    <div class='header'> 
    <a href="index.php" class="homepage">
        <button class ='homepage' type='button' >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
              <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
              <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
            </svg>
        </button>
    </a>
        <h1>Jeux vidéo : {$categoryPage->escapeString($catObject->getDescription())} </h1>
    </div> 
HTML);

$categoryPage->appendContent("<div class='list'>");
foreach ($category as $game){

    $year = $game->getReleaseYear();
    $title = $game->getName();
    $posterId = $game->getPosterId();
    $description = $game->getShortDescription();
    $categoryPage->appendContent(<<<HTML
                <div class="game" onclick="window.location.href='game.php?gameId={$game->getId()}';" style="cursor: pointer;" data-title="{$title}" data-year="{$year}">
                    <div class="game__cover"><img src="poster.php?posterId=$posterId"></div>
                    <div class="game__details">
                            <div class="game__details2">
                                <div class="game__name">$title</div>
                                <div class="game__year"> ($year)</div>
                            </div>
                            <div class="game__desc">$description</div>
                    </div>
                </div> 
                <div class="sort-menu">
                    <label for="sort-select">Trier par :</label>
                    <select id="sort-select">
                        <option value="">Choisissez...</option>
                        <option value="title">Titre</option>
                        <option value="year">Année</option>
                    </select>
                </div>
HTML);

}
$categoryPage->appendContent("</div>");
$categoryPage->appendContent(<<<JS
<script>
    const list = document.querySelector('.list');
    const originalGames = Array.from(list.querySelectorAll('.game')); // ordre initial

    document.getElementById('sort-select').addEventListener('change', function () {
        const sortBy = this.value;
        let games;

        if (sortBy === 'title') {
            games = [...originalGames].sort((a, b) => a.dataset.title.localeCompare(b.dataset.title));
        } else if (sortBy === 'year') {
            games = [...originalGames].sort((a, b) => parseInt(a.dataset.year) - parseInt(b.dataset.year));
        } else {
            games = [...originalGames];
        }

        list.innerHTML = '';
        games.forEach(game => list.appendChild(game));
    });
</script>
JS);
echo $categoryPage->toHTML();