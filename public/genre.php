<?php
declare(strict_types=1);

use Entity\Game;
use html\WebPage;

if (isset($_GET['genreId']) && ctype_digit($_GET['genreId'])) {
    $genred = $_GET['genreId'];
} else {
    header('Location: index.php', true, 302);
    exit();
}


$games=Game::findByGenreId((int)$genred);
$webPage = new AppWebPage("Jeux vidéo : ");

$webPage->appendContent('<div class="list">');
foreach ($games as $game) {
    $year = $game->getReleaseYear();
    $title = $game->getName();
    $posterId = $game->getPosterId();
    $description = $game->getShortDescription();
    $webPage->appendContent(<<<HTML
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
                    color: #5e1205;
                    margin-bottom: 0.25rem;
                }
                .game__name {
                    font-size: 1.5rem;
                    font-weight: 700;
                    margin-bottom: 0.5rem;
                    color: #210965;
                }
                .game__desc {
                    font-size: 1rem;
                    line-height: 1.4;
                    color: rgba(2,44,33,0.88);
                }
                
                
                </style>
                
                <link rel="stylesheet" href="public/css/style.css"/>
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

