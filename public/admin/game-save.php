<?php
declare(strict_types=1);


try {
    $gameForm = new \Entity\form\GameForm();
    $gameForm->setFromQueryString();
    $gameForm->getGame()->save();
    header("Location index.php");
} catch(\Exception\ParameterException) {
    http_response_code(400);
    echo "L'un des champs nécessaire à la création du jeu n'est pas renseigné";
}