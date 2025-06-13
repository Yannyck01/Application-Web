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

} catch(EntityNotFoundException) {
    header('HTTP/1.1 404 Not Found');
    echo "Jeu avec l'ID $gameId n'a pas été trouvé !";
    exit();
}
$webPage = new WebPage();
$webPage->setTitle("Jeux vidéo : {$webPage->escapeString($game->getName())}");
$webPage->appendCssUrl("css/style.css");
$webPage->appendContent(<<<HTML
    <div class='header'> 
    <a href="index.php" class="homepage">
        <button class ='homepage' type='button' >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
              <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
              <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
            </svg>
        </button>
    </a>
        <h1>Jeux vidéo : {$webPage->escapeString($game->getName())}</h1>
    </div>
    <form method="POST" action="admin/game-delete.php?gameId={$game->getId()}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce jeu ? Cette action est irréversible.');" style="display:inline;">
        <button type="submit" class="delete-button" style="background-color: #d9534f; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
            Supprimer
        </button>
    </form>
HTML);
$webPage->appendContent('<div class="list">');
$priceEuro=$game->getPrice()/100;
$dev = Developer::findById($game->getDeveloperId());

$webPage->appendContent(<<<HTML
<div class="gameD__container">
  <div class="gameD__left">
    <div class="gameD__poster">
      <img src="poster.php?posterId={$game->getPosterId()}" alt="Affiche du jeu">
    </div>
    <div class="gameD__platforms-year">
        <div class="gameD__platforms">
HTML);
if ($game->getWindows()) {
    $webPage->appendContent('<img src="img/windows-brands.svg" alt="Windows" class="platform-icon">');
}
if ($game->getMac()) {
    $webPage->appendContent('<img src="img/apple-brands.svg" alt="MacOs" class="platform-icon">');
}
if ($game->getLinux()) {
    $webPage->appendContent('<img src="img/linux-brands.svg" alt="Linux" class="platform-icon">');
}
$webPage->appendContent(<<<HTML
      </div>
      <div class="gameD__year">{$game->getReleaseYear()}</div>
    </div>

    <div class="gameD__dev">Développé par : {$webPage->escapeString($dev->getName())}</div>
  </div>

  <div class="gameD__right">
    <div class="gameD__rating-price">
HTML);

if (empty($game->getMetacritic()))
    $webPage->appendContent("<div class='gameD__note'>Pas de note</div>");
else
    $webPage->appendContent("<div class='gameD__note'>{$game->getMetacritic()}/100</div>");


if ($priceEuro == 0){
    $webPage->appendContent("<div class='gameD__price'>Gratuit</div>");
} else {
    $webPage->appendContent("<div class='gameD__price'>{$priceEuro}€</div>");
}

$webPage->appendContent(<<<HTML
    </div>
    <div class="gameD__desc">{$game->getShortDescription()}</div>
  </div>
</div>

<div class="gameD__genres-ctg">
  <div class='gameD__genres'><h3>Genres :</h3><div class="gameD__genre-list">
HTML);

$genres=GenreCollection::findByGameId((int) $gameId);
foreach ($genres as $genre) {
    $webPage->appendContent("<div class='gameD__genre'><p><a href='genre.php?genreId={$genre->getId()}'>{$webPage->escapeString($genre->getDescription())}</a></p></div>");
}

$categories=CategoryCollection::findByGameId((int) $gameId);
$webPage->appendContent("</div></div><div class='gameD__ctg'><h3>Catégories :</h3>");

foreach ($categories as $category){
    $webPage->appendContent("<div class='gameD__genre'><p><a href='category.php?idCtg={$category->getId()}'>{$webPage->escapeString($category->getDescription())}</a></p></div>");
}

$webPage->appendContent("</div></div></div>");


echo $webPage->toHTML();