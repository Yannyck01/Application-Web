<?php
declare(strict_types=1);

use Database\MyPdo;
use Entity\Game;
use html\WebPage;

$idVoulu = "Unknown";
if (isset($_GET['idGenre'])&& ctype_digit($_GET['idGenre'])) {
    $idGenre = (int) $_GET['idGenre'];
}

$genreDesc = new \Html\WebPage("genre description");

$genreRequest =  Game::findByGenreId($idGenre);

