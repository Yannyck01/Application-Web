<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Poster;
use Exception\ParameterException;

try {
    if (!isset($_GET['posterId']) || !ctype_digit($_GET['posterId'])) {
        throw new ParameterException("Paramètre 'posterId' absent ou non numérique.");
    }

    $posterId = (int) $_GET['posterId'];
    $poster = Poster::findById($posterId);

    if (!$poster) {
        throw new EntityNotFoundException("Poster avec ID $posterId introuvable.");
    }

    header('Content-Type: image/jpeg');
    echo $poster->getJpeg();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
