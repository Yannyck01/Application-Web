<?php
declare(strict_types=1);


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

$categoryPage = new WebPage("Jeux vidéo : ");
$categoryPage->appendCssUrl("css/style.css");
$categoryPage->appendContent("<div class='header'> <h1>Jeux vidéo : </h1></div>");

$categoryPage->appendContent("<div class='list'>");
foreach ($category as $game){

    $year = $game->getReleaseYear();
    $title = $game->getName();
    $posterId = $game->getPosterId();
    $description = $game->getShortDescription();
    $categoryPage->appendContent(<<<HTML
                <style>
                .game  {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    gap: 1.5rem; /* space between image and text */
                    padding: 1rem 2rem;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
                    transition: box-shadow 0.3s ease;
                }
                
                /* Cover image container */
                .game__cover {
                    flex-shrink: 0; /* prevent shrinking */
                    width: 20%;
                    height: auto;
                    border-radius: 12px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    background-color: #ffffff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                }
                .game__cover img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 12px;
                }
                .game__details {
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                    flex: 1;
                }
                .game__year {
                    font-weight: 600;
                    font-size: 0.9rem;
                    color: #30190a;
                    margin-bottom: 0.25rem;
                }
                .game__name {
                    font-size: 1.5rem;
                    font-weight: 700;
                    margin-bottom: 0.5rem;
                    color: #08417a;
                }
                .game__desc {
                    font-size: 1rem;
                    line-height: 1.4;
                    color: rgba(31,35,31,0.88);
                }
                
                
                </style>
                <div class="all_games">
                <div class="game">
                        <div class="game__cover"><img src="poster.php?posterId=$posterId"></div>
                        <div class="game__details">
                            <div class="game__year">$year</div>
                            <div class="game__name">$title</div>
                            <div class="game__desc">$description</div>
                        </div>
                    </div>
                </div>
HTML
    );
}
$categoryPage->appendContent("</div>");
echo $categoryPage->toHTML();