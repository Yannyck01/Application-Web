<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Game;
use Exception\ParameterException;

try {
    if (!isset($_GET['gameId']) || !is_numeric($_GET['gameId'])) {
        throw new ParameterException("Paramètre 'gameId' non présent et/ou non numérique.");
    } else {
        $artist = Game::findById((int)$_GET['gameId']);
        $artist->delete();
        header("Location: /index.php");
    }
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
