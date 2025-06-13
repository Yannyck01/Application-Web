<?php
declare(strict_types=1);


use Entity\Form\GameForm;

try {
    $gameForm = new GameForm();
    $gameForm->setEntityFromQueryString();
    $gameForm->getGame()->save();
    header("Location: /index.php");
} catch(\Exception\ParameterException) {
    http_response_code(400);
    echo "L'un des champs nécessaire à la création du jeu n'est pas renseigné";
}